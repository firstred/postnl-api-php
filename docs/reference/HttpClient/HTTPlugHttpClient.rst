.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HTTPlugHttpClient
=================


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: HTTPlugHttpClient


	.. rst-class:: phpdoc-description
	
		| Class HTTPlugClient\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\HttpClientInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($client, $logger, $concurrency, $maxRetries\)<Firstred\\PostNL\\HttpClient\\HTTPlugHttpClient::\_\_construct\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\HTTPlugHttpClient::doRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\HTTPlugHttpClient::doRequest\(\)>`
* :php:meth:`public getClient\(\)<Firstred\\PostNL\\HttpClient\\HTTPlugHttpClient::getClient\(\)>`
* :php:meth:`public setClient\($client\)<Firstred\\PostNL\\HttpClient\\HTTPlugHttpClient::setClient\(\)>`


Properties
----------

.. php:attr:: protected instance

	:Type: static 


.. php:attr:: protected static client

	:Type: :any:`\\Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct(\\Http\\Client\\HttpAsyncClient|\\Http\\Client\\HttpClient $client=null, $logger=null, $concurrency=5, $maxRetries=5)
	
		.. rst-class:: phpdoc-description
		
			| HTTPlugClient constructor\.
			
		
		
		:Parameters:
			* **$client** (:any:`Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` | null)  
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
	
		
		:Returns: :any:`\\Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` 
	
	

.. rst-class:: public

	.. php:method:: public setClient(\\Http\\Client\\HttpAsyncClient|\\Http\\Client\\HttpClient $client)
	
		
		:Parameters:
			* **$client** (:any:`Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>`)  

		
		:Returns: static 
	
	

