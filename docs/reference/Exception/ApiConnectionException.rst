.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ApiConnectionException
======================


.. php:namespace:: Firstred\PostNL\Exception

.. php:class:: ApiConnectionException


	.. rst-class:: phpdoc-description
	
		| Class ApiConnectionException\.
		
		| Thrown when there is a problem connecting to the CIF API\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Exception\\ApiException`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($message, $code, $body, $jsonBody, $headers\)<Firstred\\PostNL\\Exception\\ApiConnectionException::\_\_construct\(\)>`
* :php:meth:`public getBody\(\)<Firstred\\PostNL\\Exception\\ApiConnectionException::getBody\(\)>`
* :php:meth:`public getJsonBody\(\)<Firstred\\PostNL\\Exception\\ApiConnectionException::getJsonBody\(\)>`
* :php:meth:`public getHeaders\(\)<Firstred\\PostNL\\Exception\\ApiConnectionException::getHeaders\(\)>`


Properties
----------

.. php:attr:: protected static body

	:Type: string 


.. php:attr:: protected static jsonBody

	:Type: object 


.. php:attr:: protected static headers

	:Type: array 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $message=\'\', $code=0, $body=null, $jsonBody=null, $headers=null)
	
		.. rst-class:: phpdoc-description
		
			| ApiConnectionException constructor\.
			
		
		
		:Parameters:
			* **$message** (string)  
			* **$code** (int)  
			* **$body** (string | null)  
			* **$jsonBody** (object | null)  
			* **$headers** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getBody()
	
		
		:Returns: string 
	
	

.. rst-class:: public

	.. php:method:: public getJsonBody()
	
		
		:Returns: object 
	
	

.. rst-class:: public

	.. php:method:: public getHeaders()
	
		
		:Returns: array 
	
	

