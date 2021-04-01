.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CutOffTime
==========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: CutOffTime


	.. rst-class:: phpdoc-description
	
		| Class CutOffTime\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Day, $Time, $Available\)<Firstred\\PostNL\\Entity\\CutOffTime::\_\_construct\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\CutOffTime::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Day

	:Type: string | null 


.. php:attr:: protected static Time

	:Type: string | null 


.. php:attr:: protected static Available

	:Type: bool | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Day=null, $Time=null, $Available=null)
	
		
		:Parameters:
			* **$Day** (string)  
			* **$Time** (string)  
			* **$Available** (bool)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

