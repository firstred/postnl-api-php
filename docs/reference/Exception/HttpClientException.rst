.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HttpClientException
===================


.. php:namespace:: Firstred\PostNL\Exception

.. php:class:: HttpClientException


	.. rst-class:: phpdoc-description
	
		| Class HttpClientException
		
	
	:Parent:
		:php:class:`Exception`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($message, $code, $previous, $response\)<Firstred\\PostNL\\Exception\\HttpClientException::\_\_construct\(\)>`
* :php:meth:`public setResponse\($response\)<Firstred\\PostNL\\Exception\\HttpClientException::setResponse\(\)>`
* :php:meth:`public getResponse\(\)<Firstred\\PostNL\\Exception\\HttpClientException::getResponse\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $message=\'\', $code=0, $previous=null, $response=null)
	
		.. rst-class:: phpdoc-description
		
			| ResponseException constructor\.
			
		
		
		:Parameters:
			* **$message** (string)  
			* **$code** (int)  
			* **$previous** (:any:`Exception <Exception>` | null)  
			* **$response** (:any:`Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setResponse( $response)
	
		
		:Parameters:
			* **$response** (:any:`Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getResponse()
	
		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` 
	
	

