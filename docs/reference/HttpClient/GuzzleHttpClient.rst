.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GuzzleHttpClient
================


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: GuzzleHttpClient


	.. rst-class:: phpdoc-description
	
		| Class GuzzleClient\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\HttpClientInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($client, $logger, $concurrency, $maxRetries\)<Firstred\\PostNL\\HttpClient\\GuzzleHttpClient::\_\_construct\(\)>`
* :php:meth:`private setClient\($client\)<Firstred\\PostNL\\HttpClient\\GuzzleHttpClient::setClient\(\)>`
* :php:meth:`private getClient\(\)<Firstred\\PostNL\\HttpClient\\GuzzleHttpClient::getClient\(\)>`
* :php:meth:`public setOption\($name, $value\)<Firstred\\PostNL\\HttpClient\\GuzzleHttpClient::setOption\(\)>`
* :php:meth:`public getOption\($name\)<Firstred\\PostNL\\HttpClient\\GuzzleHttpClient::getOption\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\GuzzleHttpClient::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\GuzzleHttpClient::doRequests\(\)>`


Constants
---------

.. php:const:: DEFAULT_TIMEOUT = 60



.. php:const:: DEFAULT_CONNECT_TIMEOUT = 20



Properties
----------

.. php:attr:: protected static defaultOptions

	:Type: :any:`array<string,mixed\> <array<string,mixed\>>` 


.. php:attr:: private static client



Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $client=null, $logger=null, $concurrency=5, $maxRetries=5)
	
		.. rst-class:: phpdoc-description
		
			| GuzzleClient constructor\.
			
		
		
		:Since: 1.3.0 Custom constructor
	
	

.. rst-class:: private

	.. php:method:: private setClient( $client)
	
		
	
	

.. rst-class:: private

	.. php:method:: private getClient()
	
		.. rst-class:: phpdoc-description
		
			| Get the Guzzle client\.
			
		
		
		:Returns: :any:`\\GuzzleHttp\\Client <GuzzleHttp\\Client>` 
	
	

.. rst-class:: public

	.. php:method:: public setOption( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Set Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\GuzzleHttpClient <Firstred\\PostNL\\HttpClient\\GuzzleHttpClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getOption( $name)
	
		.. rst-class:: phpdoc-description
		
			| Get Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  

		
		:Returns: mixed | null 
	
	

.. rst-class:: public

	.. php:method:: public doRequest( $request)
	
		.. rst-class:: phpdoc-description
		
			| Do a single request\.
			
			| Exceptions are captured into the result array
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

.. rst-class:: public

	.. php:method:: public doRequests( $requests=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Do all async requests\.
			
			| Exceptions are captured into the result array
			
		
		
		:Parameters:
			* **$requests** (:any:`Psr\\Http\\Message\\RequestInterface\[\] <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException\[\] <Firstred\\PostNL\\Exception\\HttpClientException>` | :any:`\\Psr\\Http\\Message\\ResponseInterface\[\] <Psr\\Http\\Message\\ResponseInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

