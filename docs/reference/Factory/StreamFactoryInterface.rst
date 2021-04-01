.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


StreamFactoryInterface
======================


.. php:namespace:: Firstred\PostNL\Factory

.. php:interface:: StreamFactoryInterface


	.. rst-class:: phpdoc-description
	
		| Factory for PSR\-7 Stream\.
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public createStream\($content\)<Firstred\\PostNL\\Factory\\StreamFactoryInterface::createStream\(\)>`
* :php:meth:`public createStreamFromFile\($filename, $mode\)<Firstred\\PostNL\\Factory\\StreamFactoryInterface::createStreamFromFile\(\)>`
* :php:meth:`public createStreamFromResource\($resource\)<Firstred\\PostNL\\Factory\\StreamFactoryInterface::createStreamFromResource\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public createStream( $content=\'\')
	
		.. rst-class:: phpdoc-description
		
			| Create a new stream from a string\.
			
			| The stream SHOULD be created with a temporary resource\.
			
		
		
		:Parameters:
			* **$content** (string)  String content with which to populate the stream.

		
		:Returns: :any:`\\Psr\\Http\\Message\\StreamInterface <Psr\\Http\\Message\\StreamInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public createStreamFromFile( $filename, $mode=\'r\')
	
		.. rst-class:: phpdoc-description
		
			| Create a stream from an existing file\.
			
			| The file MUST be opened using the given mode, which may be any mode
			| supported by the \`fopen\` function\.
			| 
			| The \`$filename\` MAY be any string supported by \`fopen\(\)\`\.
			
		
		
		:Parameters:
			* **$filename** (string)  Filename or stream URI to use as basis of stream.
			* **$mode** (string)  Mode with which to open the underlying filename/stream.

		
		:Returns: :any:`\\Psr\\Http\\Message\\StreamInterface <Psr\\Http\\Message\\StreamInterface>` 
		:Throws: :any:`\\RuntimeException <RuntimeException>` If the file cannot be opened\.
		:Throws: :any:`\\InvalidArgumentException <InvalidArgumentException>` If the mode is invalid\.
		:Throws: :any:`\\RuntimeException <RuntimeException>` If the file cannot be opened\.
		:Throws: :any:`\\InvalidArgumentException <InvalidArgumentException>` If the mode is invalid\.
	
	

.. rst-class:: public

	.. php:method:: public createStreamFromResource( $resource)
	
		.. rst-class:: phpdoc-description
		
			| Create a new stream from an existing resource\.
			
			| The stream MUST be readable and may be writable\.
			
		
		
		:Parameters:
			* **$resource** (resource)  PHP resource to use as basis of stream.

		
		:Returns: :any:`\\Psr\\Http\\Message\\StreamInterface <Psr\\Http\\Message\\StreamInterface>` 
	
	

