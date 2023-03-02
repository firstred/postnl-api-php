.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GuzzleClient
============


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: GuzzleClient


	.. rst-class:: phpdoc-description
	
		| Class GuzzleClient\.
		
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\ClientInterface` :php:interface:`Psr\\Log\\LoggerAwareInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public static getInstance\(\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::getInstance\(\)>`
* :php:meth:`public setOption\($name, $value\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::setOption\(\)>`
* :php:meth:`public getOption\($name\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::getOption\(\)>`
* :php:meth:`public setVerify\($verify\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::setVerify\(\)>`
* :php:meth:`public getVerify\(\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::getVerify\(\)>`
* :php:meth:`public setMaxRetries\($maxRetries\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::setMaxRetries\(\)>`
* :php:meth:`public getMaxRetries\(\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::getMaxRetries\(\)>`
* :php:meth:`public setConcurrency\($concurrency\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::setConcurrency\(\)>`
* :php:meth:`public getConcurrency\(\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::getConcurrency\(\)>`
* :php:meth:`public setLogger\($logger\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::setLogger\(\)>`
* :php:meth:`public getLogger\(\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::getLogger\(\)>`
* :php:meth:`public addOrUpdateRequest\($id, $request\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::addOrUpdateRequest\(\)>`
* :php:meth:`public removeRequest\($id\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::removeRequest\(\)>`
* :php:meth:`public clearRequests\(\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::clearRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\GuzzleClient::doRequests\(\)>`


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
	
		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\GuzzleClient <Firstred\\PostNL\\HttpClient\\GuzzleClient>` | static 
		:Deprecated:  Please instantiate a new client rather than using this singleton
	
	

.. rst-class:: public

	.. php:method:: public setOption( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Set Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\GuzzleClient <Firstred\\PostNL\\HttpClient\\GuzzleClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getOption( $name)
	
		.. rst-class:: phpdoc-description
		
			| Get Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  

		
		:Returns: mixed | null 
	
	

.. rst-class:: public deprecated

	.. php:method:: public setVerify( $verify)
	
		.. rst-class:: phpdoc-description
		
			| Set the verify setting\.
			
		
		
		:Parameters:
			* **$verify** (bool | string)  

		
		:Returns: static 
		:Deprecated:  
	
	

.. rst-class:: public deprecated

	.. php:method:: public getVerify()
	
		.. rst-class:: phpdoc-description
		
			| Return verify setting\.
			
		
		
		:Returns: bool | string 
		:Deprecated:  
	
	

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

	.. php:method:: public setLogger( $logger)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger\.
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\GuzzleClient <Firstred\\PostNL\\HttpClient\\GuzzleClient>` 
	
	

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

		
		:Returns: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException\[\] <Firstred\\PostNL\\Exception\\HttpClientException>` | :any:`\\Psr\\Http\\Message\\ResponseInterface\[\] <Psr\\Http\\Message\\ResponseInterface>` 
	
	

