.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TimeframeService
================


.. php:namespace:: Firstred\PostNL\Service

.. php:class:: TimeframeService


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\AbstractService`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\TimeframeServiceInterface` 
	
	:Used traits:
		:php:trait:`Firstred\\PostNL\\Service\\ResponseProcessor\\ResponseProcessorSettersTrait` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($apiKey, $sandbox, $httpClient, $requestFactory, $streamFactory, $cache, $ttl\)<Firstred\\PostNL\\Service\\TimeframeService::\_\_construct\(\)>`
* :php:meth:`public getTimeframes\($getTimeframes\)<Firstred\\PostNL\\Service\\TimeframeService::getTimeframes\(\)>`


Properties
----------

.. php:attr:: protected static requestBuilder



.. php:attr:: protected static responseProcessor



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

	.. php:method:: public getTimeframes( $getTimeframes)
	
		.. rst-class:: phpdoc-description
		
			| Get timeframes via REST\.
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`Firstred\\PostNL\\Entity\\Request\\GetTimeframes <Firstred\\PostNL\\Entity\\Request\\GetTimeframes>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes <Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Since: 1.0.0 
	
	

