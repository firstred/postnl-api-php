.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseFactoryInterface
========================


.. php:namespace:: Firstred\PostNL\Factory

.. php:interface:: ResponseFactoryInterface


	.. rst-class:: phpdoc-description
	
		| Factory for PSR\-7 Response\.
		
		| This factory contract can be reused in Message and Server Message factories\.
		| 
		| FOR BACKWARD COMPATIBLE REASONS \- NOT COMPATIBLE WITH SYMFONY HTTP CLIENT
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public createResponse\($code, $reasonPhrase\)<Firstred\\PostNL\\Factory\\ResponseFactoryInterface::createResponse\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public createResponse( $code=200, $reasonPhrase=\'\')
	
		.. rst-class:: phpdoc-description
		
			| Creates a new PSR\-7 response\.
			
		
		
		:Parameters:
			* **$code** (int)  
			* **$reasonPhrase** (string | null)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` 
	
	

