.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MockClient
==========


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: MockClient


	.. rst-class:: phpdoc-description
	
		| Class MockClient\.
		
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\ClientInterface` :php:interface:`Psr\\Log\\LoggerAwareInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public static getInstance\(\)<Firstred\\PostNL\\HttpClient\\MockClient::getInstance\(\)>`
* :php:meth:`public setOption\($name, $value\)<Firstred\\PostNL\\HttpClient\\MockClient::setOption\(\)>`
* :php:meth:`public getOption\($name\)<Firstred\\PostNL\\HttpClient\\MockClient::getOption\(\)>`
* :php:meth:`public setVerify\($verify\)<Firstred\\PostNL\\HttpClient\\MockClient::setVerify\(\)>`
* :php:meth:`public getVerify\(\)<Firstred\\PostNL\\HttpClient\\MockClient::getVerify\(\)>`
* :php:meth:`public setMaxRetries\($maxRetries\)<Firstred\\PostNL\\HttpClient\\MockClient::setMaxRetries\(\)>`
* :php:meth:`public getMaxRetries\(\)<Firstred\\PostNL\\HttpClient\\MockClient::getMaxRetries\(\)>`
* :php:meth:`public setLogger\($logger\)<Firstred\\PostNL\\HttpClient\\MockClient::setLogger\(\)>`
* :php:meth:`public getLogger\(\)<Firstred\\PostNL\\HttpClient\\MockClient::getLogger\(\)>`
* :php:meth:`public addOrUpdateRequest\($id, $request\)<Firstred\\PostNL\\HttpClient\\MockClient::addOrUpdateRequest\(\)>`
* :php:meth:`public removeRequest\($id\)<Firstred\\PostNL\\HttpClient\\MockClient::removeRequest\(\)>`
* :php:meth:`public clearRequests\(\)<Firstred\\PostNL\\HttpClient\\MockClient::clearRequests\(\)>`
* :php:meth:`public setHandler\($handler\)<Firstred\\PostNL\\HttpClient\\MockClient::setHandler\(\)>`
* :php:meth:`public getHandler\(\)<Firstred\\PostNL\\HttpClient\\MockClient::getHandler\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\MockClient::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\MockClient::doRequests\(\)>`


Constants
---------

.. php:const:: DEFAULT_TIMEOUT = 60



.. php:const:: DEFAULT_CONNECT_TIMEOUT = 20



Properties
----------

.. php:attr:: protected instance

	:Type: static 


.. php:attr:: protected static defaultOptions

	:Type: array 


.. php:attr:: protected static pendingRequests

	.. rst-class:: phpdoc-description
	
		| List of pending PSR\-7 requests\.
		
	
	:Type: :any:`\\Psr\\Http\\Message\\RequestInterface\[\] <Psr\\Http\\Message\\RequestInterface>` 


.. php:attr:: protected static logger

	:Type: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 


Methods
-------

.. rst-class:: public static deprecated

	.. php:method:: public static getInstance()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\MockClient <Firstred\\PostNL\\HttpClient\\MockClient>` | static 
		:Deprecated:  Please instantiate a new client rather than using this singleton
	
	

.. rst-class:: public

	.. php:method:: public setOption( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Set Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\MockClient <Firstred\\PostNL\\HttpClient\\MockClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getOption( $name)
	
		.. rst-class:: phpdoc-description
		
			| Get Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  

		
		:Returns: mixed | null 
	
	

.. rst-class:: public

	.. php:method:: public setVerify( $verify)
	
		.. rst-class:: phpdoc-description
		
			| Set the verify setting\.
			
		
		
		:Parameters:
			* **$verify** (bool | string)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getVerify()
	
		.. rst-class:: phpdoc-description
		
			| Return verify setting\.
			
		
		
		:Returns: bool | string 
	
	

.. rst-class:: public

	.. php:method:: public setMaxRetries( $maxRetries)
	
		.. rst-class:: phpdoc-description
		
			| Set the amount of retries\.
			
		
		
		:Parameters:
			* **$maxRetries** (int)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMaxRetries()
	
		.. rst-class:: phpdoc-description
		
			| Return max retries\.
			
		
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger\.
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\MockClient <Firstred\\PostNL\\HttpClient\\MockClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getLogger()
	
		.. rst-class:: phpdoc-description
		
			| Get the logger\.
			
		
		
		:Returns: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public addOrUpdateRequest( $id, $request)
	
		.. rst-class:: phpdoc-description
		
			| Adds a request to the list of pending requests
			| Using the ID you can replace a request\.
			
		
		
		:Parameters:
			* **$id** (string)  Request ID
			* **$request** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  PSR-7 request

		
		:Returns: int | string 
	
	

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

	.. php:method:: public setHandler( $handler)
	
		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\MockClient <Firstred\\PostNL\\HttpClient\\MockClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getHandler()
	
		
		:Returns: :any:`\\GuzzleHttp\\HandlerStack <GuzzleHttp\\HandlerStack>` 
	
	

.. rst-class:: public

	.. php:method:: public doRequest( $request)
	
		.. rst-class:: phpdoc-description
		
			| Do a single request\.
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$request** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

.. rst-class:: public

	.. php:method:: public doRequests( $requests=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Do all async requests\.
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$requests** (:any:`Psr\\Http\\Message\\RequestInterface\[\] <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface\[\] <Psr\\Http\\Message\\ResponseInterface>` | :any:`\\Firstred\\PostNL\\Exception\\HttpClientException\[\] <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

