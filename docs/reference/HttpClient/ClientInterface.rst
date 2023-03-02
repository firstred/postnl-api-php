.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ClientInterface
===============


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:interface:: ClientInterface


	.. rst-class:: phpdoc-description
	
		| Interface ClientInterface\.
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public getLogger\(\)<Firstred\\PostNL\\HttpClient\\ClientInterface::getLogger\(\)>`
* :php:meth:`public setLogger\($logger\)<Firstred\\PostNL\\HttpClient\\ClientInterface::setLogger\(\)>`
* :php:meth:`public static getInstance\(\)<Firstred\\PostNL\\HttpClient\\ClientInterface::getInstance\(\)>`
* :php:meth:`public addOrUpdateRequest\($id, $request\)<Firstred\\PostNL\\HttpClient\\ClientInterface::addOrUpdateRequest\(\)>`
* :php:meth:`public setVerify\($verify\)<Firstred\\PostNL\\HttpClient\\ClientInterface::setVerify\(\)>`
* :php:meth:`public getVerify\(\)<Firstred\\PostNL\\HttpClient\\ClientInterface::getVerify\(\)>`
* :php:meth:`public removeRequest\($id\)<Firstred\\PostNL\\HttpClient\\ClientInterface::removeRequest\(\)>`
* :php:meth:`public clearRequests\(\)<Firstred\\PostNL\\HttpClient\\ClientInterface::clearRequests\(\)>`
* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\ClientInterface::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\ClientInterface::doRequests\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public getLogger()
	
		.. rst-class:: phpdoc-description
		
			| Get the logger\.
			
		
		
		:Returns: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger\.
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static getInstance()
	
		.. rst-class:: phpdoc-description
		
			| Get the HTTP Client instance\.
			
		
		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public addOrUpdateRequest( $id, $request)
	
		.. rst-class:: phpdoc-description
		
			| Adds a request to the list of pending requests
			| Using the ID you can replace a request\.
			
		
		
		:Parameters:
			* **$id** (string)  Request ID
			* **$request** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  PSR-7 request

		
		:Returns: int | string 
	
	

.. rst-class:: public deprecated

	.. php:method:: public setVerify( $verify)
	
		.. rst-class:: phpdoc-description
		
			| Set the verify setting\.
			
		
		
		:Parameters:
			* **$verify** (bool | string)  

		
		:Returns: static 
		:Deprecated:  
	
	

.. rst-class:: public deprecated

	.. php:method:: public getVerify()
	
		.. rst-class:: phpdoc-description
		
			| Return verify setting\.
			
		
		
		:Returns: bool | string 
		:Deprecated:  
	
	

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
	
	

