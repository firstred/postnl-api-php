.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HTTPlugClient
=============


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: HTTPlugClient


	.. rst-class:: phpdoc-description
	
		| Class HTTPlugClient\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\ClientInterface` :php:interface:`Psr\\Log\\LoggerAwareInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($client, $logger, $concurrency, $maxRetries\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::\_\_construct\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::doRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::doRequest\(\)>`
* :php:meth:`public getClient\(\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::getClient\(\)>`
* :php:meth:`public setClient\($client\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::setClient\(\)>`
* :php:meth:`public static getInstance\($client\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::getInstance\(\)>`
* :php:meth:`public setVerify\($verify\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::setVerify\(\)>`
* :php:meth:`public getVerify\(\)<Firstred\\PostNL\\HttpClient\\HTTPlugClient::getVerify\(\)>`


Properties
----------

.. php:attr:: protected instance

	:Type: static 


.. php:attr:: protected static client

	:Type: :any:`\\Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $client=null, $logger=null, $concurrency=5, $maxRetries=5)
	
		.. rst-class:: phpdoc-description
		
			| HTTPlugClient constructor\.
			
		
		
		:Parameters:
			* **$client** (:any:`Http\\Client\\HttpAsyncClient <Http\\Client\\HttpAsyncClient>` | :any:`\\Http\\Client\\HttpClient <Http\\Client\\HttpClient>` | null)  
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` | null)  
			* **$concurrency** (int)  

		
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
	
	

