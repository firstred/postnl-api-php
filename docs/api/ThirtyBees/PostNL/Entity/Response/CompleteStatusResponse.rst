.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CompleteStatusResponse
======================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: CompleteStatusResponse


	.. rst-class:: phpdoc-description
	
		| Class CompleteStatusResponse
		
	
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
		
			| CompleteStatusResponse constructor\.
			
		
		
		:Parameters:
			* **$shipments** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

