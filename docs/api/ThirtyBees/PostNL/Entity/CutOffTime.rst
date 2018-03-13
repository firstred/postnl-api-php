.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CutOffTime
==========


.. php:namespace:: ThirtyBees\PostNL\Entity

.. php:class:: CutOffTime


	.. rst-class:: phpdoc-description
	
		| Class CutOffTime
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

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

	.. php:method:: public __construct( $day=null, $time=null, $available=null)
	
		
		:Parameters:
			* **$day** (string)  
			* **$time** (string)  
			* **$available** (bool)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

