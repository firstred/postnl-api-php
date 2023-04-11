.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


BaseHttpClient
==============


.. php:namespace:: Firstred\PostNL\HttpClient

.. rst-class::  abstract

.. php:class:: BaseHttpClient


	:Implements:
		:php:interface:`Psr\\Log\\LoggerAwareInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public getTimeout\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::getTimeout\(\)>`
* :php:meth:`public setTimeout\($seconds\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::setTimeout\(\)>`
* :php:meth:`public getConnectTimeout\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::getConnectTimeout\(\)>`
* :php:meth:`public setConnectTimeout\($seconds\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::setConnectTimeout\(\)>`
* :php:meth:`public getLogger\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::getLogger\(\)>`
* :php:meth:`public setLogger\($logger\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::setLogger\(\)>`
* :php:meth:`public getMaxRetries\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::getMaxRetries\(\)>`
* :php:meth:`public setMaxRetries\($maxRetries\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::setMaxRetries\(\)>`
* :php:meth:`public setConcurrency\($concurrency\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::setConcurrency\(\)>`
* :php:meth:`public getConcurrency\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::getConcurrency\(\)>`
* :php:meth:`public addOrUpdateRequest\($id, $request\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::addOrUpdateRequest\(\)>`
* :php:meth:`public removeRequest\($id\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::removeRequest\(\)>`
* :php:meth:`public clearRequests\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::clearRequests\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::doRequests\(\)>`
* :php:meth:`public getRequestFactory\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::getRequestFactory\(\)>`
* :php:meth:`public setRequestFactory\($requestFactory\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::setRequestFactory\(\)>`
* :php:meth:`public getResponseFactory\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::getResponseFactory\(\)>`
* :php:meth:`public setResponseFactory\($responseFactory\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::setResponseFactory\(\)>`
* :php:meth:`public getStreamFactory\(\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::getStreamFactory\(\)>`
* :php:meth:`public setStreamFactory\($streamFactory\)<Firstred\\PostNL\\HttpClient\\BaseHttpClient::setStreamFactory\(\)>`


Constants
---------

.. php:const:: DEFAULT_TIMEOUT = 80



.. php:const:: DEFAULT_CONNECT_TIMEOUT = 30



Properties
----------

.. php:attr:: protected static timeout



.. php:attr:: protected static connectTimeout



.. php:attr:: protected static pendingRequests



.. php:attr:: protected static logger



.. php:attr:: protected static maxRetries



.. php:attr:: protected static concurrency



.. php:attr:: protected static requestFactory



.. php:attr:: protected static responseFactory



.. php:attr:: protected static streamFactory



Methods
-------

.. rst-class:: public

	.. php:method:: public getTimeout()
	
		
	
	

.. rst-class:: public

	.. php:method:: public setTimeout( $seconds)
	
		
	
	

.. rst-class:: public

	.. php:method:: public getConnectTimeout()
	
		
	
	

.. rst-class:: public

	.. php:method:: public setConnectTimeout( $seconds)
	
		
	
	

.. rst-class:: public

	.. php:method:: public getLogger()
	
		.. rst-class:: phpdoc-description
		
			| Get logger\.
			
		
		
		:Returns: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger\.
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getMaxRetries()
	
		.. rst-class:: phpdoc-description
		
			| Return max retries\.
			
		
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public setMaxRetries( $maxRetries)
	
		.. rst-class:: phpdoc-description
		
			| Set the amount of retries\.
			
		
		
		:Parameters:
			* **$maxRetries** (int)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setConcurrency( $concurrency)
	
		.. rst-class:: phpdoc-description
		
			| Set the concurrency\.
			
		
		
		:Parameters:
			* **$concurrency** (int)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getConcurrency()
	
		.. rst-class:: phpdoc-description
		
			| Return concurrency\.
			
		
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public addOrUpdateRequest( $id, $request)
	
		.. rst-class:: phpdoc-description
		
			| Adds a request to the list of pending requests
			| Using the ID you can replace a request\.
			
		
		
		:Parameters:
			* **$id** (string)  Request ID
			* **$request** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  PSR-7 request

		
		:Returns: int | string 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public removeRequest( $id)
	
		.. rst-class:: phpdoc-description
		
			| Remove a request from the list of pending requests\.
			
		
		
		:Parameters:
			* **$id** (string)  

		
	
	

.. rst-class:: public

	.. php:method:: public clearRequests()
	
		.. rst-class:: phpdoc-description
		
			| Clear all pending requests\.
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public doRequests( $requests=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Do all async requests\.
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$requests** (:any:`Psr\\Http\\Message\\RequestInterface\[\] <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException\[\] <Firstred\\PostNL\\Exception\\HttpClientException>` | :any:`\\Psr\\Http\\Message\\ResponseInterface\[\] <Psr\\Http\\Message\\ResponseInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getRequestFactory()
	
		.. rst-class:: phpdoc-description
		
			| Get PSR\-7 Request factory\.
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Since: 1.3.0 
	
	

.. rst-class:: public

	.. php:method:: public setRequestFactory( $requestFactory)
	
		.. rst-class:: phpdoc-description
		
			| Set PSR\-7 Request factory\.
			
		
		
		:Since: 1.3.0 
	
	

.. rst-class:: public

	.. php:method:: public getResponseFactory()
	
		.. rst-class:: phpdoc-description
		
			| Get PSR\-7 Response factory\.
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Since: 1.3.0 
	
	

.. rst-class:: public

	.. php:method:: public setResponseFactory( $responseFactory)
	
		.. rst-class:: phpdoc-description
		
			| Set PSR\-7 Response factory\.
			
		
		
		:Since: 1.3.0 
	
	

.. rst-class:: public

	.. php:method:: public getStreamFactory()
	
		.. rst-class:: phpdoc-description
		
			| Set PSR\-7 Stream factory\.
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Since: 1.3.0 
	
	

.. rst-class:: public

	.. php:method:: public setStreamFactory( $streamFactory)
	
		.. rst-class:: phpdoc-description
		
			| Set PSR\-7 Stream factory\.
			
		
		
		:Since: 1.3.0 
	
	

