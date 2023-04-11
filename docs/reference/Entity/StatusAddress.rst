.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


StatusAddress
=============


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: StatusAddress


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AddressType, $FirstName, $LastName, $CompanyName, $DepartmentName, $Street, $HouseNumber, $HouseNumberSuffix, $Zipcode, $City, $CountryCode, $Region, $District, $Building, $Floor, $Remark, $RegistrationDate\)<Firstred\\PostNL\\Entity\\StatusAddress::\_\_construct\(\)>`
* :php:meth:`public getBuilding\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getBuilding\(\)>`
* :php:meth:`public setBuilding\($Building\)<Firstred\\PostNL\\Entity\\StatusAddress::setBuilding\(\)>`
* :php:meth:`public getCity\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getCity\(\)>`
* :php:meth:`public setCity\($City\)<Firstred\\PostNL\\Entity\\StatusAddress::setCity\(\)>`
* :php:meth:`public getCompanyName\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getCompanyName\(\)>`
* :php:meth:`public setCompanyName\($CompanyName\)<Firstred\\PostNL\\Entity\\StatusAddress::setCompanyName\(\)>`
* :php:meth:`public getCountryCode\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getCountryCode\(\)>`
* :php:meth:`public setCountryCode\($CountryCode\)<Firstred\\PostNL\\Entity\\StatusAddress::setCountryCode\(\)>`
* :php:meth:`public getDepartmentName\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getDepartmentName\(\)>`
* :php:meth:`public setDepartmentName\($DepartmentName\)<Firstred\\PostNL\\Entity\\StatusAddress::setDepartmentName\(\)>`
* :php:meth:`public getDistrict\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getDistrict\(\)>`
* :php:meth:`public setDistrict\($District\)<Firstred\\PostNL\\Entity\\StatusAddress::setDistrict\(\)>`
* :php:meth:`public getFirstName\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getFirstName\(\)>`
* :php:meth:`public setFirstName\($FirstName\)<Firstred\\PostNL\\Entity\\StatusAddress::setFirstName\(\)>`
* :php:meth:`public getFloor\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getFloor\(\)>`
* :php:meth:`public setFloor\($Floor\)<Firstred\\PostNL\\Entity\\StatusAddress::setFloor\(\)>`
* :php:meth:`public getHouseNumber\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getHouseNumber\(\)>`
* :php:meth:`public setHouseNumber\($HouseNumber\)<Firstred\\PostNL\\Entity\\StatusAddress::setHouseNumber\(\)>`
* :php:meth:`public getHouseNumberSuffix\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getHouseNumberSuffix\(\)>`
* :php:meth:`public setHouseNumberSuffix\($HouseNumberSuffix\)<Firstred\\PostNL\\Entity\\StatusAddress::setHouseNumberSuffix\(\)>`
* :php:meth:`public getLastName\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getLastName\(\)>`
* :php:meth:`public setLastName\($LastName\)<Firstred\\PostNL\\Entity\\StatusAddress::setLastName\(\)>`
* :php:meth:`public getRegion\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getRegion\(\)>`
* :php:meth:`public setRegion\($Region\)<Firstred\\PostNL\\Entity\\StatusAddress::setRegion\(\)>`
* :php:meth:`public getRemark\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getRemark\(\)>`
* :php:meth:`public setRemark\($Remark\)<Firstred\\PostNL\\Entity\\StatusAddress::setRemark\(\)>`
* :php:meth:`public getStreet\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getStreet\(\)>`
* :php:meth:`public setStreet\($Street\)<Firstred\\PostNL\\Entity\\StatusAddress::setStreet\(\)>`
* :php:meth:`public getAddressType\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getAddressType\(\)>`
* :php:meth:`public getRegistrationDate\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getRegistrationDate\(\)>`
* :php:meth:`public getZipcode\(\)<Firstred\\PostNL\\Entity\\StatusAddress::getZipcode\(\)>`
* :php:meth:`public setZipcode\($Zipcode\)<Firstred\\PostNL\\Entity\\StatusAddress::setZipcode\(\)>`
* :php:meth:`public setAddressType\($AddressType\)<Firstred\\PostNL\\Entity\\StatusAddress::setAddressType\(\)>`
* :php:meth:`public setRegistrationDate\($RegistrationDate\)<Firstred\\PostNL\\Entity\\StatusAddress::setRegistrationDate\(\)>`


Properties
----------

.. php:attr:: protected static AddressType

	.. rst-class:: phpdoc-description
	
		| PostNL internal applications validate the receiver address\. In case the spelling of
		| addresses should be different according to our PostNL information, the address details will
		| be corrected\. This can be noticed in Track & Trace\.
		
		| Please note that the webservice will not add address details\. Street and City fields will
		| only be printed when they are in the call towards the labeling webservice\.
		| 
		| The element Address type is a code in the request\. Possible values are:
		| 
		| Code Description
		| 01   Receiver
		| 02   Sender
		| 03   Alternative sender address
		| 04   Collection address \(In the orders need to be collected first\)
		| 08   Return address\*
		| 09   Drop off location \(for use with Pick up at PostNL location\)
		| 
		| \> \* When using the ‘label in the box return label’, it is mandatory to use an
		| \>   \`Antwoordnummer\` in AddressType 08\.
		| \>   This cannot be a regular address
		| 
		| The following rules apply:
		| If there is no Address specified with AddressType = 02, the data from Customer/Address
		| will be added to the list as AddressType 02\.
		| If there is no Customer/Address, the message will be rejected\.
		| 
		| At least one other AddressType must be specified, other than AddressType 02
		| In most cases this will be AddressType 01, the receiver address\.
		
	
	:Type: string | null 


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


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $AddressType=null, $FirstName=null, $LastName=null, $CompanyName=null, $DepartmentName=null, $Street=null, $HouseNumber=null, $HouseNumberSuffix=null, $Zipcode=null, $City=null, $CountryCode=null, $Region=null, $District=null, $Building=null, $Floor=null, $Remark=null, \\DateTimeInterface|string|null $RegistrationDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getBuilding()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setBuilding( $Building)
	
		
		:Parameters:
			* **$Building** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCity()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCity( $City)
	
		
		:Parameters:
			* **$City** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCompanyName()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCompanyName( $CompanyName)
	
		
		:Parameters:
			* **$CompanyName** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCountryCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCountryCode( $CountryCode)
	
		
		:Parameters:
			* **$CountryCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDepartmentName()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDepartmentName( $DepartmentName)
	
		
		:Parameters:
			* **$DepartmentName** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDistrict()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDistrict( $District)
	
		
		:Parameters:
			* **$District** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getFirstName()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setFirstName( $FirstName)
	
		
		:Parameters:
			* **$FirstName** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getFloor()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setFloor( $Floor)
	
		
		:Parameters:
			* **$Floor** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getHouseNumber()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNumber( $HouseNumber)
	
		
		:Parameters:
			* **$HouseNumber** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getHouseNumberSuffix()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNumberSuffix( $HouseNumberSuffix)
	
		
		:Parameters:
			* **$HouseNumberSuffix** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getLastName()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setLastName( $LastName)
	
		
		:Parameters:
			* **$LastName** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getRegion()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setRegion( $Region)
	
		
		:Parameters:
			* **$Region** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getRemark()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setRemark( $Remark)
	
		
		:Parameters:
			* **$Remark** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getStreet()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setStreet( $Street)
	
		
		:Parameters:
			* **$Street** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getAddressType()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public getRegistrationDate()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public getZipcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setZipcode( $Zipcode=null)
	
		
		:Parameters:
			* **$Zipcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setAddressType(int|string|null $AddressType=null)
	
		
		:Parameters:
			* **$AddressType** (int | string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setRegistrationDate(\\DateTimeInterface|string|null $RegistrationDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

