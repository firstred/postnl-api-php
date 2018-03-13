.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetTimeframes
=============


.. php:namespace:: ThirtyBees\PostNL\Entity\Request

.. php:class:: GetTimeframes


	.. rst-class:: phpdoc-description
	
		| Class GetTimeframes
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static Message

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static Timeframe

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Timeframe\[\] <ThirtyBees\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $message=null, $timeframes=null)
	
		.. rst-class:: phpdoc-description
		
			| GetTimeframes constructor\.
			
		
		
		:Parameters:
			* **$message** (:any:`ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null)  
			* **$timeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Timeframe\[\] <ThirtyBees\\PostNL\\Entity\\Timeframe>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

