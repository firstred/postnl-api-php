.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MockHttpClient
==============


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: MockHttpClient


	.. rst-class:: phpdoc-description
	
		| Class MockClient\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\HttpClientInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public setOption\($name, $value\)<Firstred\\PostNL\\HttpClient\\MockHttpClient::setOption\(\)>`
* :php:meth:`public getOption\($name\)<Firstred\\PostNL\\HttpClient\\MockHttpClient::getOption\(\)>`
* :php:meth:`public setHandler\($handler\)<Firstred\\PostNL\\HttpClient\\MockHttpClient::setHandler\(\)>`
* :php:meth:`public getHandler\(\)<Firstred\\PostNL\\HttpClient\\MockHttpClient::getHandler\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\MockHttpClient::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\MockHttpClient::doRequests\(\)>`


Constants
---------

.. php:const:: DEFAULT_TIMEOUT = 60



.. php:const:: DEFAULT_CONNECT_TIMEOUT = 20



Properties
----------

.. php:attr:: protected static defaultOptions

	:Type: array 


.. php:attr:: private static handler

	:Type: :any:`\\GuzzleHttp\\HandlerStack <GuzzleHttp\\HandlerStack>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public setOption( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Set Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\MockHttpClient <Firstred\\PostNL\\HttpClient\\MockHttpClient>` 
	
	

.. rst-class:: public

	.. php:method:: public getOption( $name)
	
		.. rst-class:: phpdoc-description
		
			| Get Guzzle option\.
			
		
		
		:Parameters:
			* **$name** (string)  

		
		:Returns: mixed | null 
	
	

.. rst-class:: public

	.. php:method:: public setHandler( $handler)
	
		
	
	

.. rst-class:: public

	.. php:method:: public getHandler()
	
		
	
	

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

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface\[\] <Psr\\Http\\Message\\ResponseInterface>` | :any:`\\Firstred\\PostNL\\Exception\\HttpClientException\[\] <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

