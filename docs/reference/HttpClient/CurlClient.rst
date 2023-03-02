.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurlClient
==========


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: CurlClient


	.. rst-class:: phpdoc-description
	
		| Class CurlClient\.
		
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\ClientInterface` :php:interface:`Psr\\Log\\LoggerAwareInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public static getInstance\(\)<Firstred\\PostNL\\HttpClient\\CurlClient::getInstance\(\)>`
* :php:meth:`public setTimeout\($seconds\)<Firstred\\PostNL\\HttpClient\\CurlClient::setTimeout\(\)>`
* :php:meth:`public setConnectTimeout\($seconds\)<Firstred\\PostNL\\HttpClient\\CurlClient::setConnectTimeout\(\)>`
* :php:meth:`public setVerify\($verify\)<Firstred\\PostNL\\HttpClient\\CurlClient::setVerify\(\)>`
* :php:meth:`public setLogger\($logger\)<Firstred\\PostNL\\HttpClient\\CurlClient::setLogger\(\)>`
* :php:meth:`public getTimeout\(\)<Firstred\\PostNL\\HttpClient\\CurlClient::getTimeout\(\)>`
* :php:meth:`public getConnectTimeout\(\)<Firstred\\PostNL\\HttpClient\\CurlClient::getConnectTimeout\(\)>`
* :php:meth:`public getVerify\(\)<Firstred\\PostNL\\HttpClient\\CurlClient::getVerify\(\)>`
* :php:meth:`public getLogger\(\)<Firstred\\PostNL\\HttpClient\\CurlClient::getLogger\(\)>`
* :php:meth:`public addOrUpdateRequest\($id, $request\)<Firstred\\PostNL\\HttpClient\\CurlClient::addOrUpdateRequest\(\)>`
* :php:meth:`public removeRequest\($id\)<Firstred\\PostNL\\HttpClient\\CurlClient::removeRequest\(\)>`
* :php:meth:`public clearRequests\(\)<Firstred\\PostNL\\HttpClient\\CurlClient::clearRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\CurlClient::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\CurlClient::doRequests\(\)>`
* :php:meth:`protected prepareRequest\($curl, $request\)<Firstred\\PostNL\\HttpClient\\CurlClient::prepareRequest\(\)>`


Constants
---------

.. php:const:: DEFAULT_TIMEOUT = 80



.. php:const:: DEFAULT_CONNECT_TIMEOUT = 30



Properties
----------

.. php:attr:: protected static defaultOptions

	:Type: array | callable | null 


.. php:attr:: protected static userAgentInfo

	:Type: array 


.. php:attr:: protected static pendingRequests

	:Type: array 


.. php:attr:: protected static logger

	:Type: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 


Methods
-------

.. rst-class:: public static deprecated

	.. php:method:: public static getInstance()
	
		.. rst-class:: phpdoc-description
		
			| CurlClient Singleton\.
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\CurlClient <Firstred\\PostNL\\HttpClient\\CurlClient>` 
		:Deprecated:  Please instantiate a new client rather than using this singleton
	
	

.. rst-class:: public

	.. php:method:: public setTimeout( $seconds)
	
		.. rst-class:: phpdoc-description
		
			| Set timeout\.
			
		
		
		:Parameters:
			* **$seconds** (int)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\CurlClient <Firstred\\PostNL\\HttpClient\\CurlClient>` 
	
	

.. rst-class:: public

	.. php:method:: public setConnectTimeout( $seconds)
	
		.. rst-class:: phpdoc-description
		
			| Set connection timeout\.
			
		
		
		:Parameters:
			* **$seconds** (int)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\CurlClient <Firstred\\PostNL\\HttpClient\\CurlClient>` 
	
	

.. rst-class:: public deprecated

	.. php:method:: public setVerify( $verify)
	
		.. rst-class:: phpdoc-description
		
			| Set the verify setting\.
			
		
		
		:Parameters:
			* **$verify** (bool | string)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\CurlClient <Firstred\\PostNL\\HttpClient\\CurlClient>` 
		:Deprecated:  
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger\.
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\CurlClient <Firstred\\PostNL\\HttpClient\\CurlClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Get timeout\.
			
		
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public getConnectTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Get connection timeout\.
			
		
		
		:Returns: int 
	
	

.. rst-class:: public deprecated

	.. php:method:: public getVerify()
	
		.. rst-class:: phpdoc-description
		
			| Return verify setting\.
			
		
		
		:Returns: bool | string 
		:Deprecated:  
	
	

.. rst-class:: public

	.. php:method:: public getLogger()
	
		.. rst-class:: phpdoc-description
		
			| Get logger\.
			
		
		
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
	
	

.. rst-class:: protected

	.. php:method:: protected prepareRequest( $curl, $request)
	
		
		:Parameters:
			* **$curl** (resource)  
			* **$request** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

