.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MockClient
==========


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: MockClient


	.. rst-class:: phpdoc-description
	
		| Class MockClient\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\ClientInterface` :php:interface:`Psr\\Log\\LoggerAwareInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public static getInstance\(\)<Firstred\\PostNL\\HttpClient\\MockClient::getInstance\(\)>`
* :php:meth:`public setOption\($name, $value\)<Firstred\\PostNL\\HttpClient\\MockClient::setOption\(\)>`
* :php:meth:`public getOption\($name\)<Firstred\\PostNL\\HttpClient\\MockClient::getOption\(\)>`
* :php:meth:`public setHandler\($handler\)<Firstred\\PostNL\\HttpClient\\MockClient::setHandler\(\)>`
* :php:meth:`public getHandler\(\)<Firstred\\PostNL\\HttpClient\\MockClient::getHandler\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\MockClient::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\MockClient::doRequests\(\)>`


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


Methods
-------

.. rst-class:: public static deprecated

	.. php:method:: public static getInstance()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\MockClient <Firstred\\PostNL\\HttpClient\\MockClient>` | static 
		:Deprecated:  Please instantiate a new client rather than using this singleton
	
	

.. rst-class:: public

	.. php:method:: public setOption( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Set Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\MockClient <Firstred\\PostNL\\HttpClient\\MockClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getOption( $name)
	
		.. rst-class:: phpdoc-description
		
			| Get Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  

		
		:Returns: mixed | null 
	
	

.. rst-class:: public

	.. php:method:: public setHandler( $handler)
	
		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\MockClient <Firstred\\PostNL\\HttpClient\\MockClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getHandler()
	
		
		:Returns: :any:`\\GuzzleHttp\\HandlerStack <GuzzleHttp\\HandlerStack>` 
	
	

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

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface\[\] <Psr\\Http\\Message\\ResponseInterface>` | :any:`\\Firstred\\PostNL\\Exception\\HttpClientException\[\] <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

