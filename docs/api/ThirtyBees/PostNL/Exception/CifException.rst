.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CifException
============


.. php:namespace:: ThirtyBees\PostNL\Exception

.. php:class:: CifException


	.. rst-class:: phpdoc-description
	
		| Class CifException
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Exception\\AbstractException`
	

Properties
----------

.. php:attr:: protected static messages

	:Type: array 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $message="", $code=0, $previous=null)
	
		.. rst-class:: phpdoc-description
		
			| CifException constructor\.
			
		
		
		:Parameters:
			* **$message** (string | string[])  In case of multiple errors, the format looks like:
			[
			  'description' => string <The description>,
			  'message'     => string <The error message>,
			  'code'        => int <The error code>
			]
			The code param will be discarded if `$message` is an array
			* **$code** (int)  
			* **$previous** (:any:`Throwable <Throwable>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getMessagesDescriptionsAndCodes()
	
		.. rst-class:: phpdoc-description
		
			| Get error messages and codes
			
		
		
		:Returns: array | string | string[] 
	
	

