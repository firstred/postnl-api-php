.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CompleteStatusResponse
======================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CompleteStatusResponse


	.. rst-class:: phpdoc-description
	
		| Class CompleteStatusResponse\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Warnings\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::\_\_construct\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::jsonDeserialize\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Warnings=null)
	
		.. rst-class:: phpdoc-description
		
			| CompleteStatusResponse constructor\.
			
		
		
		:Parameters:
			* **$Shipments** (:any:`Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` | null)  
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Response\\Warnings\[\] <Firstred\\PostNL\\Entity\\Response\\Warnings>` | null)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

