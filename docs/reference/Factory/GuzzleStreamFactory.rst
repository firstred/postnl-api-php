.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GuzzleStreamFactory
===================


.. php:namespace:: Firstred\PostNL\Factory

.. rst-class::  final

.. php:class:: GuzzleStreamFactory


	.. rst-class:: phpdoc-description
	
		| Class GuzzleStreamFactory
		
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Factory\\StreamFactoryInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public createStream\($content\)<Firstred\\PostNL\\Factory\\GuzzleStreamFactory::createStream\(\)>`
* :php:meth:`public createStreamFromFile\($file, $mode\)<Firstred\\PostNL\\Factory\\GuzzleStreamFactory::createStreamFromFile\(\)>`
* :php:meth:`public createStreamFromResource\($resource\)<Firstred\\PostNL\\Factory\\GuzzleStreamFactory::createStreamFromResource\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public createStream( $content=\'\')
	
		.. rst-class:: phpdoc-description
		
			| Creat a new stream from a string\.
			
		
		
		:Parameters:
			* **$content** (string)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\StreamInterface <Psr\\Http\\Message\\StreamInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public createStreamFromFile( $file, $mode=\'r\')
	
		.. rst-class:: phpdoc-description
		
			| Create a new PSR\-7 stream from file\.
			
		
		
		:Parameters:
			* **$file** (string)  
			* **$mode** (string)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\StreamInterface <Psr\\Http\\Message\\StreamInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public createStreamFromResource( $resource)
	
		.. rst-class:: phpdoc-description
		
			| Create a new PSR\-7 stream from resource\.
			
		
		
		:Parameters:
			* **$resource** (resource)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\StreamInterface <Psr\\Http\\Message\\StreamInterface>` 
	
	

