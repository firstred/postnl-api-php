.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LabellingService
================


.. php:namespace:: Firstred\PostNL\Service

.. php:class:: LabellingService


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\AbstractService`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\LabellingServiceInterface` 
	
	:Used traits:
		:php:trait:`Firstred\\PostNL\\Service\\ResponseProcessor\\ResponseProcessorSettersTrait` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($apiKey, $sandbox, $httpClient, $requestFactory, $streamFactory, $cache, $ttl\)<Firstred\\PostNL\\Service\\LabellingService::\_\_construct\(\)>`
* :php:meth:`public generateLabel\($generateLabel, $confirm\)<Firstred\\PostNL\\Service\\LabellingService::generateLabel\(\)>`
* :php:meth:`public generateLabels\($generateLabels\)<Firstred\\PostNL\\Service\\LabellingService::generateLabels\(\)>`


Properties
----------

.. php:attr:: protected static requestBuilder



.. php:attr:: protected static responseProcessor



.. php:attr:: private insuranceProductCodes



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

	.. php:method:: public generateLabel( $generateLabel, $confirm=true)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode\.
			
		
		
		:Parameters:
			* **$generateLabel** (:any:`Firstred\\PostNL\\Entity\\Request\\GenerateLabel <Firstred\\PostNL\\Entity\\Request\\GenerateLabel>`)  
			* **$confirm** (bool)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse <Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public generateLabels( $generateLabels)
	
		.. rst-class:: phpdoc-description
		
			| Generate multiple labels at once\.
			
		
		
		:Parameters:
			* **$generateLabels** (:any:`array<int <array<int>` | :any:`string,array\{0: \\Firstred\\PostNL\\Entity\\Request\\GenerateBarcode, 1: bool\}\> <string,array\{0: \\Firstred\\PostNL\\Entity\\Request\\GenerateBarcode, 1: bool\}\>>`)  

		
		:Returns: :any:`array<int <array<int>` | :any:`string,\\Firstred\\PostNL\\Entity\\Response\\GenerateBarcodeResponse\> <string,\\Firstred\\PostNL\\Entity\\Response\\GenerateBarcodeResponse\>>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiException <Firstred\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 1.0.0 
	
	

