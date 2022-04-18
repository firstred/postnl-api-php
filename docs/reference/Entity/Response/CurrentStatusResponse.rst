.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurrentStatusResponse
=====================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CurrentStatusResponse


	.. rst-class:: phpdoc-description
	
		| Class CurrentStatusResponse\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Warnings\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse::\_\_construct\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Warnings=null)
	
		.. rst-class:: phpdoc-description
		
			| CurrentStatusResponse constructor\.
			
		
		
		:Parameters:
			* **$Shipments** (:any:`Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | null)  
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

