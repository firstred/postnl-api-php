.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Psr18HttpClient
===============


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: Psr18HttpClient


	.. rst-class:: phpdoc-description
	
		| Class Psr18HttpClient\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\HttpClientInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($client, $logger, $concurrency, $maxRetries\)<Firstred\\PostNL\\HttpClient\\Psr18HttpClient::\_\_construct\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\Psr18HttpClient::doRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\Psr18HttpClient::doRequest\(\)>`
* :php:meth:`public getClient\(\)<Firstred\\PostNL\\HttpClient\\Psr18HttpClient::getClient\(\)>`
* :php:meth:`public setClient\($client\)<Firstred\\PostNL\\HttpClient\\Psr18HttpClient::setClient\(\)>`


Properties
----------

.. php:attr:: protected instance

	:Type: static 


.. php:attr:: protected static client

	:Type: :any:`\\Psr\\Http\\Client\\ClientInterface <Psr\\Http\\Client\\ClientInterface>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $client=null, $logger=null, $concurrency=5, $maxRetries=5)
	
		.. rst-class:: phpdoc-description
		
			| HTTPlugClient constructor\.
			
		
		
		:Parameters:
			* **$client** (:any:`Psr\\Http\\Client\\ClientInterface <Psr\\Http\\Client\\ClientInterface>` | null)  
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
	
		
		:Returns: :any:`\\Psr\\Http\\Client\\ClientInterface <Psr\\Http\\Client\\ClientInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public setClient( $client)
	
		
		:Parameters:
			* **$client** (:any:`Psr\\Http\\Client\\ClientInterface <Psr\\Http\\Client\\ClientInterface>`)  

		
		:Returns: static 
	
	

