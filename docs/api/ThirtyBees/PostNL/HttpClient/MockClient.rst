.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MockClient
==========


.. php:namespace:: ThirtyBees\PostNL\HttpClient

.. php:class:: MockClient


	.. rst-class:: phpdoc-description
	
		| Class MockClient
		
	
	:Implements:
		:php:interface:`ThirtyBees\\PostNL\\HttpClient\\ClientInterface` :php:interface:`Psr\\Log\\LoggerAwareInterface` 
	

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
	
		| List of pending PSR\-7 requests
		
	
	:Type: :any:`\\GuzzleHttp\\Psr7\\Request\[\] <GuzzleHttp\\Psr7\\Request>` 


.. php:attr:: protected static logger

	:Type: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 


Methods
-------

.. rst-class:: public static

	.. php:method:: public static getInstance()
	
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\MockClient <ThirtyBees\\PostNL\\HttpClient\\MockClient>` | static 
	
	

.. rst-class:: public

	.. php:method:: public setOption( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Set Guzzle option
			
		
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\MockClient <ThirtyBees\\PostNL\\HttpClient\\MockClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getOption( $name)
	
		.. rst-class:: phpdoc-description
		
			| Get Guzzle option
			
		
		
		:Parameters:
			* **$name** (string)  

		
		:Returns: mixed | null 
	
	

.. rst-class:: public

	.. php:method:: public setVerify( $verify)
	
		.. rst-class:: phpdoc-description
		
			| Set the verify setting
			
		
		
		:Parameters:
			* **$verify** (bool | string)  

		
		:Returns: $this 
	
	

.. rst-class:: public

	.. php:method:: public getVerify()
	
		.. rst-class:: phpdoc-description
		
			| Return verify setting
			
		
		
		:Returns: bool | string 
	
	

.. rst-class:: public

	.. php:method:: public setMaxRetries( $maxRetries)
	
		.. rst-class:: phpdoc-description
		
			| Set the amount of retries
			
		
		
		:Parameters:
			* **$maxRetries** (int)  

		
		:Returns: $this 
	
	

.. rst-class:: public

	.. php:method:: public getMaxRetries()
	
		.. rst-class:: phpdoc-description
		
			| Return max retries
			
		
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\MockClient <ThirtyBees\\PostNL\\HttpClient\\MockClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getLogger()
	
		.. rst-class:: phpdoc-description
		
			| Get the logger
			
		
		
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

	.. php:method:: public setHandler( $handler)
	
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\MockClient <ThirtyBees\\PostNL\\HttpClient\\MockClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getHandler()
	
		
		:Returns: :any:`\\GuzzleHttp\\HandlerStack <GuzzleHttp\\HandlerStack>` 
	
	

.. rst-class:: public

	.. php:method:: public doRequest( $request)
	
		.. rst-class:: phpdoc-description
		
			| Do a single request
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$request** (:any:`GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\HttpClientException <ThirtyBees\\PostNL\\Exception\\HttpClientException>` 
	
	

.. rst-class:: public

	.. php:method:: public doRequests( $requests=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Do all async requests
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$requests** (:any:`GuzzleHttp\\Psr7\\Request\[\] <GuzzleHttp\\Psr7\\Request>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` | :any:`\\GuzzleHttp\\Psr7\\Response\[\] <GuzzleHttp\\Psr7\\Response>` | :any:`\\ThirtyBees\\PostNL\\Exception\\HttpClientException <ThirtyBees\\PostNL\\Exception\\HttpClientException>` | :any:`\\ThirtyBees\\PostNL\\Exception\\HttpClientException\[\] <ThirtyBees\\PostNL\\Exception\\HttpClientException>` 
	
	

