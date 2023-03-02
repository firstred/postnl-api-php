.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Customer
========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Customer


	.. rst-class:: phpdoc-description
	
		| Class Customer\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($CustomerNumber, $CustomerCode, $CollectionLocation, $ContactPerson, $Email, $Name, $Address, $GlobalPackCustomerCode, $GlobalPackBarcodeType\)<Firstred\\PostNL\\Entity\\Customer::\_\_construct\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Address

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Address <Firstred\\PostNL\\Entity\\Address>` | null 


.. php:attr:: protected static CollectionLocation

	:Type: string | null 


.. php:attr:: protected static ContactPerson

	:Type: string | null 


.. php:attr:: protected static CustomerCode

	:Type: string | null 


.. php:attr:: protected static CustomerNumber

	:Type: string | null 


.. php:attr:: protected static GlobalPackCustomerCode

	:Type: string | null 


.. php:attr:: protected static GlobalPackBarcodeType

	:Type: string | null 


.. php:attr:: protected static Email

	:Type: string | null 


.. php:attr:: protected static Name

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $CustomerNumber=null, $CustomerCode=null, $CollectionLocation=null, $ContactPerson=null, $Email=null, $Name=null, $Address=null, $GlobalPackCustomerCode=null, $GlobalPackBarcodeType=null)
	
		
		:Parameters:
			* **$CustomerNumber** (string | null)  
			* **$CustomerCode** (string | null)  
			* **$CollectionLocation** (string | null)  
			* **$ContactPerson** (string | null)  
			* **$Email** (string | null)  
			* **$Name** (string | null)  
			* **$Address** (:any:`Firstred\\PostNL\\Entity\\Address <Firstred\\PostNL\\Entity\\Address>` | null)  
			* **$GlobalPackCustomerCode** (string | null)  
			* **$GlobalPackBarcodeType** (string | null)  

		
	
	

