.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


UsernameToken
=============


.. php:namespace:: ThirtyBees\PostNL\Entity\SOAP

.. php:class:: UsernameToken


	.. rst-class:: phpdoc-description
	
		| Class UsernameToken
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

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

	.. php:method:: public __construct( $username, $password)
	
		.. rst-class:: phpdoc-description
		
			| UsernameToken constructor\.
			
		
		
		:Parameters:
			* **$username** (string | null)  
			* **$password** (string | null)  Plaintext password

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

