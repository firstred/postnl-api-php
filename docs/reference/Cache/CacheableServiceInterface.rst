.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CacheableServiceInterface
=========================


.. php:namespace:: Firstred\PostNL\Cache

.. php:interface:: CacheableServiceInterface


	:Parent:
		:php:interface:`Firstred\\PostNL\\Service\\ServiceInterface`
	
	:Parent:
		:php:interface:`Firstred\\PostNL\\Clock\\ClockAwareInterface`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public cacheResponseItem\($item\)<Firstred\\PostNL\\Cache\\CacheableServiceInterface::cacheResponseItem\(\)>`
* :php:meth:`public retrieveCachedResponseItem\($cacheableRequestEntity\)<Firstred\\PostNL\\Cache\\CacheableServiceInterface::retrieveCachedResponseItem\(\)>`
* :php:meth:`public removeCachedResponseItem\($item\)<Firstred\\PostNL\\Cache\\CacheableServiceInterface::removeCachedResponseItem\(\)>`
* :php:meth:`public getTtl\(\)<Firstred\\PostNL\\Cache\\CacheableServiceInterface::getTtl\(\)>`
* :php:meth:`public setTtl\($ttl\)<Firstred\\PostNL\\Cache\\CacheableServiceInterface::setTtl\(\)>`
* :php:meth:`public getCache\(\)<Firstred\\PostNL\\Cache\\CacheableServiceInterface::getCache\(\)>`
* :php:meth:`public setCache\($cache\)<Firstred\\PostNL\\Cache\\CacheableServiceInterface::setCache\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public cacheResponseItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Cache an item\.
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Since: 2.0.0 
	
	

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

	.. php:method:: public removeCachedResponseItem( $item)
	
		.. rst-class:: phpdoc-description
		
			| Delete an item from cache\.
			
		
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
		:Since: 2.0.0 
	
	

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
	
	

