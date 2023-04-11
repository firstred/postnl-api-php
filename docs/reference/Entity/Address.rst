.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Address
=======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Address


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AddressType, $FirstName, $Name, $CompanyName, $Street, $HouseNr, $HouseNrExt, $Zipcode, $City, $Countrycode, $Area, $Buildingname, $Department, $Doorcode, $Floor, $Region, $Remark, $StreetHouseNrExt\)<Firstred\\PostNL\\Entity\\Address::\_\_construct\(\)>`
* :php:meth:`public getZipcode\(\)<Firstred\\PostNL\\Entity\\Address::getZipcode\(\)>`
* :php:meth:`public setZipcode\($Zipcode\)<Firstred\\PostNL\\Entity\\Address::setZipcode\(\)>`
* :php:meth:`public getAddressType\(\)<Firstred\\PostNL\\Entity\\Address::getAddressType\(\)>`
* :php:meth:`public setAddressType\($AddressType\)<Firstred\\PostNL\\Entity\\Address::setAddressType\(\)>`
* :php:meth:`public getArea\(\)<Firstred\\PostNL\\Entity\\Address::getArea\(\)>`
* :php:meth:`public setArea\($Area\)<Firstred\\PostNL\\Entity\\Address::setArea\(\)>`
* :php:meth:`public getBuildingname\(\)<Firstred\\PostNL\\Entity\\Address::getBuildingname\(\)>`
* :php:meth:`public setBuildingname\($Buildingname\)<Firstred\\PostNL\\Entity\\Address::setBuildingname\(\)>`
* :php:meth:`public getCity\(\)<Firstred\\PostNL\\Entity\\Address::getCity\(\)>`
* :php:meth:`public setCity\($City\)<Firstred\\PostNL\\Entity\\Address::setCity\(\)>`
* :php:meth:`public getCompanyName\(\)<Firstred\\PostNL\\Entity\\Address::getCompanyName\(\)>`
* :php:meth:`public setCompanyName\($CompanyName\)<Firstred\\PostNL\\Entity\\Address::setCompanyName\(\)>`
* :php:meth:`public getCountrycode\(\)<Firstred\\PostNL\\Entity\\Address::getCountrycode\(\)>`
* :php:meth:`public setCountrycode\($Countrycode\)<Firstred\\PostNL\\Entity\\Address::setCountrycode\(\)>`
* :php:meth:`public getDepartment\(\)<Firstred\\PostNL\\Entity\\Address::getDepartment\(\)>`
* :php:meth:`public setDepartment\($Department\)<Firstred\\PostNL\\Entity\\Address::setDepartment\(\)>`
* :php:meth:`public getDoorcode\(\)<Firstred\\PostNL\\Entity\\Address::getDoorcode\(\)>`
* :php:meth:`public setDoorcode\($Doorcode\)<Firstred\\PostNL\\Entity\\Address::setDoorcode\(\)>`
* :php:meth:`public getFirstName\(\)<Firstred\\PostNL\\Entity\\Address::getFirstName\(\)>`
* :php:meth:`public setFirstName\($FirstName\)<Firstred\\PostNL\\Entity\\Address::setFirstName\(\)>`
* :php:meth:`public getFloor\(\)<Firstred\\PostNL\\Entity\\Address::getFloor\(\)>`
* :php:meth:`public setFloor\($Floor\)<Firstred\\PostNL\\Entity\\Address::setFloor\(\)>`
* :php:meth:`public getHouseNr\(\)<Firstred\\PostNL\\Entity\\Address::getHouseNr\(\)>`
* :php:meth:`public setHouseNr\($HouseNr\)<Firstred\\PostNL\\Entity\\Address::setHouseNr\(\)>`
* :php:meth:`public getHouseNrExt\(\)<Firstred\\PostNL\\Entity\\Address::getHouseNrExt\(\)>`
* :php:meth:`public setHouseNrExt\($HouseNrExt\)<Firstred\\PostNL\\Entity\\Address::setHouseNrExt\(\)>`
* :php:meth:`public getStreetHouseNrExt\(\)<Firstred\\PostNL\\Entity\\Address::getStreetHouseNrExt\(\)>`
* :php:meth:`public setStreetHouseNrExt\($StreetHouseNrExt\)<Firstred\\PostNL\\Entity\\Address::setStreetHouseNrExt\(\)>`
* :php:meth:`public getName\(\)<Firstred\\PostNL\\Entity\\Address::getName\(\)>`
* :php:meth:`public setName\($Name\)<Firstred\\PostNL\\Entity\\Address::setName\(\)>`
* :php:meth:`public getRegion\(\)<Firstred\\PostNL\\Entity\\Address::getRegion\(\)>`
* :php:meth:`public setRegion\($Region\)<Firstred\\PostNL\\Entity\\Address::setRegion\(\)>`
* :php:meth:`public getRemark\(\)<Firstred\\PostNL\\Entity\\Address::getRemark\(\)>`
* :php:meth:`public setRemark\($Remark\)<Firstred\\PostNL\\Entity\\Address::setRemark\(\)>`
* :php:meth:`public getStreet\(\)<Firstred\\PostNL\\Entity\\Address::getStreet\(\)>`
* :php:meth:`public setStreet\($Street\)<Firstred\\PostNL\\Entity\\Address::setStreet\(\)>`
* :php:meth:`public getOther\(\)<Firstred\\PostNL\\Entity\\Address::getOther\(\)>`
* :php:meth:`public setOther\($other\)<Firstred\\PostNL\\Entity\\Address::setOther\(\)>`


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


.. php:attr:: protected static Area

	:Type: string | null 


.. php:attr:: protected static Buildingname

	:Type: string | null 


.. php:attr:: protected static City

	:Type: string | null 


.. php:attr:: protected static CompanyName

	:Type: string | null 


.. php:attr:: protected static Countrycode

	:Type: string | null 


.. php:attr:: protected static Department

	:Type: string | null 


.. php:attr:: protected static Doorcode

	:Type: string | null 


.. php:attr:: protected static FirstName

	:Type: string | null 


.. php:attr:: protected static Floor

	:Type: string | null 


.. php:attr:: protected static HouseNr

	:Type: string | null 


.. php:attr:: protected static HouseNrExt

	:Type: string | null 


.. php:attr:: protected static StreetHouseNrExt

	:Type: string | null 


.. php:attr:: protected static Name

	:Type: string | null 


.. php:attr:: protected static Region

	:Type: string | null 


.. php:attr:: protected static Remark

	:Type: string | null 


.. php:attr:: protected static Street

	:Type: string | null 


.. php:attr:: protected static Zipcode

	:Type: string | null 


.. php:attr:: protected static other

	:Deprecated: 2.0.0 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $AddressType=null, $FirstName=null, $Name=null, $CompanyName=null, $Street=null, $HouseNr=null, $HouseNrExt=null, $Zipcode=null, $City=null, $Countrycode=null, $Area=null, $Buildingname=null, $Department=null, $Doorcode=null, $Floor=null, $Region=null, $Remark=null, $StreetHouseNrExt=null)
	
		
		:Parameters:
			* **$AddressType** (string | null)  
			* **$FirstName** (string | null)  
			* **$Name** (string | null)  
			* **$CompanyName** (string | null)  
			* **$Street** (string | null)  
			* **$HouseNr** (string | null)  
			* **$HouseNrExt** (string | null)  
			* **$Zipcode** (string | null)  
			* **$City** (string | null)  
			* **$Countrycode** (string | null)  
			* **$Area** (string | null)  
			* **$Buildingname** (string | null)  
			* **$Department** (string | null)  
			* **$Doorcode** (string | null)  
			* **$Floor** (string | null)  
			* **$Region** (string | null)  
			* **$Remark** (string | null)  
			* **$StreetHouseNrExt** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getZipcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setZipcode( $Zipcode=null)
	
		
		:Parameters:
			* **$Zipcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getAddressType()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setAddressType(int|string|null $AddressType=null)
	
		
		:Parameters:
			* **$AddressType** (int | string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getArea()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setArea( $Area)
	
		
		:Parameters:
			* **$Area** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getBuildingname()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setBuildingname( $Buildingname)
	
		
		:Parameters:
			* **$Buildingname** (string | null)  

		
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

	.. php:method:: public getCountrycode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCountrycode( $Countrycode)
	
		
		:Parameters:
			* **$Countrycode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDepartment()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDepartment( $Department)
	
		
		:Parameters:
			* **$Department** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDoorcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDoorcode( $Doorcode)
	
		
		:Parameters:
			* **$Doorcode** (string | null)  

		
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

	.. php:method:: public getHouseNr()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNr(int|string|null $HouseNr)
	
		
		:Parameters:
			* **$HouseNr** (int | string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getHouseNrExt()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNrExt(int|string|null $HouseNrExt)
	
		
		:Parameters:
			* **$HouseNrExt** (int | string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getStreetHouseNrExt()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setStreetHouseNrExt( $StreetHouseNrExt)
	
		
		:Parameters:
			* **$StreetHouseNrExt** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getName()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setName( $Name)
	
		
		:Parameters:
			* **$Name** (string | null)  

		
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
	
	

.. rst-class:: public deprecated

	.. php:method:: public getOther()
	
		
		:Returns: array | null 
		:Deprecated: 2.0.0 
	
	

.. rst-class:: public deprecated

	.. php:method:: public setOther( $other)
	
		
		:Parameters:
			* **$other** (array | null)  

		
		:Returns: static 
		:Deprecated: 2.0.0 
	
	

