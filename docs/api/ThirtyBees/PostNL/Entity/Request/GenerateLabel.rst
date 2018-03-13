.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GenerateLabel
=============


.. php:namespace:: ThirtyBees\PostNL\Entity\Request

.. php:class:: GenerateLabel


	.. rst-class:: phpdoc-description
	
		| Class GenerateLabel
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static Customer

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Message\\LabellingMessage <ThirtyBees\\PostNL\\Entity\\Message\\LabellingMessage>` | null 


.. php:attr:: protected static Shipments

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Shipment\[\] <ThirtyBees\\PostNL\\Entity\\Shipment>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $shipments=null, $message=null, $customer=null)
	
		.. rst-class:: phpdoc-description
		
			| GenerateLabel constructor\.
			
		
		
		:Parameters:
			* **$shipments** (:any:`ThirtyBees\\PostNL\\Entity\\Shipment\[\] <ThirtyBees\\PostNL\\Entity\\Shipment>` | null)  
			* **$message** (:any:`ThirtyBees\\PostNL\\Entity\\Message\\LabellingMessage <ThirtyBees\\PostNL\\Entity\\Message\\LabellingMessage>` | null)  
			* **$customer** (:any:`ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`
			
		
		
		:Returns: array 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

