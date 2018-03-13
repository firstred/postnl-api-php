.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GenerateLabelResponse
=====================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: GenerateLabelResponse


	.. rst-class:: phpdoc-description
	
		| Class GenerateLabelResponse
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array | null 


.. php:attr:: protected static MergedLabels

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\MergedLabel\[\] <ThirtyBees\\PostNL\\Entity\\Response\\MergedLabel>` | null 


.. php:attr:: protected static ResponseShipments

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ResponseShipment\[\] <ThirtyBees\\PostNL\\Entity\\Response\\ResponseShipment>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $mergedLabels=null, $responseShipments=null)
	
		.. rst-class:: phpdoc-description
		
			| GenerateLabelResponse constructor\.
			
		
		
		:Parameters:
			* **$mergedLabels** (:any:`ThirtyBees\\PostNL\\Entity\\Response\\MergedLabel\[\] <ThirtyBees\\PostNL\\Entity\\Response\\MergedLabel>` | null)  
			* **$responseShipments** (:any:`ThirtyBees\\PostNL\\Entity\\Response\\ResponseShipment\[\] <ThirtyBees\\PostNL\\Entity\\Response\\ResponseShipment>` | null)  

		
	
	

