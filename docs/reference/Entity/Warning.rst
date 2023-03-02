.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Warning
=======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Warning


	.. rst-class:: phpdoc-description
	
		| Class Warning\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Code, $Description\)<Firstred\\PostNL\\Entity\\Warning::\_\_construct\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Warning::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Code

	:Type: string | null 


.. php:attr:: protected static Description

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Code=null, $Description=null)
	
		
		:Parameters:
			* **$Code** (string | null)  
			* **$Description** (string | null)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		.. rst-class:: phpdoc-description
		
			| Deserialize JSON\.
			
		
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  JSON object `{"EntityName": object}`

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

