<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
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
 * @author    Michael Dekker <git@michaeldekker.nl>
 * @copyright 2017-2021 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace ThirtyBees\PostNL\Service;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use Sabre\Xml\Writer;
use SimpleXMLElement;
use ThirtyBees\PostNL\Entity\AbstractEntity;
use ThirtyBees\PostNL\Exception\ApiException;
use ThirtyBees\PostNL\Exception\CifDownException;
use ThirtyBees\PostNL\Exception\CifException;
use ThirtyBees\PostNL\Exception\HttpClientException;
use ThirtyBees\PostNL\Exception\InvalidMethodException;
use ThirtyBees\PostNL\Exception\ResponseException;
use ThirtyBees\PostNL\PostNL;

/**
 * Class AbstractService.
 *
 * @since 1.0.0
 */
abstract class AbstractService
{
    /** @var array */
    public static $namespaces = [];

    /** @var PostNL */
    protected $postnl;

    const COMMON_NAMESPACE = 'http://postnl.nl/cif/services/common/';
    const XML_SCHEMA_NAMESPACE = 'http://www.w3.org/2001/XMLSchema-instance';
    const ENVELOPE_NAMESPACE = 'http://schemas.xmlsoap.org/soap/envelope/';
    const OLD_ENVELOPE_NAMESPACE = 'http://www.w3.org/2003/05/soap-envelope';

    /**
     * TTL for the cache.
     *
     * `null` disables the cache
     * `int` is the TTL in seconds
     * Any `DateTime` will be used as the exact date/time at which to expire the data (auto calculate TTL)
     * A `DateInterval` can be used as well to set the TTL
     *
     * @var int|DateTimeInterface|DateInterval|null
     */
    public $ttl = null;

    /**
     * The [PSR-6](https://www.php-fig.org/psr/psr-6/) CacheItemPoolInterface.
     *
     * Use a caching library that implements [PSR-6](https://www.php-fig.org/psr/psr-6/) and you'll be good to go
     * `null` disables the cache
     *
     * @var CacheItemPoolInterface|null
     */
    public $cache = null;

    /**
     * AbstractService constructor.
     *
     * @param PostNL                                  $postnl PostNL instance
     * @param CacheItemPoolInterface|null             $cache
     * @param int|DateTimeInterface|DateInterval|null $ttl
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
     *
     * @since 1.0.0
     */
    public function __call($name, $args)
    {
        $mode = (PostNL::MODE_REST === $this->postnl->getMode()
            || $this instanceof ShippingServiceInterface
            || $this instanceof ShippingStatusServiceInterface
        ) ? 'Rest' : 'Soap';

        if (method_exists($this, "{$name}{$mode}")) {
            return call_user_func_array([$this, "{$name}{$mode}"], $args);
        } elseif (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $args);
        }

        $class = get_called_class();
        throw new InvalidMethodException("`$class::$name` is not a valid method");
    }

    /**
     * Set the webservice on the object.
     *
     * This lets the object know for which service it should serialize
     *
     * @param AbstractEntity $object
     *
     * @return bool
     *
     * @throws ReflectionException
     *
     * @since 1.0.0
     */
    public function setService($object)
    {
        if (!$object instanceof AbstractEntity) {
            return false;
        }

        $reflection = new ReflectionClass(get_called_class());
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
     * Register namespaces.
     *
     * @param SimpleXMLElement $element
     *
     * @since 1.0.0
     */
    public static function registerNamespaces(SimpleXMLElement $element)
    {
        foreach (static::$namespaces as $namespace => $prefix) {
            $element->registerXPathNamespace($prefix, $namespace);
        }
    }

    /**
     * @param ResponseInterface|Exception $response
     *
     * @return bool
     *
     * @throws ApiException
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     *
     * @since 1.0.0
     */
    public static function validateRESTResponse($response)
    {
        $body = json_decode(static::getResponseText($response));

        if (!empty($body->fault->faultstring) && 'Invalid ApiKey' === $body->fault->faultstring) {
            throw new ApiException('Invalid Api Key');
        }
        if (isset($body->Envelope->Body->Fault->Reason->Text->{''})) {
            throw new CifDownException($body->Envelope->Body->Fault->Reason->Text->{''});
        }

        if (!empty($body->Errors->Error)) {
            $exceptionData = [];
            foreach ($body->Errors->Error as $error) {
                if (isset($error->ErrorMsg)) {
                    $exceptionData[] = [
                        'description' => isset($error->ErrorMsg) ? $error->ErrorMsg : '',
                        'message'     => isset($error->ErrorMsg) ? $error->ErrorMsg : '',
                        'code'        => isset($error->ErrorNumber) ? (int) $error->ErrorNumber : 0,
                    ];
                } else {
                    $exceptionData[] = [
                        'description' => isset($error->Description) ? (string) $error->Description : null,
                        'message'     => isset($error->ErrorMsg) ? (string) $error->ErrorMsg : null,
                        'code'        => isset($error->ErrorNumber) ? (int) $error->ErrorNumber : 0,
                    ];
                }
            }
            throw new CifException($exceptionData);
        }

        if (!empty($body->Errors)) {
            $exceptionData = [];
            foreach ($body->Errors as $error) {
                if (isset($error->ErrorMsg)) {
                    $exceptionData[] = [
                        'description' => isset($error->ErrorMsg) ? $error->ErrorMsg : '',
                        'message'     => isset($error->ErrorMsg) ? $error->ErrorMsg : '',
                        'code'        => isset($error->ErrorNumber) ? (int) $error->ErrorNumber : 0,
                    ];
                } else {
                    $exceptionData[] = [
                        'description' => isset($error->Description) ? (string) $error->Description : null,
                        'message'     => isset($error->Error) ? (string) $error->Error : null,
                        'code'        => isset($error->Code) ? (int) $error->Code : 0,
                    ];
                }
            }
            throw new CifException($exceptionData);
        }

        return true;
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return bool
     *
     * @throws CifDownException
     * @throws CifException
     *
     * @since 1.0.0
     */
    public static function validateSOAPResponse(SimpleXMLElement $xml)
    {
        if (count($xml->xpath('//env:Fault/env:Reason/env:Text')) >= 1) {
            throw new CifDownException((string) $xml->xpath('//env:Fault/env:Reason/env:Text')[0]);
        }

        // Detect errors
        $cifErrors = $xml->xpath('//common:CifException/common:Errors/common:ExceptionData');
        if (count($cifErrors)) {
            $exceptionData = [];
            foreach ($cifErrors as $error) {
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
     * Get the response.
     *
     * @param $response
     *
     * @return string
     *
     * @throws ResponseException
     * @throws HttpClientException
     *
     * @since 1.0.0
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
        } elseif (is_a($response, HttpClientException::class)) {
            $exception = $response;
            if (method_exists($response, 'getResponse')) {
                $response = $response->getResponse();
            }
            if (!$response || $response instanceof $exception) {
                throw $exception;
            }

            /* @var Response $response */
            return (string) $response->getBody();
        } else {
            throw new ResponseException('Unknown response type');
        }
    }

    /**
     * Retrieve a cached item.
     *
     * @param string $uuid
     *
     * @return CacheItemInterface|null
     * @throws InvalidArgumentException
     *
     * @since 1.0.0
     */
    public function retrieveCachedItem($uuid)
    {
        // An integer cache key means it should not be cached
        if (!is_string($uuid)) {
            return null;
        }

        $reflection = new ReflectionClass($this);
        $uuid .= (PostNL::MODE_REST === $this->postnl->getMode()
            || $this instanceof ShippingServiceInterface
            || $this instanceof ShippingStatusServiceInterface
        ) ? 'rest' : 'soap';
        $uuid .= strtolower(substr($reflection->getShortName(), 0, strlen($reflection->getShortName()) - 7));
        $item = null;
        if ($this->cache instanceof CacheItemPoolInterface && !is_null($this->ttl)) {
            $item = $this->cache->getItem($uuid);
        }

        return $item;
    }

    /**
     * Cache an item
     *
     * @param CacheItemInterface $item
     *
     * @since 1.0.0
     */
    public function cacheItem(CacheItemInterface $item)
    {
        if ($this->ttl instanceof DateInterval || is_int($this->ttl)) {
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

    /**
     * Delete an item from cache
     *
     * @param CacheItemInterface $item
     *
     * @since 1.2.0
     */
    public function removeItem(CacheItemInterface $item)
    {
        try {
            $this->cache->deleteItem($item->getKey());
        } catch (InvalidArgumentException $e) {
        }
    }

    /**
     * Write default date format in XML
     *
     * @param Writer            $writer
     * @param DateTimeImmutable $value
     *
     * @since 1.2.0
     */
    public static function defaultDateFormat(Writer $writer, DateTimeImmutable $value)
    {
        $writer->write($value->format('d-m-Y H:i:s'));
    }
}
