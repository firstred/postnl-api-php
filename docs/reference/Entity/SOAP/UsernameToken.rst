.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


UsernameToken
=============


.. php:namespace:: Firstred\PostNL\Entity\SOAP

.. php:class:: UsernameToken


	.. rst-class:: phpdoc-description
	
		| Class UsernameToken\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Username, $Password\)<Firstred\\PostNL\\Entity\\SOAP\\UsernameToken::\_\_construct\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\SOAP\\UsernameToken::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Username

	:Type: string | null 


.. php:attr:: protected static Password

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Username, $Password)
	
		.. rst-class:: phpdoc-description
		
			| UsernameToken constructor\.
			
		
		
		:Parameters:
			* **$Username** (string | null)  
			* **$Password** (string | null)  Plaintext password

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

