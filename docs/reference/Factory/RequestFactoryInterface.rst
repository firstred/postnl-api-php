.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


RequestFactoryInterface
=======================


.. php:namespace:: Firstred\PostNL\Factory

.. php:interface:: RequestFactoryInterface


	.. rst-class:: phpdoc-description
	
		| Factory for PSR\-7 Request\.
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public createRequest\($method, $uri\)<Firstred\\PostNL\\Factory\\RequestFactoryInterface::createRequest\(\)>`


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
	
	

