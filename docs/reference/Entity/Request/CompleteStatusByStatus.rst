.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CompleteStatusByStatus
======================


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: CompleteStatusByStatus


	.. rst-class:: phpdoc-description
	
		| Class CompleteStatusByStatus\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipment, $Customer, $Message\)<Firstred\\PostNL\\Entity\\Request\\CompleteStatusByStatus::\_\_construct\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Request\\CompleteStatusByStatus::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Shipment

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipment=null, $Customer=null, $Message=null)
	
		.. rst-class:: phpdoc-description
		
			| CompleteStatusByStatus constructor\.
			
		
		
		:Parameters:
			* **$Shipment** (:any:`Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>` | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

