.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


UpdatedShipmentsResponse
========================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: UpdatedShipmentsResponse


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Barcode, $CreationDate, $CustomerNumber, $CustomerCode, $Status\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::\_\_construct\(\)>`
* :php:meth:`public getBarcode\(\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::getBarcode\(\)>`
* :php:meth:`public setBarcode\($Barcode\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::setBarcode\(\)>`
* :php:meth:`public getCustomerNumber\(\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::getCustomerNumber\(\)>`
* :php:meth:`public setCustomerNumber\($CustomerNumber\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::setCustomerNumber\(\)>`
* :php:meth:`public getCustomerCode\(\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::getCustomerCode\(\)>`
* :php:meth:`public setCustomerCode\($CustomerCode\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::setCustomerCode\(\)>`
* :php:meth:`public getStatus\(\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::getStatus\(\)>`
* :php:meth:`public setStatus\($Status\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::setStatus\(\)>`
* :php:meth:`public getCreationDate\(\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::getCreationDate\(\)>`
* :php:meth:`public setCreationDate\($CreationDate\)<Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse::setCreationDate\(\)>`


Properties
----------

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

	.. php:method:: public __construct( $Barcode=null, string|\\DateTimeInterface|null $CreationDate=null, $CustomerNumber=null, $CustomerCode=null, $Status=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getBarcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setBarcode( $Barcode)
	
		
		:Parameters:
			* **$Barcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCustomerNumber()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCustomerNumber( $CustomerNumber)
	
		
		:Parameters:
			* **$CustomerNumber** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCustomerCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCustomerCode( $CustomerCode)
	
		
		:Parameters:
			* **$CustomerCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getStatus()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setStatus( $Status)
	
		
		:Parameters:
			* **$Status** (:any:`Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCreationDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setCreationDate(string|\\DateTimeInterface|null $CreationDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

