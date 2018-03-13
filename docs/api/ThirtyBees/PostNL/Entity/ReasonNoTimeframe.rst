.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ReasonNoTimeframe
=================


.. php:namespace:: ThirtyBees\PostNL\Entity

.. php:class:: ReasonNoTimeframe


	.. rst-class:: phpdoc-description
	
		| Class ReasonNoTimeframe
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Code

	:Type: string | null 


.. php:attr:: protected static Date

	:Type: string | null 


.. php:attr:: protected static Description

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static From

	:Type: string | null 


.. php:attr:: protected static To

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $code=null, $date=null, $desc=null, $options=null, $from=null, $to=null)
	
		
		:Parameters:
			* **$code** (string | null)  
			* **$date** (string | null)  
			* **$desc** (string | null)  
			* **$options** (string[] | null)  
			* **$from** (string | null)  
			* **$to** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

