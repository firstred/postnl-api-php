.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ProductOption
=============


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: ProductOption


	.. rst-class:: phpdoc-description
	
		| Class ProductOption\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Characteristic, $Option, $Description\)<Firstred\\PostNL\\Entity\\ProductOption::\_\_construct\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\ProductOption::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Characteristic

	:Type: string | null 


.. php:attr:: protected static Option

	:Type: string | null 


.. php:attr:: protected static Description

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Characteristic=null, $Option=null, $Description=null)
	
		
		:Parameters:
			* **$Characteristic** (string | null)  
			* **$Option** (string | null)  
			* **$Description** (string | null)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: mixed | :any:`\\stdClass <stdClass>` | null 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Since: 1.2.0 
	
	

