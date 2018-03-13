.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ApiConnectionException
======================


.. php:namespace:: ThirtyBees\PostNL\Exception

.. php:class:: ApiConnectionException


	.. rst-class:: phpdoc-description
	
		| Class ApiConnectionException
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Exception\\AbstractException`
	

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

	.. php:method:: public __construct( $message="", $code=0, $body=null, $jsonBody=null, $headers=null)
	
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
	
	

