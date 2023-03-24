.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GenerateLabel
=============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GenerateLabel


	.. rst-class:: phpdoc-description
	
		| Class GenerateLabel\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Message, $Customer, $LabelSignature\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::\_\_construct\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::jsonSerialize\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null 


.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null 


.. php:attr:: protected static LabelSignature

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Message=null, $Customer=null, $LabelSignature=null)
	
		.. rst-class:: phpdoc-description
		
			| GenerateLabel constructor\.
			
		
		
		:Parameters:
			* **$Shipments** (:any:`Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$LabelSignature** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`\.
			
		
		
		:Returns: array 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

