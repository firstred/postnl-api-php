.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GenerateBarcode
===============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GenerateBarcode


	.. rst-class:: phpdoc-description
	
		| Class GenerateLabel\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Barcode, $Customer, $Message\)<Firstred\\PostNL\\Entity\\Request\\GenerateBarcode::\_\_construct\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GenerateBarcode::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GenerateBarcode::setMessage\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	:Deprecated: 1.4.1 SOAP support is going to be removed


.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Barcode

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Barcode <Firstred\\PostNL\\Entity\\Barcode>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Barcode=null, $Customer=null, $Message=null)
	
		.. rst-class:: phpdoc-description
		
			| GenerateBarcode constructor\.
			
		
		
		:Parameters:
			* **$Barcode** (:any:`Firstred\\PostNL\\Entity\\Barcode <Firstred\\PostNL\\Entity\\Barcode>` | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public deprecated

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

