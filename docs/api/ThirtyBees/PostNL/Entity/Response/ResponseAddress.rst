.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseAddress
===============


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: ResponseAddress


	.. rst-class:: phpdoc-description
	
		| Class ResponseAddress
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static ResponseAddressType

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
		\>   \`Antwoordnummer\` in ResponseAddressType 08\.
		\>   This cannot be a regular ResponseAddress
		
		The following rules apply:
		If there is no ResponseAddress specified with ResponseAddressType = 02, the data from Customer/ResponseAddress
		will be added to the list as ResponseAddressType 02\.
		If there is no Customer/ResponseAddress, the message will be rejected\.
		
		At least one other ResponseAddressType must be specified, other than ResponseAddressType 02
		In most cases this will be ResponseAddressType 01, the receiver ResponseAddress\.
	


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

	.. php:method:: public __construct( $ResponseAddressType=null, $firstName=null, $name=null, $companyName=null, $street=null, $houseNr=null, $houseNrExt=null, $zipcode=null, $city=null, $countryCode=null, $area=null, $buildingName=null, $department=null, $doorcode=null, $floor=null, $region=null, $remark=null)
	
		
		:Parameters:
			* **$ResponseAddressType** (string | null)  
			* **$firstName** (string | null)  
			* **$name** (string | null)  
			* **$companyName** (string | null)  
			* **$street** (string | null)  
			* **$houseNr** (string | null)  
			* **$houseNrExt** (string | null)  
			* **$zipcode** (string | null)  
			* **$city** (string | null)  
			* **$countryCode** (string | null)  
			* **$area** (string | null)  
			* **$buildingName** (string | null)  
			* **$department** (string | null)  
			* **$doorcode** (string | null)  
			* **$floor** (string | null)  
			* **$region** (string | null)  
			* **$remark** (string | null)  

		
	
	

