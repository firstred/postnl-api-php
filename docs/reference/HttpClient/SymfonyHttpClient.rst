.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


SymfonyHttpClient
=================


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: SymfonyHttpClient


	.. rst-class:: phpdoc-description
	
		| Class SymfonyHttpClientInterface\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\ClientInterface` :php:interface:`Psr\\Log\\LoggerAwareInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($client, $logger, $concurrency, $maxRetries\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::\_\_construct\(\)>`
* :php:meth:`private getClient\(\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::getClient\(\)>`
* :php:meth:`public static getInstance\(\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::getInstance\(\)>`
* :php:meth:`public setOption\($name, $value\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::setOption\(\)>`
* :php:meth:`public getOption\($name\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::getOption\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::doRequests\(\)>`
* :php:meth:`public setMaxRetries\($maxRetries\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::setMaxRetries\(\)>`
* :php:meth:`public setConcurrency\($concurrency\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::setConcurrency\(\)>`
* :php:meth:`private convertPsrRequestToSymfonyHttpClientRequestParams\($psrRequest\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::convertPsrRequestToSymfonyHttpClientRequestParams\(\)>`
* :php:meth:`private convertSymfonyHttpClientResponseToPsrResponse\($symfonyHttpClientResponse\)<Firstred\\PostNL\\HttpClient\\SymfonyHttpClient::convertSymfonyHttpClientResponseToPsrResponse\(\)>`


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


.. php:attr:: private static client

	:Type: :any:`\\Symfony\\Contracts\\HttpClient\\HttpClientInterface <Symfony\\Contracts\\HttpClient\\HttpClientInterface>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $client=null, $logger=null, $concurrency=5, $maxRetries=5)
	
		.. rst-class:: phpdoc-description
		
			| SymfonyHttpClient constructor\.
			
		
		
		:Parameters:
			* **$client** (:any:`Symfony\\Contracts\\HttpClient\\HttpClientInterface <Symfony\\Contracts\\HttpClient\\HttpClientInterface>` | null)  
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` | null)  
			* **$concurrency** (int)  
			* **$maxRetries** (int)  

		
		:Since: 1.3.0 Custom constructor
	
	

.. rst-class:: private

	.. php:method:: private getClient()
	
		.. rst-class:: phpdoc-description
		
			| Get the Symfony HTTP Client\.
			
		
		
		:Returns: :any:`\\Symfony\\Contracts\\HttpClient\\HttpClientInterface <Symfony\\Contracts\\HttpClient\\HttpClientInterface>` 
	
	

.. rst-class:: public static deprecated

	.. php:method:: public static getInstance()
	
		
		:Returns: static 
		:Deprecated:  Please instantiate a new client rather than using this singleton
	
	

.. rst-class:: public

	.. php:method:: public setOption( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Set Symfony HTTP Client option\.
			
		
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getOption( $name)
	
		.. rst-class:: phpdoc-description
		
			| Get Symfony HTTP Client option\.
			
		
		
		:Parameters:
			* **$name** (string)  

		
		:Returns: mixed | null 
	
	

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
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setMaxRetries( $maxRetries)
	
		.. rst-class:: phpdoc-description
		
			| Set the amount of retries\.
			
		
		
		:Parameters:
			* **$maxRetries** (int)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setConcurrency( $concurrency)
	
		.. rst-class:: phpdoc-description
		
			| Set the concurrency\.
			
		
		
		:Parameters:
			* **$concurrency** (int)  

		
		:Returns: static 
	
	

.. rst-class:: private

	.. php:method:: private convertPsrRequestToSymfonyHttpClientRequestParams( $psrRequest)
	
		
		:Parameters:
			* **$psrRequest** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Returns: array 
		:Since: 1.3.0 
	
	

.. rst-class:: private

	.. php:method:: private convertSymfonyHttpClientResponseToPsrResponse( $symfonyHttpClientResponse)
	
		
		:Parameters:
			* **$symfonyHttpClientResponse** (:any:`Symfony\\Contracts\\HttpClient\\ResponseInterface <Symfony\\Contracts\\HttpClient\\ResponseInterface>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface>` 
		:Throws: :any:`\\Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface <Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface>` 
		:Since: 1.3.0 
	
	

