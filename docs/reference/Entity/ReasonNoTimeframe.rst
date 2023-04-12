.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ReasonNoTimeframe
=================


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: ReasonNoTimeframe


	.. rst-class:: phpdoc-description
	
		| Class ReasonNoTimeframe\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Code, $Date, $Description, $Options, $From, $To, $Sustainability\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::\_\_construct\(\)>`
* :php:meth:`public setDate\($date\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::setDate\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::jsonDeserialize\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Code

	:Type: string | null 


.. php:attr:: protected static Date

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Description

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static From

	:Type: string | null 


.. php:attr:: protected static To

	:Type: string | null 


.. php:attr:: protected static Sustainability

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Code=null, $Date=null, $Description=null, $Options=null, $From=null, $To=null, $Sustainability=null)
	
		.. rst-class:: phpdoc-description
		
			| ReasonNoTimeframe constructor\.
			
		
		
		:Parameters:
			* **$Code** (string | null)  
			* **$Date** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$Description** (string | null)  
			* **$Options** (string[] | null)  
			* **$From** (string | null)  
			* **$To** (string | null)  
			* **$Sustainability** (:any:`Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setDate( $date=null)
	
		.. rst-class:: phpdoc-description
		
			| Set date
			
		
		
		:Parameters:
			* **$date** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

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
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

