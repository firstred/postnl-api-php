.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HTTPlugClient
=============


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: HTTPlugClient


	.. rst-class:: phpdoc-description
	
		| Class HTTPlugClient\.
		
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\ClientInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($client, $logger, $concurrency\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::\_\_construct\(\)>`
* :php:meth:`public addOrUpdateRequest\($id, $request\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::addOrUpdateRequest\(\)>`
* :php:meth:`public removeRequest\($id\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::removeRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::doRequests\(\)>`
* :php:meth:`public clearRequests\(\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::clearRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::doRequest\(\)>`
* :php:meth:`public getConcurrency\(\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::getConcurrency\(\)>`
* :php:meth:`public setConcurrency\($concurrency\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::setConcurrency\(\)>`
* :php:meth:`public getLogger\(\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::getLogger\(\)>`
* :php:meth:`public setLogger\($logger\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::setLogger\(\)>`
* :php:meth:`public getClient\(\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::getClient\(\)>`
* :php:meth:`public setClient\($client\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::setClient\(\)>`
* :php:meth:`public static getInstance\($client\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::getInstance\(\)>`
* :php:meth:`public setVerify\($verify\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::setVerify\(\)>`
* :php:meth:`public getVerify\(\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::getVerify\(\)>`


Properties
----------

.. php:attr:: protected static client

	:Type: :any:`\\Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` 


.. php:attr:: protected static pendingRequests

	.. rst-class:: phpdoc-description
	
		| List of pending PSR\-7 requests\.
		
	
	:Type: :any:`\\Psr\\Http\\Message\\RequestInterface\[\] <Psr\\Http\\Message\\RequestInterface>` 


.. php:attr:: protected static logger

	:Type: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` | null 


.. php:attr:: protected static concurrency

	:Type: int 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $client=null, $logger=null, $concurrency=5)
	
		.. rst-class:: phpdoc-description
		
			| HTTPlugClient constructor\.
			
		
		
		:Parameters:
			* **$client** (:any:`Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` | null)  
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` | null)  
			* **$concurrency** (int)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

.. rst-class:: public

	.. php:method:: public addOrUpdateRequest( $id, $request)
	
		.. rst-class:: phpdoc-description
		
			| Adds a request to the list of pending requests
			| Using the ID you can replace a request\.
			
		
		
		:Parameters:
			* **$id** (string)  
			* **$request** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Returns: string 
	
	

.. rst-class:: public

	.. php:method:: public removeRequest( $id)
	
		.. rst-class:: phpdoc-description
		
			| Remove a request from the list of pending requests\.
			
		
		
		:Parameters:
			* **$id** (string)  

		
	
	

.. rst-class:: public

	.. php:method:: public doRequests( $requests=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Do all async requests\.
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$requests** (array)  

		
		:Returns: array 
	
	

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

	.. php:method:: public getConcurrency()
	
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public setConcurrency( $concurrency)
	
		
		:Parameters:
			* **$concurrency** (int)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getLogger()
	
		
		:Returns: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger)
	
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getClient()
	
		
		:Returns: :any:`\\Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` 
	
	

.. rst-class:: public

	.. php:method:: public setClient( $client)
	
		
		:Parameters:
			* **$client** (:any:`Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>`)  

		
		:Returns: static 
	
	

.. rst-class:: public static deprecated

	.. php:method:: public static getInstance( $client=null)
	
		
		:Parameters:
			* **$client** (:any:`Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\HTTPlugClient <Firstred\\PostNL\\HttpClient\\HTTPlugClient>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Deprecated:  Please instantiate a new client rather than using this singleton
	
	

.. rst-class:: public deprecated

	.. php:method:: public setVerify( $verify)
	
		
		:Parameters:
			* **$verify** (bool | string)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\HTTPlugClient <Firstred\\PostNL\\HttpClient\\HTTPlugClient>` 
		:Deprecated:  
	
	

.. rst-class:: public deprecated

	.. php:method:: public getVerify()
	
		
		:Returns: bool | string | void 
		:Deprecated:  
	
	

