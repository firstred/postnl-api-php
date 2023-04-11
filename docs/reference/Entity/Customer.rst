.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Customer
========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Customer


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($CustomerNumber, $CustomerCode, $CollectionLocation, $ContactPerson, $Email, $Name, $Address, $GlobalPackCustomerCode, $GlobalPackBarcodeType\)<Firstred\\PostNL\\Entity\\Customer::\_\_construct\(\)>`
* :php:meth:`public getAddress\(\)<Firstred\\PostNL\\Entity\\Customer::getAddress\(\)>`
* :php:meth:`public setAddress\($Address\)<Firstred\\PostNL\\Entity\\Customer::setAddress\(\)>`
* :php:meth:`public getCollectionLocation\(\)<Firstred\\PostNL\\Entity\\Customer::getCollectionLocation\(\)>`
* :php:meth:`public setCollectionLocation\($CollectionLocation\)<Firstred\\PostNL\\Entity\\Customer::setCollectionLocation\(\)>`
* :php:meth:`public getContactPerson\(\)<Firstred\\PostNL\\Entity\\Customer::getContactPerson\(\)>`
* :php:meth:`public setContactPerson\($ContactPerson\)<Firstred\\PostNL\\Entity\\Customer::setContactPerson\(\)>`
* :php:meth:`public getCustomerCode\(\)<Firstred\\PostNL\\Entity\\Customer::getCustomerCode\(\)>`
* :php:meth:`public setCustomerCode\($CustomerCode\)<Firstred\\PostNL\\Entity\\Customer::setCustomerCode\(\)>`
* :php:meth:`public getCustomerNumber\(\)<Firstred\\PostNL\\Entity\\Customer::getCustomerNumber\(\)>`
* :php:meth:`public setCustomerNumber\($CustomerNumber\)<Firstred\\PostNL\\Entity\\Customer::setCustomerNumber\(\)>`
* :php:meth:`public getGlobalPackCustomerCode\(\)<Firstred\\PostNL\\Entity\\Customer::getGlobalPackCustomerCode\(\)>`
* :php:meth:`public setGlobalPackCustomerCode\($GlobalPackCustomerCode\)<Firstred\\PostNL\\Entity\\Customer::setGlobalPackCustomerCode\(\)>`
* :php:meth:`public getGlobalPackBarcodeType\(\)<Firstred\\PostNL\\Entity\\Customer::getGlobalPackBarcodeType\(\)>`
* :php:meth:`public setGlobalPackBarcodeType\($GlobalPackBarcodeType\)<Firstred\\PostNL\\Entity\\Customer::setGlobalPackBarcodeType\(\)>`
* :php:meth:`public getEmail\(\)<Firstred\\PostNL\\Entity\\Customer::getEmail\(\)>`
* :php:meth:`public setEmail\($Email\)<Firstred\\PostNL\\Entity\\Customer::setEmail\(\)>`
* :php:meth:`public getName\(\)<Firstred\\PostNL\\Entity\\Customer::getName\(\)>`
* :php:meth:`public setName\($Name\)<Firstred\\PostNL\\Entity\\Customer::setName\(\)>`


Properties
----------

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

		
	
	

.. rst-class:: public

	.. php:method:: public getAddress()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Address <Firstred\\PostNL\\Entity\\Address>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setAddress( $Address)
	
		
		:Parameters:
			* **$Address** (:any:`Firstred\\PostNL\\Entity\\Address <Firstred\\PostNL\\Entity\\Address>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCollectionLocation()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCollectionLocation( $CollectionLocation)
	
		
		:Parameters:
			* **$CollectionLocation** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getContactPerson()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setContactPerson( $ContactPerson)
	
		
		:Parameters:
			* **$ContactPerson** (string | null)  

		
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

	.. php:method:: public getCustomerNumber()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCustomerNumber( $CustomerNumber)
	
		
		:Parameters:
			* **$CustomerNumber** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getGlobalPackCustomerCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setGlobalPackCustomerCode( $GlobalPackCustomerCode)
	
		
		:Parameters:
			* **$GlobalPackCustomerCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getGlobalPackBarcodeType()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setGlobalPackBarcodeType( $GlobalPackBarcodeType)
	
		
		:Parameters:
			* **$GlobalPackBarcodeType** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getEmail()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setEmail( $Email)
	
		
		:Parameters:
			* **$Email** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getName()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setName( $Name)
	
		
		:Parameters:
			* **$Name** (string | null)  

		
		:Returns: static 
	
	

