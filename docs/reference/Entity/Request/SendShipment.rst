.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


SendShipment
============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: SendShipment


	.. rst-class:: phpdoc-description
	
		| Class SendShipment\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Message, $Customer\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::\_\_construct\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: array 


.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null 


.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Message=null, $Customer=null)
	
		.. rst-class:: phpdoc-description
		
			| SendShipment constructor\.
			
		
		
		:Parameters:
			* **$Shipments** (:any:`Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`\.
			
		
		
		:Returns: array 
	
	

