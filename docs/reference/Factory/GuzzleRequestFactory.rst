.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GuzzleRequestFactory
====================


.. php:namespace:: Firstred\PostNL\Factory

.. rst-class::  final

.. php:class:: GuzzleRequestFactory


	.. rst-class:: phpdoc-description
	
		| Class GuzzleRequestFactory
		
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Factory\\RequestFactoryInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public createRequest\($method, $uri\)<Firstred\\PostNL\\Factory\\GuzzleRequestFactory::createRequest\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public createRequest( $method, $uri)
	
		.. rst-class:: phpdoc-description
		
			| Creates a new PSR\-7 request\.
			
		
		
		:Parameters:
			* **$method** (string)  
			* **$uri** (string | :any:`\\Psr\\Http\\Message\\UriInterface <Psr\\Http\\Message\\UriInterface>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
	
	

