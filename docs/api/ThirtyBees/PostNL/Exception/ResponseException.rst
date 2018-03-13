.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseException
=================


.. php:namespace:: ThirtyBees\PostNL\Exception

.. php:class:: ResponseException


	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Exception\\AbstractException`
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $message="", $code=0, $previous=null, $response=null)
	
		.. rst-class:: phpdoc-description
		
			| ResponseException constructor\.
			
		
		
		:Parameters:
			* **$message** (string)  
			* **$code** (int)  
			* **$previous** (:any:`Throwable <Throwable>` | null)  
			* **$response** (:any:`GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setResponse( $response)
	
		
		:Parameters:
			* **$response** (:any:`GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getResponse()
	
		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Response <GuzzleHttp\\Psr7\\Response>` 
	
	

