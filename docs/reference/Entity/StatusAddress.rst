.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


StatusAddress
=============


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: StatusAddress


	.. rst-class:: phpdoc-description
	
		| Class StatusAddress\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AddressType, $FirstName, $LastName, $CompanyName, $DepartmentName, $Street, $HouseNumber, $HouseNumberSuffix, $Zipcode, $City, $CountryCode, $Region, $District, $Building, $Floor, $Remark, $RegistrationDate\)<Firstred\\PostNL\\Entity\\StatusAddress::\_\_construct\(\)>`
* :php:meth:`public setZipcode\($Zipcode\)<Firstred\\PostNL\\Entity\\StatusAddress::setZipcode\(\)>`
* :php:meth:`public setAddressType\($AddressType\)<Firstred\\PostNL\\Entity\\StatusAddress::setAddressType\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static AddressType

	:Type: string | null PostNL internal applications validate the receiver address\. In case the spelling of
		addresses should be different according to our PostNL information, the address details will
		be corrected\. This can be noticed in Track & Trace\.
		
		Please note that the webservice will not add address details\. Street and City fields will
		only be printed when they are in the call towards the labeling webservice\.
		
		The element Address type is a code in the request\. Possible values are:
		
		Code Description
		01   Receiver
		02   Sender
		03   Alternative sender address
		04   Collection address \(In the orders need to be collected first\)
		08   Return address\*
		09   Drop off location \(for use with Pick up at PostNL location\)
		
		\> \* When using the ‘label in the box return label’, it is mandatory to use an
		\>   \`Antwoordnummer\` in AddressType 08\.
		\>   This cannot be a regular address
		
		The following rules apply:
		If there is no Address specified with AddressType = 02, the data from Customer/Address
		will be added to the list as AddressType 02\.
		If there is no Customer/Address, the message will be rejected\.
		
		At least one other AddressType must be specified, other than AddressType 02
		In most cases this will be AddressType 01, the receiver address\.
	


.. php:attr:: protected static Building

	:Type: string | null 


.. php:attr:: protected static City

	:Type: string | null 


.. php:attr:: protected static CompanyName

	:Type: string | null 


.. php:attr:: protected static CountryCode

	:Type: string | null 


.. php:attr:: protected static DepartmentName

	:Type: string | null 


.. php:attr:: protected static District

	:Type: string | null 


.. php:attr:: protected static FirstName

	:Type: string | null 


.. php:attr:: protected static Floor

	:Type: string | null 


.. php:attr:: protected static HouseNumber

	:Type: string | null 


.. php:attr:: protected static HouseNumberSuffix

	:Type: string | null 


.. php:attr:: protected static LastName

	:Type: string | null 


.. php:attr:: protected static Region

	:Type: string | null 


.. php:attr:: protected static RegistrationDate

	:Type: string | null 


.. php:attr:: protected static Remark

	:Type: string | null 


.. php:attr:: protected static Street

	:Type: string | null 


.. php:attr:: protected static Zipcode

	:Type: string | null 


.. php:attr:: protected static other

	:Type: array | null Array with optional properties


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $AddressType=null, $FirstName=null, $LastName=null, $CompanyName=null, $DepartmentName=null, $Street=null, $HouseNumber=null, $HouseNumberSuffix=null, $Zipcode=null, $City=null, $CountryCode=null, $Region=null, $District=null, $Building=null, $Floor=null, $Remark=null, $RegistrationDate=null)
	
		
		:Parameters:
			* **$AddressType** (string | null)  
			* **$FirstName** (string | null)  
			* **$LastName** (string | null)  
			* **$CompanyName** (string | null)  
			* **$DepartmentName** (string | null)  
			* **$Street** (string | null)  
			* **$HouseNumber** (string | null)  
			* **$HouseNumberSuffix** (string | null)  
			* **$Zipcode** (string | null)  
			* **$City** (string | null)  
			* **$CountryCode** (string | null)  
			* **$Region** (string | null)  
			* **$District** (string | null)  
			* **$Building** (string | null)  
			* **$Floor** (string | null)  
			* **$Remark** (string | null)  
			* **$RegistrationDate** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setZipcode( $Zipcode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set postcode\.
			
		
		
		:Parameters:
			* **$Zipcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setAddressType( $AddressType=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the AddressType\.
			
		
		
		:Parameters:
			* **$AddressType** (int | string | null)  

		
		:Returns: static 
	
	

