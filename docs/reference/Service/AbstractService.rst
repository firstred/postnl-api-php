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

* :php:meth:`public \_\_construct\($apiKey, $sandbox, $httpClient, $requestFactory, $streamFactory, $cache, $ttl\)<Firstred\\PostNL\\Service\\AbstractService::\_\_construct\(\)>`
* :php:meth:`public retrieveCachedItem\($uuid\)<Firstred\\PostNL\\Service\\AbstractService::retrieveCachedItem\(\)>`
* :php:meth:`public cacheItem\($item\)<Firstred\\PostNL\\Service\\AbstractService::cacheItem\(\)>`
* :php:meth:`public removeCachedItem\($item\)<Firstred\\PostNL\\Service\\AbstractService::removeCachedItem\(\)>`
* :php:meth:`public getTtl\(\)<Firstred\\PostNL\\Service\\AbstractService::getTtl\(\)>`
* :php:meth:`public setTtl\($ttl\)<Firstred\\PostNL\\Service\\AbstractService::setTtl\(\)>`
* :php:meth:`public getCache\(\)<Firstred\\PostNL\\Service\\AbstractService::getCache\(\)>`
* :php:meth:`public setCache\($cache\)<Firstred\\PostNL\\Service\\AbstractService::setCache\(\)>`
* :php:meth:`public getApiKey\(\)<Firstred\\PostNL\\Service\\AbstractService::getApiKey\(\)>`
* :php:meth:`public setApiKey\($apiKey\)<Firstred\\PostNL\\Service\\AbstractService::setApiKey\(\)>`
* :php:meth:`public isSandbox\(\)<Firstred\\PostNL\\Service\\AbstractService::isSandbox\(\)>`
* :php:meth:`public setSandbox\($sandbox\)<Firstred\\PostNL\\Service\\AbstractService::setSandbox\(\)>`
* :php:meth:`public getHttpClient\(\)<Firstred\\PostNL\\Service\\AbstractService::getHttpClient\(\)>`
* :php:meth:`public setHttpClient\($httpClient\)<Firstred\\PostNL\\Service\\AbstractService::setHttpClient\(\)>`
* :php:meth:`public getRequestFactory\(\)<Firstred\\PostNL\\Service\\AbstractService::getRequestFactory\(\)>`
* :php:meth:`public setRequestFactory\($requestFactory\)<Firstred\\PostNL\\Service\\AbstractService::setRequestFactory\(\)>`
* :php:meth:`public getStreamFactory\(\)<Firstred\\PostNL\\Service\\AbstractService::getStreamFactory\(\)>`
* :php:meth:`public setStreamFactory\($streamFactory\)<Firstred\\PostNL\\Service\\AbstractService::setStreamFactory\(\)>`


Properties
----------

.. php:attr:: private static ttl

	.. rst-class:: phpdoc-description
	
		| TTL for the cache\.
		
		| \`null\` disables the cache
		| \`int\` is the TTL in seconds
		| Any \`DateTime\` will be used as the exact date/time at which to expire the data \(auto calculate TTL\)
		| A \`DateInterval\` can be used as well to set the TTL
		
	
	:Type: int | :any:`\\DateTimeInterface <DateTimeInterface>` | :any:`\\DateInterval <DateInterval>` | null 


.. php:attr:: private static cache

	.. rst-class:: phpdoc-description
	
		| The \[PSR\-6\]\(https://www\.php\-fig\.org/psr/psr\-6/\) CacheItemPoolInterface\.
		
		| Use a caching library that implements \[PSR\-6\]\(https://www\.php\-fig\.org/psr/psr\-6/\) and you\'ll be good to go
		| \`null\` disables the cache
		
	
	:Type: :any:`\\Psr\\Cache\\CacheItemPoolInterface <Psr\\Cache\\CacheItemPoolInterface>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $apiKey, $sandbox, $httpClient, $requestFactory, $streamFactory, $cache=null, \\DateInterval|\\DateTimeInterface|int $ttl=null)
	
		
		:Parameters:
			* **$apiKey** (:any:`ParagonIE\\HiddenString\\HiddenString <ParagonIE\\HiddenString\\HiddenString>`)  
			* **$sandbox** (bool)  
			* **$httpClient** (:any:`Firstred\\PostNL\\HttpClient\\HttpClientInterface <Firstred\\PostNL\\HttpClient\\HttpClientInterface>`)  
			* **$requestFactory** (:any:`Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>`)  
			* **$streamFactory** (:any:`Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>`)  
			* **$cache** (:any:`Psr\\Cache\\CacheItemPoolInterface <Psr\\Cache\\CacheItemPoolInterface>` | null)  
			* **$ttl** (:any:`DateInterval <DateInterval>` | :any:`\\DateTimeInterface <DateTimeInterface>` | int | null)  

		
	
	

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
		
			| Cache an item\.
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public removeCachedItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Delete an item from cache\.
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getTtl()
	
		
		:Returns: :any:`\\DateInterval <DateInterval>` | :any:`\\DateTimeInterface <DateTimeInterface>` | int | null 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setTtl(\\DateInterval|\\DateTimeInterface|int|null $ttl=null)
	
		
		:Parameters:
			* **$ttl** (:any:`DateInterval <DateInterval>` | :any:`\\DateTimeInterface <DateTimeInterface>` | int | null)  

		
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
	
	

.. rst-class:: public

	.. php:method:: public getApiKey()
	
		
		:Returns: :any:`\\ParagonIE\\HiddenString\\HiddenString <ParagonIE\\HiddenString\\HiddenString>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setApiKey( $apiKey)
	
		
		:Parameters:
			* **$apiKey** (:any:`ParagonIE\\HiddenString\\HiddenString <ParagonIE\\HiddenString\\HiddenString>`)  

		
		:Returns: static 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public isSandbox()
	
		
		:Returns: bool 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setSandbox( $sandbox)
	
		
		:Parameters:
			* **$sandbox** (bool)  

		
		:Returns: static 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getHttpClient()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\HttpClientInterface <Firstred\\PostNL\\HttpClient\\HttpClientInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public setHttpClient( $httpClient)
	
		
		:Parameters:
			* **$httpClient** (:any:`Firstred\\PostNL\\HttpClient\\HttpClientInterface <Firstred\\PostNL\\HttpClient\\HttpClientInterface>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Service\\AbstractService <Firstred\\PostNL\\Service\\AbstractService>` 
	
	

.. rst-class:: public

	.. php:method:: public getRequestFactory()
	
		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setRequestFactory( $requestFactory)
	
		
		:Parameters:
			* **$requestFactory** (:any:`Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>`)  

		
		:Returns: static 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getStreamFactory()
	
		
		:Returns: :any:`\\Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setStreamFactory( $streamFactory)
	
		
		:Parameters:
			* **$streamFactory** (:any:`Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>`)  

		
		:Returns: static 
		:Since: 2.0.0 
	
	

