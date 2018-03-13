.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurlClient
==========


.. php:namespace:: ThirtyBees\PostNL\HttpClient

.. php:class:: CurlClient


	.. rst-class:: phpdoc-description
	
		| Class CurlClient
		
	
	:Implements:
		:php:interface:`ThirtyBees\\PostNL\\HttpClient\\ClientInterface` :php:interface:`Psr\\Log\\LoggerAwareInterface` 
	

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

.. rst-class:: public static

	.. php:method:: public static getInstance()
	
		.. rst-class:: phpdoc-description
		
			| CurlClient Singleton
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\CurlClient <ThirtyBees\\PostNL\\HttpClient\\CurlClient>` 
	
	

.. rst-class:: public

	.. php:method:: public setTimeout( $seconds)
	
		.. rst-class:: phpdoc-description
		
			| Set timeout
			
		
		
		:Parameters:
			* **$seconds** (int)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\CurlClient <ThirtyBees\\PostNL\\HttpClient\\CurlClient>` 
	
	

.. rst-class:: public

	.. php:method:: public setConnectTimeout( $seconds)
	
		.. rst-class:: phpdoc-description
		
			| Set connection timeout
			
		
		
		:Parameters:
			* **$seconds** (int)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\CurlClient <ThirtyBees\\PostNL\\HttpClient\\CurlClient>` 
	
	

.. rst-class:: public

	.. php:method:: public setVerify( $verify)
	
		.. rst-class:: phpdoc-description
		
			| Set the verify setting
			
		
		
		:Parameters:
			* **$verify** (bool | string)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\CurlClient <ThirtyBees\\PostNL\\HttpClient\\CurlClient>` 
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\CurlClient <ThirtyBees\\PostNL\\HttpClient\\CurlClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Get timeout
			
		
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public getConnectTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Get connection timeout
			
		
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public getVerify()
	
		.. rst-class:: phpdoc-description
		
			| Return verify setting
			
		
		
		:Returns: bool | string 
	
	

.. rst-class:: public

	.. php:method:: public getLogger()
	
		.. rst-class:: phpdoc-description
		
			| Get logger
			
		
		
		:Returns: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public addOrUpdateRequest( $id, $request)
	
		.. rst-class:: phpdoc-description
		
			| Adds a request to the list of pending requests
			| Using the ID you can replace a request
			
		
		
		:Parameters:
			* **$id** (string)  Request ID
			* **$request** (string)  PSR-7 request

		
		:Returns: int | string 
	
	

.. rst-class:: public

	.. php:method:: public removeRequest( $id)
	
		.. rst-class:: phpdoc-description
		
			| Remove a request from the list of pending requests
			
		
		
		:Parameters:
			* **$id** (string)  

		
	
	

.. rst-class:: public

	.. php:method:: public clearRequests()
	
		.. rst-class:: phpdoc-description
		
			| Clear all pending requests
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public doRequest( $request)
	
		.. rst-class:: phpdoc-description
		
			| Do a single request
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$request** (:any:`GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` 
		:Throws: :any:`\\Exception <Exception>` 
	
	

.. rst-class:: public

	.. php:method:: public doRequests( $requests=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Do all async requests
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$requests** (:any:`GuzzleHttp\\Psr7\\Request\[\] <GuzzleHttp\\Psr7\\Request>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` | :any:`\\GuzzleHttp\\Psr7\\Response\[\] <GuzzleHttp\\Psr7\\Response>` | :any:`\\Exception <Exception>` | :any:`\\Exception\[\] <Exception>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
	
	

.. rst-class:: protected

	.. php:method:: protected prepareRequest( $curl, $request)
	
		
		:Parameters:
			* **$curl** (resource)  
			* **$request** (:any:`GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>`)  

		
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
	
	

