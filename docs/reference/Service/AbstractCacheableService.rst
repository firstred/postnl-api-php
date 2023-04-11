.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractCacheableService
========================


.. php:namespace:: Firstred\PostNL\Service

.. rst-class::  abstract

.. php:class:: AbstractCacheableService


	.. rst-class:: phpdoc-description
	
		| Class AbstractService\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\AbstractService`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Cache\\CacheableServiceInterface` 
	
	:Used traits:
		:php:trait:`Firstred\\PostNL\\Clock\\ClockAwareTrait` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($apiKey, $sandbox, $httpClient, $requestFactory, $streamFactory, $cache, $ttl\)<Firstred\\PostNL\\Service\\AbstractCacheableService::\_\_construct\(\)>`
* :php:meth:`public retrieveCachedResponseItem\($cacheableRequestEntity\)<Firstred\\PostNL\\Service\\AbstractCacheableService::retrieveCachedResponseItem\(\)>`
* :php:meth:`public cacheResponseItem\($item\)<Firstred\\PostNL\\Service\\AbstractCacheableService::cacheResponseItem\(\)>`
* :php:meth:`public removeCachedResponseItem\($item\)<Firstred\\PostNL\\Service\\AbstractCacheableService::removeCachedResponseItem\(\)>`
* :php:meth:`public getTtl\(\)<Firstred\\PostNL\\Service\\AbstractCacheableService::getTtl\(\)>`
* :php:meth:`public setTtl\($ttl\)<Firstred\\PostNL\\Service\\AbstractCacheableService::setTtl\(\)>`
* :php:meth:`public getCache\(\)<Firstred\\PostNL\\Service\\AbstractCacheableService::getCache\(\)>`
* :php:meth:`public setCache\($cache\)<Firstred\\PostNL\\Service\\AbstractCacheableService::setCache\(\)>`


Properties
----------

.. php:attr:: protected static ttl

	.. rst-class:: phpdoc-description
	
		| TTL for the cache\.
		
		| \`null\` disables the cache
		| \`int\` is the TTL in seconds
		| Any \`DateTime\` will be used as the exact date/time at which to expire the data \(auto calculate TTL\)
		| A \`DateInterval\` can be used as well to set the TTL
		
	
	:Type: int | :any:`\\DateTimeInterface <DateTimeInterface>` | :any:`\\DateInterval <DateInterval>` | null 


.. php:attr:: protected static cache

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

	.. php:method:: public retrieveCachedResponseItem( $cacheableRequestEntity)
	
		.. rst-class:: phpdoc-description
		
			| Retrieve a cached item\.
			
		
		
		:Parameters:
			* **$cacheableRequestEntity** (:any:`Firstred\\PostNL\\Cache\\CacheableRequestEntityInterface <Firstred\\PostNL\\Cache\\CacheableRequestEntityInterface>`)  

		
		:Returns: :any:`\\Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>` | null 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public cacheResponseItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Cache an item\.
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Returns: bool 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public removeCachedResponseItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Delete an item from cache\.
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Returns: bool 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Since: 2.0.0 
	
	

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
	
	

