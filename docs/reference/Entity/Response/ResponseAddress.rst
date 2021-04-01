.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseAddress
===============


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: ResponseAddress


	.. rst-class:: phpdoc-description
	
		| Class ResponseAddress\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AddressType, $FirstName, $Name, $CompanyName, $Street, $HouseNr, $HouseNrExt, $Zipcode, $City, $Countrycode, $Area, $BuildingName, $Department, $Doorcode, $Floor, $Region, $Remark\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::\_\_construct\(\)>`
* :php:meth:`public setZipcode\($Zipcode\)<Firstred\\PostNL\\Entity\\Response\\ResponseAddress::setZipcode\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static AddressType

	:Type: string | null PostNL internal applications validate the receiver ResponseAddress\. In case the spelling of
		ResponseAddresses should be different according to our PostNL information, the ResponseAddress details will
		be corrected\. This can be noticed in Track & Trace\.
		
		Please note that the webservice will not add ResponseAddress details\. Street and City fields will
		only be printed when they are in the call towards the labeling webservice\.
		
		The element ResponseAddress type is a code in the request\. Possible values are:
		
		Code Description
		01   Receiver
		02   Sender
		03   Alternative sender ResponseAddress
		04   Collection ResponseAddress \(In the orders need to be collected first\)
		08   Return ResponseAddress\*
		09   Drop off location \(for use with Pick up at PostNL location\)
		
		\> \* When using the ‘label in the box return label’, it is mandatory to use an
		\>   \`Antwoordnummer\` in AddressType 08\.
		\>   This cannot be a regular ResponseAddress
		
		The following rules apply:
		If there is no ResponseAddress specified with AddressType = 02, the data from Customer/ResponseAddress
		will be added to the list as AddressType 02\.
		If there is no Customer/ResponseAddress, the message will be rejected\.
		
		At least one other AddressType must be specified, other than AddressType 02
		In most cases this will be AddressType 01, the receiver ResponseAddress\.
	


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

	:Type: array | null Array with optional properties


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $AddressType=null, $FirstName=null, $Name=null, $CompanyName=null, $Street=null, $HouseNr=null, $HouseNrExt=null, $Zipcode=null, $City=null, $Countrycode=null, $Area=null, $BuildingName=null, $Department=null, $Doorcode=null, $Floor=null, $Region=null, $Remark=null)
	
		
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
			* **$BuildingName** (string | null)  
			* **$Department** (string | null)  
			* **$Doorcode** (string | null)  
			* **$Floor** (string | null)  
			* **$Region** (string | null)  
			* **$Remark** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setZipcode( $Zipcode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set postcode\.
			
		
		
		:Parameters:
			* **$Zipcode** (string | null)  

		
		:Returns: static 
	
	

