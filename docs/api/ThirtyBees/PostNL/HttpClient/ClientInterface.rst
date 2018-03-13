.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ClientInterface
===============


.. php:namespace:: ThirtyBees\PostNL\HttpClient

.. php:interface:: ClientInterface


	.. rst-class:: phpdoc-description
	
		| Interface ClientInterface
		
	

Methods
-------

.. rst-class:: public

	.. php:method:: public setLogger( $logger)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static getInstance()
	
		.. rst-class:: phpdoc-description
		
			| Get the HTTP Client instance
			
		
		
		:Returns: static 
	
	

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

	.. php:method:: public removeRequest( $id)
	
		.. rst-class:: phpdoc-description
		
			| Remove a request from the list of pending requests
			
		
		
		:Parameters:
			* **$id** (string)  

		
	
	

.. rst-class:: public

	.. php:method:: public clearRequests()
	
		.. rst-class:: phpdoc-description
		
			| Clear all requests
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public doRequest( $request)
	
		.. rst-class:: phpdoc-description
		
			| Do a single request
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$request** (:any:`GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` 
	
	

.. rst-class:: public

	.. php:method:: public doRequests( $requests=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Do all async requests
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$requests** (:any:`GuzzleHttp\\Psr7\\Request\[\] <GuzzleHttp\\Psr7\\Request>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` | :any:`\\GuzzleHttp\\Psr7\\Response\[\] <GuzzleHttp\\Psr7\\Response>` | :any:`\\ThirtyBees\\PostNL\\Exception\\HttpClientException <ThirtyBees\\PostNL\\Exception\\HttpClientException>` | :any:`\\ThirtyBees\\PostNL\\Exception\\HttpClientException\[\] <ThirtyBees\\PostNL\\Exception\\HttpClientException>` 
	
	

