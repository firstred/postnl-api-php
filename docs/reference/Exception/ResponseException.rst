.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseException
=================


.. php:namespace:: Firstred\PostNL\Exception

.. php:class:: ResponseException


	.. rst-class:: phpdoc-description
	
		| Class ResponseException\.
		
		| Thrown when there was a problem with the response returned by the CIF API\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Exception\\ApiException`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($message, $code, $previous, $response\)<Firstred\\PostNL\\Exception\\ResponseException::\_\_construct\(\)>`
* :php:meth:`public setResponse\($response\)<Firstred\\PostNL\\Exception\\ResponseException::setResponse\(\)>`
* :php:meth:`public getResponse\(\)<Firstred\\PostNL\\Exception\\ResponseException::getResponse\(\)>`


Properties
----------

.. php:attr:: private static response

	:Type: :any:`\\Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` 


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
	
	

