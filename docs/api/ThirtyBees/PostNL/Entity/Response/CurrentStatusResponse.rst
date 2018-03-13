.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurrentStatusResponse
=====================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: CurrentStatusResponse


	.. rst-class:: phpdoc-description
	
		| Class CurrentStatusResponse
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static Shipments

	:Type: array | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $shipments=null)
	
		.. rst-class:: phpdoc-description
		
			| CurrentStatusResponse constructor\.
			
		
		
		:Parameters:
			* **$shipments** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

