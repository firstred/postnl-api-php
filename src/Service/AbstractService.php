<?php
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Exception\CifDownException;
use Firstred\PostNL\Exception\CifException;
use Firstred\PostNL\Exception\HttpClientException;
use Firstred\PostNL\Exception\InvalidConfigurationException;
use Firstred\PostNL\Exception\InvalidMethodException;
use Firstred\PostNL\Exception\ResponseException;
use Firstred\PostNL\PostNL;
use GuzzleHttp\Psr7\Response;
use JsonException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionException;
use Sabre\Xml\Writer;
use SimpleXMLElement;
use function get_object_vars;
use function is_array;

/**
 * Class AbstractService.
 *
 * @since 1.0.0
 */
abstract class AbstractService
{
    /**
     * @var array
     * @internal
     */
    public static $namespaces = [];

    /**
     * @var PostNL
     * @internal
     */
    protected $postnl;

    /** @internal */
    const COMMON_NAMESPACE = 'http://postnl.nl/cif/services/common/';
    /** @internal */
    const XML_SCHEMA_NAMESPACE = 'http://www.w3.org/2001/XMLSchema-instance';
    /** @internal */
    const ENVELOPE_NAMESPACE = 'http://schemas.xmlsoap.org/soap/envelope/';
    /** @internal */
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
     * @internal
     */
    public $ttl = null;

    /**
     * The [PSR-6](https://www.php-fig.org/psr/psr-6/) CacheItemPoolInterface.
     *
     * Use a caching library that implements [PSR-6](https://www.php-fig.org/psr/psr-6/) and you'll be good to go
     * `null` disables the cache
     *
     * @var CacheItemPoolInterface|null
     * @internal
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
     * @internal
     */
    public function __call($name, $args)
    {
        $mode = (PostNL::MODE_REST === $this->postnl->getMode()
            || $this instanceof ShippingServiceInterface
            || $this instanceof ShippingStatusServiceInterface
        ) ? 'Rest' : 'Soap';

        if (method_exists($this, "$name$mode")) {
            return call_user_func_array([$this, "$name$mode"], $args);
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
     * @since 1.0.0
     */
    public function setService($object)
    {
        if (!$object instanceof AbstractEntity) {
            return false;
        }

        try {
            $reflection = new ReflectionClass(get_called_class());
        } catch (ReflectionException $e) {
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
     * Register namespaces.
     *
     * @param SimpleXMLElement $element
     *
     * @since 1.0.0
     * @internal
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
     * @throws CifDownException
     * @throws CifException
     * @throws HttpClientException
     * @throws ResponseException
     * @throws InvalidConfigurationException
     *
     * @since 1.0.0
     * @internal
     */
    public static function validateRESTResponse($response)
    {
        $body = json_decode(static::getResponseText($response));
        if (json_last_error() !== JSON_ERROR_NONE) {
            $previous = new JsonException(json_last_error_msg(), json_last_error());

            throw new ResponseException('Could not parse response', 0, $previous, $response);
        }

        if (!empty($body->fault->faultstring) && 'Invalid ApiKey' === $body->fault->faultstring) {
            throw new InvalidConfigurationException('Invalid Api Key');
        }
        if (isset($body->Envelope->Body->Fault->Reason->Text)) {
            $vars = get_object_vars($body->Envelope->Body->Fault->Reason->Text);
            throw new CifDownException(isset($vars['']) ? $vars[''] : 'Unknown');
        }

        if (!empty($body->Errors->Error)) {
            $exceptionData = [];
            foreach ($body->Errors->Error as $errorMsg) {
                if (isset($errorMsg->ErrorMsg)) {
                    $exceptionData[] = [
                        'description' => $errorMsg->ErrorMsg,
                        'message'     => $errorMsg->ErrorMsg,
                        'code'        => isset($errorMsg->ErrorNumber) ? (int) $errorMsg->ErrorNumber : 0,
                    ];
                } else {
                    $exceptionData[] = [
                        'description' => isset($errorMsg->Description) ? (string) $errorMsg->Description : null,
                        'message'     => null,
                        'code'        => isset($errorMsg->ErrorNumber) ? (int) $errorMsg->ErrorNumber : 0,
                    ];
                }
            }
            throw new CifException($exceptionData);
        } elseif (!empty($body->Errors)) {
            $exceptionData = [];
            foreach ($body->Errors as $errorMsg) {
                if (isset($errorMsg->ErrorMsg)) {
                    $exceptionData[] = [
                        'description' => $errorMsg->ErrorMsg,
                        'message'     => $errorMsg->ErrorMsg,
                        'code'        => isset($errorMsg->ErrorNumber) ? (int) $errorMsg->ErrorNumber : 0,
                    ];
                } else {
                    $exceptionData[] = [
                        'description' => isset($errorMsg->Description) ? (string) $errorMsg->Description : null,
                        'message'     => isset($errorMsg->Error) ? (string) $errorMsg->Error : null,
                        'code'        => isset($errorMsg->Code) ? (int) $errorMsg->Code : 0,
                    ];
                }
            }
            throw new CifException($exceptionData);
        } elseif (!empty($body->Array->Item->ErrorMsg)) {
            // {"Array":{"Item":{"ErrorMsg":"Unknown option GetDeliveryDate.Options='DayTime' specified","ErrorNumber":26}}}
            $exceptionData = [[
                'description' => isset($body->Array->Item->ErrorMsg) ? (string) $body->Array->Item->ErrorMsg : null,
                'message'     => isset($body->Array->Item->ErrorMsg) ? (string) $body->Array->Item->ErrorMsg : null,
                'code'        => 0,
            ]];
            throw new CifException($exceptionData);
        } elseif (isset($body->ResponseShipments)
            && is_array($body->ResponseShipments)
            && isset($body->ResponseShipments[0]->Errors)
            && is_array($body->ResponseShipments[0]->Errors)
            && !empty($body->ResponseShipments[0]->Errors)
        ) {
            $errorMsg = $body->ResponseShipments[0]->Errors[0];

            $exceptionData = [[
                'message'     => isset($errorMsg->message) ? (string) $errorMsg->message : null,
                'description' => isset($errorMsg->description) ? (string) $errorMsg->description : null,
                'code'        => isset($errorMsg->code) ? (int) $errorMsg->code : 0,
            ]];
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
     * @internal
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
     *
     * @throws PsrCacheInvalidArgumentException
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
     * @throws PsrCacheInvalidArgumentException
     *
     * @since 1.2.0
     */
    public function removeCachedItem(CacheItemInterface $item)
    {
        $this->cache->deleteItem($item->getKey());
    }

    /**
     * @return DateInterval|DateTimeInterface|int|null
     *
     * @since 1.2.0
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param int|DateTimeInterface|DateInterval|null $ttl
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setTtl($ttl = null)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @return CacheItemPoolInterface|null
     *
     * @since 1.2.0
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param CacheItemPoolInterface|null $cache
     *
     * @return static
     *
     * @since 1.2.0
     */
    public function setCache($cache = null)
    {
        $this->cache = $cache;

        return $this;
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
