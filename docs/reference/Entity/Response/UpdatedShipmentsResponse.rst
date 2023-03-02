.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


UpdatedShipmentsResponse
========================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: UpdatedShipmentsResponse


	.. rst-class:: phpdoc-description
	
		| Class CompleteStatusResponse\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Barcode, $CreationDate, $CustomerNumber, $CustomerCode, $Status\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::\_\_construct\(\)>`
* :php:meth:`public setCreationDate\($CreationDate\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::setCreationDate\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static CreationDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static CustomerNumber

	:Type: string | null 


.. php:attr:: protected static CustomerCode

	:Type: string | null 


.. php:attr:: protected static Status

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Barcode=null, $CreationDate=null, $CustomerNumber=null, $CustomerCode=null, $Status=null)
	
		.. rst-class:: phpdoc-description
		
			| UpdatedShipmentsResponse constructor\.
			
		
		
		:Parameters:
			* **$Barcode** (string | null)  
			* **$CreationDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$CustomerNumber** (string | null)  
			* **$CustomerCode** (string | null)  
			* **$Status** (:any:`Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setCreationDate( $CreationDate=null)
	
		
		:Parameters:
			* **$CreationDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

