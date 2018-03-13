.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractService
===============


.. php:namespace:: ThirtyBees\PostNL\Service

.. rst-class::  abstract

.. php:class:: AbstractService


	.. rst-class:: phpdoc-description
	
		| Class AbstractService
		
	

Constants
---------

.. php:const:: COMMON_NAMESPACE = http://postnl\.nl/cif/services/common/



.. php:const:: XML_SCHEMA_NAMESPACE = http://www\.w3\.org/2001/XMLSchema\-instance



.. php:const:: ENVELOPE_NAMESPACE = http://schemas\.xmlsoap\.org/soap/envelope/



.. php:const:: OLD_ENVELOPE_NAMESPACE = http://www\.w3\.org/2003/05/soap\-envelope



Properties
----------

.. php:attr:: public namespaces

	:Type: array 


.. php:attr:: protected static postnl

	:Type: :any:`\\ThirtyBees\\PostNL\\PostNL <ThirtyBees\\PostNL\\PostNL>` 


.. php:attr:: public static ttl

	.. rst-class:: phpdoc-description
	
		| TTL for the cache
		
		| \`null\` disables the cache
		| \`int\` is the TTL in seconds
		| Any \`DateTime\` will be used as the exact date/time at which to expire the data \(auto calculate TTL\)
		| A \`DateInterval\` can be used as well to set the TTL
		
	
	:Type: null | int | :any:`\\DateTimeInterface <DateTimeInterface>` | :any:`\\DateInterval <DateInterval>` 


.. php:attr:: public static cache

	.. rst-class:: phpdoc-description
	
		| The \[PSR\-6\]\(https://www\.php\-fig\.org/psr/psr\-6/\) CacheItemPoolInterface
		
		| Use a caching library that implements \[PSR\-6\]\(https://www\.php\-fig\.org/psr/psr\-6/\) and you\'ll be good to go
		| \`null\` disables the cache
		
	
	:Type: null | :any:`\\Psr\\Cache\\CacheItemPoolInterface <Psr\\Cache\\CacheItemPoolInterface>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $postnl, $cache=null, $ttl=null)
	
		.. rst-class:: phpdoc-description
		
			| AbstractService constructor\.
			
		
		
		:Parameters:
			* **$postnl** (:any:`ThirtyBees\\PostNL\\PostNL <ThirtyBees\\PostNL\\PostNL>`)  PostNL instance
			* **$cache** (null | :any:`\\Psr\\Cache\\CacheItemPoolInterface <Psr\\Cache\\CacheItemPoolInterface>`)  
			* **$ttl** (null | int | :any:`\\DateTimeInterface <DateTimeInterface>` | :any:`\\DateInterval <DateInterval>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public __call( $name, $args)
	
		
		:Parameters:
			* **$name** (string)  
			* **$args** (mixed)  

		
		:Returns: mixed 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidMethodException <ThirtyBees\\PostNL\\Exception\\InvalidMethodException>` 
	
	

.. rst-class:: public

	.. php:method:: public setService( $object)
	
		.. rst-class:: phpdoc-description
		
			| Set the webservice on the object
			
			| This lets the object know for which service it should serialize
			
		
		
		:Parameters:
			* **$object** (:any:`ThirtyBees\\PostNL\\Entity\\AbstractEntity <ThirtyBees\\PostNL\\Entity\\AbstractEntity>`)  

		
		:Returns: bool 
	
	

.. rst-class:: public static

	.. php:method:: public static registerNamespaces( $element)
	
		.. rst-class:: phpdoc-description
		
			| Register namespaces
			
		
		
		:Parameters:
			* **$element** (:any:`SimpleXMLElement <SimpleXMLElement>`)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static validateRESTResponse( $response)
	
		
		:Parameters:
			* **$response** (:any:`GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` | :any:`\\Exception <Exception>`)  

		
		:Returns: bool 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
	
	

.. rst-class:: public static

	.. php:method:: public static validateSOAPResponse( $xml)
	
		
		:Parameters:
			* **$xml** (:any:`SimpleXMLElement <SimpleXMLElement>`)  

		
		:Returns: bool 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
	
	

.. rst-class:: public static

	.. php:method:: public static getResponseText( $response)
	
		.. rst-class:: phpdoc-description
		
			| Get the response
			
		
		
		:Parameters:
			* **$response**  

		
		:Returns: string 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public retrieveCachedItem( $uuid)
	
		.. rst-class:: phpdoc-description
		
			| Retrieve a cached item
			
		
		
		:Parameters:
			* **$uuid** (string)  

		
		:Returns: null | :any:`\\Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public cacheItem( $item)
	
		
		:Parameters:
			* **$item** (:any:`Psr\\Cache\\CacheItemInterface <Psr\\Cache\\CacheItemInterface>`)  

		
	
	

