.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseAddress
===============


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: ResponseAddress


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AddressType, $FirstName, $Name, $CompanyName, $Street, $HouseNr, $HouseNrExt, $Zipcode, $City, $Countrycode, $Area, $Buildingname, $Department, $Doorcode, $Floor, $Region, $Remark\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::\_\_construct\(\)>`
* :php:meth:`public getAddressType\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getAddressType\(\)>`
* :php:meth:`public setAddressType\($AddressType\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setAddressType\(\)>`
* :php:meth:`public getArea\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getArea\(\)>`
* :php:meth:`public setArea\($Area\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setArea\(\)>`
* :php:meth:`public getBuildingname\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getBuildingname\(\)>`
* :php:meth:`public setBuildingname\($Buildingname\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setBuildingname\(\)>`
* :php:meth:`public getCity\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getCity\(\)>`
* :php:meth:`public setCity\($City\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setCity\(\)>`
* :php:meth:`public getCompanyName\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getCompanyName\(\)>`
* :php:meth:`public setCompanyName\($CompanyName\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setCompanyName\(\)>`
* :php:meth:`public getCountrycode\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getCountrycode\(\)>`
* :php:meth:`public setCountrycode\($Countrycode\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setCountrycode\(\)>`
* :php:meth:`public getDepartment\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getDepartment\(\)>`
* :php:meth:`public setDepartment\($Department\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setDepartment\(\)>`
* :php:meth:`public getDoorcode\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getDoorcode\(\)>`
* :php:meth:`public setDoorcode\($Doorcode\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setDoorcode\(\)>`
* :php:meth:`public getFirstName\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getFirstName\(\)>`
* :php:meth:`public setFirstName\($FirstName\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setFirstName\(\)>`
* :php:meth:`public getFloor\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getFloor\(\)>`
* :php:meth:`public setFloor\($Floor\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setFloor\(\)>`
* :php:meth:`public getHouseNr\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getHouseNr\(\)>`
* :php:meth:`public setHouseNr\($HouseNr\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setHouseNr\(\)>`
* :php:meth:`public getHouseNrExt\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getHouseNrExt\(\)>`
* :php:meth:`public setHouseNrExt\($HouseNrExt\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setHouseNrExt\(\)>`
* :php:meth:`public getName\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getName\(\)>`
* :php:meth:`public setName\($Name\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setName\(\)>`
* :php:meth:`public getRegion\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getRegion\(\)>`
* :php:meth:`public setRegion\($Region\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setRegion\(\)>`
* :php:meth:`public getRemark\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getRemark\(\)>`
* :php:meth:`public setRemark\($Remark\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setRemark\(\)>`
* :php:meth:`public getStreet\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getStreet\(\)>`
* :php:meth:`public setStreet\($Street\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setStreet\(\)>`
* :php:meth:`public getOther\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getOther\(\)>`
* :php:meth:`public setOther\($other\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setOther\(\)>`
* :php:meth:`public getZipcode\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::getZipcode\(\)>`
* :php:meth:`public setZipcode\($Zipcode\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setZipcode\(\)>`


Properties
----------

.. php:attr:: protected static AddressType

	.. rst-class:: phpdoc-description
	
		| PostNL internal applications validate the receiver ResponseAddress\. In case the spelling of
		| ResponseAddresses should be different according to our PostNL information, the ResponseAddress details will
		| be corrected\. This can be noticed in Track & Trace\.
		
		| Please note that the webservice will not add ResponseAddress details\. Street and City fields will
		| only be printed when they are in the call towards the labeling webservice\.
		| 
		| The element ResponseAddress type is a code in the request\. Possible values are:
		| 
		| Code Description
		| 01   Receiver
		| 02   Sender
		| 03   Alternative sender ResponseAddress
		| 04   Collection ResponseAddress \(In the orders need to be collected first\)
		| 08   Return ResponseAddress\*
		| 09   Drop off location \(for use with Pick up at PostNL location\)
		| 
		| \> \* When using the ‘label in the box return label’, it is mandatory to use an
		| \>   \`Antwoordnummer\` in AddressType 08\.
		| \>   This cannot be a regular ResponseAddress
		| 
		| The following rules apply:
		| If there is no ResponseAddress specified with AddressType = 02, the data from Customer/ResponseAddress
		| will be added to the list as AddressType 02\.
		| If there is no Customer/ResponseAddress, the message will be rejected\.
		| 
		| At least one other AddressType must be specified, other than AddressType 02
		| In most cases this will be AddressType 01, the receiver ResponseAddress\.
		
	
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



Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $AddressType=null, $FirstName=null, $Name=null, $CompanyName=null, $Street=null, $HouseNr=null, $HouseNrExt=null, $Zipcode=null, $City=null, $Countrycode=null, $Area=null, $Buildingname=null, $Department=null, $Doorcode=null, $Floor=null, $Region=null, $Remark=null)
	
		
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

		
	
	

.. rst-class:: public

	.. php:method:: public getAddressType()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setAddressType( $AddressType)
	
		
		:Parameters:
			* **$AddressType** (string | null)  

		
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

	.. php:method:: public setHouseNr( $HouseNr)
	
		
		:Parameters:
			* **$HouseNr** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getHouseNrExt()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNrExt( $HouseNrExt)
	
		
		:Parameters:
			* **$HouseNrExt** (string | null)  

		
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
	
	

.. rst-class:: public

	.. php:method:: public getOther()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setOther( $other)
	
		
		:Parameters:
			* **$other** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\ResponseAddress <Firstred\\PostNL\\Entity\\Response\\ResponseAddress>` 
	
	

.. rst-class:: public

	.. php:method:: public getZipcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setZipcode( $Zipcode=null)
	
		
		:Parameters:
			* **$Zipcode** (string | null)  

		
		:Returns: static 
	
	

