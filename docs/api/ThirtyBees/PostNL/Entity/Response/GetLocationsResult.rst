.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetLocationsResult
==================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: GetLocationsResult


	.. rst-class:: phpdoc-description
	
		| Class GetLocationsResult
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static ResponseLocation

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ResponseLocation\[\] <ThirtyBees\\PostNL\\Entity\\Response\\ResponseLocation>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $locations=null)
	
		.. rst-class:: phpdoc-description
		
			| GetLocationsResult constructor\.
			
		
		
		:Parameters:
			* **$locations** (:any:`ThirtyBees\\PostNL\\Entity\\Response\\ResponseLocation\[\] <ThirtyBees\\PostNL\\Entity\\Response\\ResponseLocation>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

