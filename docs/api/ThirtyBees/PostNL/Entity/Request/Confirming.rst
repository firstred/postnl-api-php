.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Confirming
==========


.. php:namespace:: ThirtyBees\PostNL\Entity\Request

.. php:class:: Confirming


	.. rst-class:: phpdoc-description
	
		| Class Confirming
		
	
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

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static Shipments

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Shipment\[\] <ThirtyBees\\PostNL\\Entity\\Shipment>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $shipments=null, $customer=null, $message=null)
	
		.. rst-class:: phpdoc-description
		
			| Confirming constructor\.
			
		
		
		:Parameters:
			* **$shipments** (:any:`ThirtyBees\\PostNL\\Entity\\Shipment\[\] <ThirtyBees\\PostNL\\Entity\\Shipment>` | null)  
			* **$customer** (:any:`ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` | null)  
			* **$message** (:any:`ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`
			
		
		
		:Returns: array 
	
	

