.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AsyncHttpClient
===============


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: AsyncHttpClient


	.. rst-class:: phpdoc-description
	
		| Class AsyncHttpClient\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\HttpClientInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($client, $logger, $concurrency, $maxRetries\)<Firstred\\PostNL\\HttpClient\\AsyncHttpClient::\_\_construct\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\AsyncHttpClient::doRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\AsyncHttpClient::doRequest\(\)>`
* :php:meth:`public getClient\(\)<Firstred\\PostNL\\HttpClient\\AsyncHttpClient::getClient\(\)>`
* :php:meth:`public setClient\($client\)<Firstred\\PostNL\\HttpClient\\AsyncHttpClient::setClient\(\)>`


Properties
----------

.. php:attr:: protected instance

	:Type: static 


.. php:attr:: protected static client

	:Type: :any:`\\Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $client=null, $logger=null, $concurrency=5, $maxRetries=5)
	
		.. rst-class:: phpdoc-description
		
			| HTTPlugClient constructor\.
			
		
		
		:Parameters:
			* **$client** (:any:`Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | null)  
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` | null)  
			* **$concurrency** (int)  
			* **$maxRetries** (int)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

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

	.. php:method:: public doRequest( $request)
	
		.. rst-class:: phpdoc-description
		
			| Do a single request\.
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$request** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

.. rst-class:: public

	.. php:method:: public getClient()
	
		
		:Returns: :any:`\\Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` 
	
	

.. rst-class:: public

	.. php:method:: public setClient( $client)
	
		
		:Parameters:
			* **$client** (:any:`Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>`)  

		
		:Returns: static 
	
	

