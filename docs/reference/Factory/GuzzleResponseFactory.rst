.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GuzzleResponseFactory
=====================


.. php:namespace:: Firstred\PostNL\Factory

.. rst-class::  final

.. php:class:: GuzzleResponseFactory


	.. rst-class:: phpdoc-description
	
		| Class GuzzleResponseFactory
		
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Factory\\ResponseFactoryInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public createResponse\($code, $reasonPhrase\)<Firstred\\PostNL\\Factory\\GuzzleResponseFactory::createResponse\(\)>`


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
	
	

