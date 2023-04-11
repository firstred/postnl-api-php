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
		
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\ServiceInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($apiKey, $sandbox, $httpClient, $requestFactory, $streamFactory\)<Firstred\\PostNL\\Service\\AbstractService::\_\_construct\(\)>`
* :php:meth:`public setApiKey\($apiKey\)<Firstred\\PostNL\\Service\\AbstractService::setApiKey\(\)>`
* :php:meth:`public isSandbox\(\)<Firstred\\PostNL\\Service\\AbstractService::isSandbox\(\)>`
* :php:meth:`public setSandbox\($sandbox\)<Firstred\\PostNL\\Service\\AbstractService::setSandbox\(\)>`
* :php:meth:`public getHttpClient\(\)<Firstred\\PostNL\\Service\\AbstractService::getHttpClient\(\)>`
* :php:meth:`public setHttpClient\($httpClient\)<Firstred\\PostNL\\Service\\AbstractService::setHttpClient\(\)>`
* :php:meth:`public getRequestFactory\(\)<Firstred\\PostNL\\Service\\AbstractService::getRequestFactory\(\)>`
* :php:meth:`public setRequestFactory\($requestFactory\)<Firstred\\PostNL\\Service\\AbstractService::setRequestFactory\(\)>`
* :php:meth:`public getStreamFactory\(\)<Firstred\\PostNL\\Service\\AbstractService::getStreamFactory\(\)>`
* :php:meth:`public setStreamFactory\($streamFactory\)<Firstred\\PostNL\\Service\\AbstractService::setStreamFactory\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $apiKey, $sandbox, $httpClient, $requestFactory, $streamFactory)
	
		
		:Parameters:
			* **$apiKey** (:any:`ParagonIE\\HiddenString\\HiddenString <ParagonIE\\HiddenString\\HiddenString>`)  
			* **$sandbox** (bool)  
			* **$httpClient** (:any:`Firstred\\PostNL\\HttpClient\\HttpClientInterface <Firstred\\PostNL\\HttpClient\\HttpClientInterface>`)  
			* **$requestFactory** (:any:`Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>`)  
			* **$streamFactory** (:any:`Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>`)  

		
	
	

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
	
	

