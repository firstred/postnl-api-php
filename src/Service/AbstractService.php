<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Thirty Development, LLC
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
 * is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author    Michael Dekker <michael@thirtybees.com>
 * @copyright 2017-2018 Thirty Development, LLC
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Service;

use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\InvalidMethodException;
use ThirtyBees\PostNL\Exception\ResponseException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class AbstractService
 *
 * @package ThirtyBees\PostNL\Service
 */
abstract class AbstractService
{
    public static $namespaces;

    protected $postnl;

    const COMMON_NAMESPACE = 'http://postnl.nl/cif/services/common/';
    const XML_SCHEMA_NAMESPACE = 'http://www.w3.org/2001/XMLSchema-instance';
    const ENVELOPE_NAMESPACE = 'http://schemas.xmlsoap.org/soap/envelope/';
    const OLD_ENVELOPE_NAMESPACE = 'http://www.w3.org/2003/05/soap-envelope';


    /**
     * TTL for the labelling cache
     *
     * `null` disables the cache
     * `int` is the TTL in seconds
     * Any `DateTime` will be used as the exact date/time at which to expire the data (auto calculate TTL)
     * A `DateInterval` can be used as well to set the TTL
     *
     * @var null|int|\DateTimeInterface|\DateInterval $ttl
     */
    public $ttl = null;

    /**
     * The [PSR-6](https://www.php-fig.org/psr/psr-6/) CacheItemPoolInterface
     *
     * Use a caching library that implements [PSR-6](https://www.php-fig.org/psr/psr-6/) and you'll be good to go
     * `null` disables the cache
     *
     * @var null|CacheItemPoolInterface
     */
    public $cache = null;

    /**
     * AbstractService constructor.
     *
     * @param PostNL                                    $postnl PostNL instance
     * @param null|CacheItemPoolInterface               $cache
     * @param null|int|\DateTimeInterface|\DateInterval $ttl
     */
    public function __construct($postnl, $cache = null, $ttl = null)
    {
        $this->postnl = $postnl;
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    /**
     * @param string $name
     * @param mixed  $args
     *
     * @return mixed
     *
     * @throws InvalidMethodException
     */
    public function __call($name, $args)
    {
        $mode = $this->postnl->getMode() === PostNL::MODE_REST ? 'Rest' : 'Soap';

        if (method_exists($this, "{$name}{$mode}")) {
            return call_user_func_array([$this, "{$name}{$mode}"], $args);
        } elseif (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $args);
        }

        $class = get_called_class();
        throw new InvalidMethodException("`$class::$name` is not a valid method");
    }

    /**
     * Set the webservice on the object
     *
     * This lets the object know for which service it should serialize
     *
     * @param AbstractEntity $object
     *
     * @return bool
     */
    protected function setService($object)
    {
        if (!$object instanceof AbstractEntity) {
            return false;
        }

        try {
            $reflection = new \ReflectionClass(get_called_class());
        } catch (\ReflectionException $e) {
            return false;
        }
        $service = substr($reflection->getShortName(), 0, strlen($reflection->getShortName()) - 7);
        $object->setCurrentService($service);
        $defaultProperties = $object::$defaultProperties;

        foreach (array_keys($defaultProperties[$service]) as $propertyName) {
            $item = $object->{'get'.$propertyName}();
            if ($item instanceof AbstractEntity) {
                $this->setService($item);
            } elseif (is_array($item)) {
                foreach ($item as $child) {
                    if ($child instanceof AbstractEntity) {
                        $this->setService($child);
                    }
                }
            }
        }

        return true;
    }

    /**
     * Register namespaces
     *
     * @param \SimpleXMLElement $element
     */
    protected static function registerNamespaces(\SimpleXMLElement $element)
    {
        foreach (static::$namespaces as $namespace => $prefix) {
            $element->registerXPathNamespace($prefix, $namespace);
        }
    }

    /**
     * @param Response|\Exception $response
     *
     * @return bool
     *
     * @throws CifDownException
     * @throws CifException
     * @throws ResponseException
     * @throws ApiException
     */
    protected function validateRESTResponse($response)
    {
        $body = json_decode(static::getResponseText($response), true);

        if (!empty($body['fault']['faultstring']) && $body['fault']['faultstring'] === 'Invalid ApiKey') {
            throw new ApiException('Invalid Api Key');
        }
        if (isset($body['Envelope']['Body']['Fault']['Reason']['Text'][''])) {
            throw new CifDownException($body['Envelope']['Body']['Fault']['Reason']['Text']['']);
        }

        if (!empty($body['Errors']['Error'])) {
            $exceptionData = [];
            foreach ($body['Errors']['Error'] as $error) {
                $exceptionData[] = [
                    'description' => isset($error['Description']) ? (string) $error['Description'] : null,
                    'message'     => isset($error['ErrorMsg']) ? (string) $error['ErrorMsg'] : null,
                    'code'        => isset($error['ErrorNumber']) ? (int) $error['ErrorNumber'] : 0,
                ];
            }
            throw new CifException($exceptionData);
        }

        return true;
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return bool
     * @throws CifDownException
     * @throws CifException
     */
    protected static function validateSOAPResponse(\SimpleXMLElement $xml)
    {
        if (count($xml->xpath('//env:Fault/env:Reason/env:Text')) >= 1) {
            throw new CifDownException((string) $xml->xpath('//env:Fault/env:Reason/env:Text')[0]);
        }

        // Detect errors
        $cifErrors = $xml->xpath('//common:CifException/common:Errors/common:ExceptionData');
        if (count($cifErrors)) {
            $exceptionData = [];
            foreach ($cifErrors as $error) {
                /** @var \SimpleXMLElement $error */
                static::registerNamespaces($error);
                $exceptionData[] = [
                    'description' => (string) $error->xpath('//common:Description')[0],
                    'message'     => (string) $error->xpath('//common:ErrorMsg')[0],
                    'code'        => (int) $error->xpath('//common:ErrorNumber')[0],
                ];
            }
            throw new CifException($exceptionData);
        }

        return true;
    }

    /**
     * Get the response
     *
     * @param $response
     *
     * @return string
     * @throws ResponseException
     */
    public static function getResponseText($response)
    {
        // Guzzle returned promises
        if (is_array($response)) {
            if (isset($response['reason'])) {
                $response = $response['reason'];
            } elseif (isset($response['value'])) {
                $response = $response['value'];
            }
        }

        if ($response instanceof Response) {
            return (string) $response->getBody();
        } elseif (is_a($response, 'GuzzleHttp\\Exception\\GuzzleException')) {
            $exception = $response;
            if (method_exists($response, 'getResponse')) {
                $response = $response->getResponse();
            }
            if (!$response || $response instanceof $exception) {
                throw $exception;
            }

            /** @var Response $response */
            return (string) $response->getBody();
        } else {
            throw new ResponseException('Unknown response type');
        }
    }

    /**
     * Retrieve a cached item
     *
     * @param string $uuid
     *
     * @return null|CacheItemInterface
     */
    protected function retrieveCachedItem($uuid)
    {
        $uuid .= $this->postnl->getMode() === PostNL::MODE_REST ? 'rest' : 'soap';
        $item = null;
        if ($this->cache instanceof CacheItemPoolInterface && !is_null($this->ttl)) {
            try {
                $item = $this->cache->getItem($uuid);
            } catch (\Psr\Cache\InvalidArgumentException $e) {
            }
        }

        return $item;
    }

    /**
     * @param CacheItemInterface $item
     */
    protected function cacheItem(CacheItemInterface $item)
    {
        if ($this->ttl instanceof \DateInterval || is_int($this->ttl)) {
            // Reset expires at first -- it might have been set
            $item->expiresAt(null);
            // Then set the interval
            $item->expiresAfter($this->ttl);
        } else {
            // Reset expires after first -- it might have been set
            $item->expiresAfter(null);
            // Then set the expiration time
            $item->expiresAt($this->ttl);
        }

        $this->cache->save($item);
    }
}
