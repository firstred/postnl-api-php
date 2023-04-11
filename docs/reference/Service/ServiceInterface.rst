.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ServiceInterface
================


.. php:namespace:: Firstred\PostNL\Service

.. php:interface:: ServiceInterface




Summary
-------

Methods
~~~~~~~

* :php:meth:`public cacheItem\($item\)<Firstred\\PostNL\\Service\\ServiceInterface::cacheItem\(\)>`
* :php:meth:`public retrieveCachedItem\($uuid\)<Firstred\\PostNL\\Service\\ServiceInterface::retrieveCachedItem\(\)>`
* :php:meth:`public removeCachedItem\($item\)<Firstred\\PostNL\\Service\\ServiceInterface::removeCachedItem\(\)>`
* :php:meth:`public getTtl\(\)<Firstred\\PostNL\\Service\\ServiceInterface::getTtl\(\)>`
* :php:meth:`public setTtl\($ttl\)<Firstred\\PostNL\\Service\\ServiceInterface::setTtl\(\)>`
* :php:meth:`public getCache\(\)<Firstred\\PostNL\\Service\\ServiceInterface::getCache\(\)>`
* :php:meth:`public setCache\($cache\)<Firstred\\PostNL\\Service\\ServiceInterface::setCache\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public cacheItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Cache an item\.
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
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

	.. php:method:: public removeCachedItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Delete an item from cache\.
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getTtl()
	
		
		:Returns: :any:`\\DateInterval <DateInterval>` | :any:`\\DateTimeInterface <DateTimeInterface>` | int | null 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setTtl(\\DateInterval|\\DateTimeInterface|int $ttl=null)
	
		
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
	
	

