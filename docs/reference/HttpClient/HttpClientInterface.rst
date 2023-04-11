.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HttpClientInterface
===================


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:interface:: HttpClientInterface


	.. rst-class:: phpdoc-description
	
		| Interface ClientInterface\.
		
	
	:Parent:
		:php:interface:`Psr\\Log\\LoggerAwareInterface`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public getLogger\(\)<Firstred\\PostNL\\HttpClient\\HttpClientInterface::getLogger\(\)>`
* :php:meth:`public addOrUpdateRequest\($id, $request\)<Firstred\\PostNL\\HttpClient\\HttpClientInterface::addOrUpdateRequest\(\)>`
* :php:meth:`public removeRequest\($id\)<Firstred\\PostNL\\HttpClient\\HttpClientInterface::removeRequest\(\)>`
* :php:meth:`public clearRequests\(\)<Firstred\\PostNL\\HttpClient\\HttpClientInterface::clearRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\HttpClientInterface::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\HttpClientInterface::doRequests\(\)>`


Methods
-------

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
		
			| Clear all requests\.
			
		
		
	
	

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

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` | :any:`\\Psr\\Http\\Message\\ResponseInterface\[\] <Psr\\Http\\Message\\ResponseInterface>` | :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` | :any:`\\Firstred\\PostNL\\Exception\\HttpClientException\[\] <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

