.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GenerateBarcode
===============


.. php:namespace:: ThirtyBees\PostNL\Entity\Request

.. php:class:: GenerateBarcode


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


.. php:attr:: protected static Message

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static Customer

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Barcode

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Barcode <ThirtyBees\\PostNL\\Entity\\Barcode>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $barcode=null, $customer=null, $message=null)
	
		.. rst-class:: phpdoc-description
		
			| GenerateBarcode constructor\.
			
		
		
		:Parameters:
			* **$barcode** (:any:`ThirtyBees\\PostNL\\Entity\\Barcode <ThirtyBees\\PostNL\\Entity\\Barcode>` | null)  
			* **$customer** (:any:`ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` | null)  
			* **$message** (:any:`ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

