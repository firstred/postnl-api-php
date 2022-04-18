.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Message
=======


.. php:namespace:: Firstred\PostNL\Util

.. php:class:: Message


	.. rst-class:: phpdoc-description
	
		| Class Message\.
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public static str\($message\)<Firstred\\PostNL\\Util\\Message::str\(\)>`
* :php:meth:`public static parseResponse\($message\)<Firstred\\PostNL\\Util\\Message::parseResponse\(\)>`


Constants
---------

.. php:const:: RFC7230_HEADER_REGEX = "\(^\(\[^\(\)<\>@,;:\\\\\\"/\[\\\\\]?=\{\}\\x01\- \]\+\+\):\[ \\t\]\*\+\(\(?:\[ \\t\]\*\+\[\!\-~\\x80\-\\xff\]\+\+\)\*\+\)\[ \\t\]\*\+\\r?\\n\)m"



.. php:const:: RFC7230_HEADER_FOLD_REGEX = "\(\\r?\\n\[ \\t\]\+\+\)"



Methods
-------

.. rst-class:: public static

	.. php:method:: public static str( $message)
	
		.. rst-class:: phpdoc-description
		
			| Returns the string representation of an HTTP message\.
			
		
		
		:Parameters:
			* **$message** (:any:`Psr\\Http\\Message\\MessageInterface <Psr\\Http\\Message\\MessageInterface>`)  message to convert to a string

		
		:Returns: string 
	
	

.. rst-class:: public static

	.. php:method:: public static parseResponse( $message)
	
		.. rst-class:: phpdoc-description
		
			| Parses a response message string into a response object\.
			
		
		
		:Parameters:
			* **$message** (string)  response message string

		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>` 
	
	

