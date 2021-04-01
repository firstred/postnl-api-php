.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractService
===============


.. php:namespace:: Firstred\PostNL\Service

.. rst-class::  abstract

.. php:class:: AbstractService


	.. rst-class:: phpdoc-description
	
		| Class AbstractService\.
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($postnl, $cache, $ttl\)<Firstred\\PostNL\\Service\\AbstractService::\_\_construct\(\)>`
* :php:meth:`public \_\_call\($name, $args\)<Firstred\\PostNL\\Service\\AbstractService::\_\_call\(\)>`
* :php:meth:`public setService\($object\)<Firstred\\PostNL\\Service\\AbstractService::setService\(\)>`
* :php:meth:`public static registerNamespaces\($element\)<Firstred\\PostNL\\Service\\AbstractService::registerNamespaces\(\)>`
* :php:meth:`public static validateRESTResponse\($response\)<Firstred\\PostNL\\Service\\AbstractService::validateRESTResponse\(\)>`
* :php:meth:`public static validateSOAPResponse\($xml\)<Firstred\\PostNL\\Service\\AbstractService::validateSOAPResponse\(\)>`
* :php:meth:`public static getResponseText\($response\)<Firstred\\PostNL\\Service\\AbstractService::getResponseText\(\)>`
* :php:meth:`public retrieveCachedItem\($uuid\)<Firstred\\PostNL\\Service\\AbstractService::retrieveCachedItem\(\)>`
* :php:meth:`public cacheItem\($item\)<Firstred\\PostNL\\Service\\AbstractService::cacheItem\(\)>`
* :php:meth:`public removeCachedItem\($item\)<Firstred\\PostNL\\Service\\AbstractService::removeCachedItem\(\)>`
* :php:meth:`public getTtl\(\)<Firstred\\PostNL\\Service\\AbstractService::getTtl\(\)>`
* :php:meth:`public setTtl\($ttl\)<Firstred\\PostNL\\Service\\AbstractService::setTtl\(\)>`
* :php:meth:`public getCache\(\)<Firstred\\PostNL\\Service\\AbstractService::getCache\(\)>`
* :php:meth:`public setCache\($cache\)<Firstred\\PostNL\\Service\\AbstractService::setCache\(\)>`
* :php:meth:`public static defaultDateFormat\($writer, $value\)<Firstred\\PostNL\\Service\\AbstractService::defaultDateFormat\(\)>`


Constants
---------

.. php:const:: COMMON_NAMESPACE = \'http://postnl\.nl/cif/services/common/\'



.. php:const:: XML_SCHEMA_NAMESPACE = \'http://www\.w3\.org/2001/XMLSchema\-instance\'



.. php:const:: ENVELOPE_NAMESPACE = \'http://schemas\.xmlsoap\.org/soap/envelope/\'



.. php:const:: OLD_ENVELOPE_NAMESPACE = \'http://www\.w3\.org/2003/05/soap\-envelope\'



Properties
----------

.. php:attr:: public namespaces

	:Type: array 


.. php:attr:: protected static postnl

	:Type: :any:`\\Firstred\\PostNL\\PostNL <Firstred\\PostNL\\PostNL>` 


.. php:attr:: public static ttl

	.. rst-class:: phpdoc-description
	
		| TTL for the cache\.
		
		| \`null\` disables the cache
		| \`int\` is the TTL in seconds
		| Any \`DateTime\` will be used as the exact date/time at which to expire the data \(auto calculate TTL\)
		| A \`DateInterval\` can be used as well to set the TTL
		
	
	:Type: int | :any:`\\DateTimeInterface <DateTimeInterface>` | :any:`\\DateInterval <DateInterval>` | null 


.. php:attr:: public static cache

	.. rst-class:: phpdoc-description
	
		| The \[PSR\-6\]\(https://www\.php\-fig\.org/psr/psr\-6/\) CacheItemPoolInterface\.
		
		| Use a caching library that implements \[PSR\-6\]\(https://www\.php\-fig\.org/psr/psr\-6/\) and you\'ll be good to go
		| \`null\` disables the cache
		
	
	:Type: :any:`\\Psr\\Cache\\CacheItemPoolInterface <Psr\\Cache\\CacheItemPoolInterface>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $postnl, $cache=null, $ttl=null)
	
		.. rst-class:: phpdoc-description
		
			| AbstractService constructor\.
			
		
		
		:Parameters:
			* **$postnl** (:any:`Firstred\\PostNL\\PostNL <Firstred\\PostNL\\PostNL>`)  PostNL instance
			* **$cache** (:any:`Psr\\Cache\\CacheItemPoolInterface <Psr\\Cache\\CacheItemPoolInterface>` | null)  
			* **$ttl** (int | :any:`\\DateTimeInterface <DateTimeInterface>` | :any:`\\DateInterval <DateInterval>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public __call( $name, $args)
	
		
		:Parameters:
			* **$name** (string)  
			* **$args** (mixed)  

		
		:Returns: mixed 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidMethodException <Firstred\\PostNL\\Exception\\InvalidMethodException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setService( $object)
	
		.. rst-class:: phpdoc-description
		
			| Set the webservice on the object\.
			
			| This lets the object know for which service it should serialize
			
		
		
		:Parameters:
			* **$object** (:any:`Firstred\\PostNL\\Entity\\AbstractEntity <Firstred\\PostNL\\Entity\\AbstractEntity>`)  

		
		:Returns: bool 
		:Since: 1.0.0 
	
	

.. rst-class:: public static

	.. php:method:: public static registerNamespaces( $element)
	
		.. rst-class:: phpdoc-description
		
			| Register namespaces\.
			
		
		
		:Parameters:
			* **$element** (:any:`SimpleXMLElement <SimpleXMLElement>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public static

	.. php:method:: public static validateRESTResponse( $response)
	
		
		:Parameters:
			* **$response** (:any:`Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` | :any:`\\Exception <Exception>`)  

		
		:Returns: bool 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public static

	.. php:method:: public static validateSOAPResponse( $xml)
	
		
		:Parameters:
			* **$xml** (:any:`SimpleXMLElement <SimpleXMLElement>`)  

		
		:Returns: bool 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public static

	.. php:method:: public static getResponseText( $response)
	
		.. rst-class:: phpdoc-description
		
			| Get the response\.
			
		
		
		:Parameters:
			* **$response**  

		
		:Returns: string 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public retrieveCachedItem( $uuid)
	
		.. rst-class:: phpdoc-description
		
			| Retrieve a cached item\.
			
		
		
		:Parameters:
			* **$uuid** (string)  

		
		:Returns: :any:`\\Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>` | null 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public cacheItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Cache an item
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public removeCachedItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Delete an item from cache
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getTtl()
	
		
		:Returns: :any:`\\DateInterval <DateInterval>` | :any:`\\DateTimeInterface <DateTimeInterface>` | int | null 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setTtl( $ttl=null)
	
		
		:Parameters:
			* **$ttl** (int | :any:`\\DateTimeInterface <DateTimeInterface>` | :any:`\\DateInterval <DateInterval>` | null)  

		
		:Returns: static 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getCache()
	
		
		:Returns: :any:`\\Psr\\Cache\\CacheItemPoolInterface <Psr\\Cache\\CacheItemPoolInterface>` | null 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setCache( $cache=null)
	
		
		:Parameters:
			* **$cache** (:any:`Psr\\Cache\\CacheItemPoolInterface <Psr\\Cache\\CacheItemPoolInterface>` | null)  

		
		:Returns: static 
		:Since: 1.2.0 
	
	

.. rst-class:: public static

	.. php:method:: public static defaultDateFormat( $writer, $value)
	
		.. rst-class:: phpdoc-description
		
			| Write default date format in XML
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  
			* **$value** (:any:`DateTimeImmutable <DateTimeImmutable>`)  

		
		:Since: 1.2.0 
	
	

