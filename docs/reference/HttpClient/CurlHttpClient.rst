.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurlHttpClient
==============


.. php:namespace:: Firstred\PostNL\HttpClient

.. php:class:: CurlHttpClient


	.. rst-class:: phpdoc-description
	
		| Class CurlClient\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\HttpClient\\BaseHttpClient`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\HttpClient\\HttpClientInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public doRequest\($request\)<Firstred\\PostNL\\HttpClient\\CurlHttpClient::doRequest\(\)>`
* :php:meth:`public doRequests\($requests\)<Firstred\\PostNL\\HttpClient\\CurlHttpClient::doRequests\(\)>`
* :php:meth:`protected prepareRequest\($curl, $request\)<Firstred\\PostNL\\HttpClient\\CurlHttpClient::prepareRequest\(\)>`
* :php:meth:`private handleCurlError\($url, $errno, $message\)<Firstred\\PostNL\\HttpClient\\CurlHttpClient::handleCurlError\(\)>`


Properties
----------

.. php:attr:: protected static defaultOptions

	:Type: array | callable | null 


Methods
-------

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
	
	

.. rst-class:: protected

	.. php:method:: protected prepareRequest( $curl, $request)
	
		
		:Parameters:
			* **$curl** (resource)  
			* **$request** (:any:`Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>`)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
	
	

.. rst-class:: private

	.. php:method:: private handleCurlError( $url, $errno, $message)
	
		
		:Parameters:
			* **$url**  
			* **$errno** (:any:`Firstred\\PostNL\\HttpClient\\number <Firstred\\PostNL\\HttpClient\\number>`)  
			* **$message** (string)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ApiConnectionException <Firstred\\PostNL\\Exception\\ApiConnectionException>` 
	
	

