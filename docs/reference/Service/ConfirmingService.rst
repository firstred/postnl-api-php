.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ConfirmingService
=================


.. php:namespace:: Firstred\PostNL\Service

.. php:class:: ConfirmingService


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\AbstractService`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\ConfirmingServiceInterface` 
	
	:Used traits:
		:php:trait:`Firstred\\PostNL\\Service\\ResponseProcessor\\ResponseProcessorSettersTrait` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($apiKey, $sandbox, $httpClient, $requestFactory, $streamFactory, $cache, $ttl\)<Firstred\\PostNL\\Service\\ConfirmingService::\_\_construct\(\)>`
* :php:meth:`public confirmShipment\($confirming\)<Firstred\\PostNL\\Service\\ConfirmingService::confirmShipment\(\)>`
* :php:meth:`public confirmShipments\($confirms\)<Firstred\\PostNL\\Service\\ConfirmingService::confirmShipments\(\)>`


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

	.. php:method:: public confirmShipment( $confirming)
	
		.. rst-class:: phpdoc-description
		
			| Confirm a single shipment via REST\.
			
		
		
		:Parameters:
			* **$confirming** (:any:`Firstred\\PostNL\\Entity\\Request\\Confirming <Firstred\\PostNL\\Entity\\Request\\Confirming>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment <Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public confirmShipments( $confirms)
	
		.. rst-class:: phpdoc-description
		
			| Confirm multiple shipments\.
			
		
		
		:Parameters:
			* **$confirms** (:any:`array<string,\\Firstred\\PostNL\\Entity\\Request\\Confirming\> <array<string,\\Firstred\\PostNL\\Entity\\Request\\Confirming\>>`)  ['uuid' => Confirming, ...]

		
		:Returns: :any:`array<string,\\Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment\> <array<string,\\Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment\>>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ReflectionException <ReflectionException>` 
		:Since: 1.0.0 
	
	

