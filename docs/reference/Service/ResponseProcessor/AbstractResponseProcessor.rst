.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractResponseProcessor
=========================


.. php:namespace:: Firstred\PostNL\Service\ResponseProcessor

.. rst-class::  abstract

.. php:class:: AbstractResponseProcessor




Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($apiKey, $sandbox, $requestFactory, $streamFactory\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::\_\_construct\(\)>`
* :php:meth:`protected static getResponseText\($response\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::getResponseText\(\)>`
* :php:meth:`public getApiKey\(\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::getApiKey\(\)>`
* :php:meth:`public setApiKey\($apiKey\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::setApiKey\(\)>`
* :php:meth:`public isSandbox\(\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::isSandbox\(\)>`
* :php:meth:`public setSandbox\($sandbox\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::setSandbox\(\)>`
* :php:meth:`public getRequestFactory\(\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::getRequestFactory\(\)>`
* :php:meth:`public setRequestFactory\($requestFactory\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::setRequestFactory\(\)>`
* :php:meth:`public getStreamFactory\(\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::getStreamFactory\(\)>`
* :php:meth:`public setStreamFactory\($streamFactory\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::setStreamFactory\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $apiKey, $sandbox, $requestFactory, $streamFactory)
	
		
		:Parameters:
			* **$apiKey** (:any:`ParagonIE\\HiddenString\\HiddenString <ParagonIE\\HiddenString\\HiddenString>`)  
			* **$sandbox** (bool)  
			* **$requestFactory** (:any:`Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>`)  
			* **$streamFactory** (:any:`Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>`)  

		
	
	

.. rst-class:: protected static

	.. php:method:: protected static getResponseText(array|\\Psr\\Http\\Message\\ResponseInterface|\\Firstred\\PostNL\\Exception\\HttpClientException $response)
	
		.. rst-class:: phpdoc-description
		
			| Get the response\.
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getApiKey()
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setApiKey( $apiKey)
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public isSandbox()
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setSandbox( $sandbox)
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getRequestFactory()
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setRequestFactory( $requestFactory)
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getStreamFactory()
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setStreamFactory( $streamFactory)
	
		
		:Since: 2.0.0 
	
	

