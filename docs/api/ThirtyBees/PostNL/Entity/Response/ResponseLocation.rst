.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseLocation
================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: ResponseLocation


	.. rst-class:: phpdoc-description
	
		| Class ResponseLocation
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static Address

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Address <ThirtyBees\\PostNL\\Entity\\Address>` | null 


.. php:attr:: protected static DeliveryOptions

	:Type: string[] | null 


.. php:attr:: protected static Distance

	:Type: string | null 


.. php:attr:: protected static Latitude

	:Type: string | null 


.. php:attr:: protected static Longitude

	:Type: string | null 


.. php:attr:: protected static Name

	:Type: string | null 


.. php:attr:: protected static OpeningHours

	:Type: string[] | null 


.. php:attr:: protected static PartnerName

	:Type: string | null 


.. php:attr:: protected static PhoneNumber

	:Type: string | null 


.. php:attr:: protected static LocationCode

	:Type: string | null 


.. php:attr:: protected static RetailNetworkID

	:Type: string | null 


.. php:attr:: protected static Saleschannel

	:Type: string | null 


.. php:attr:: protected static TerminalType

	:Type: string | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Warning\[\] <ThirtyBees\\PostNL\\Entity\\Warning>` | null 


.. php:attr:: protected static DownPartnerID

	:Type: string | null 


.. php:attr:: protected static DownPartnerLocation

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $address=null, $deliveryOptions=null, $distance=null, $latitude=null, $longitude=null, $name=null, $openingHours=null, $partnerName=null, $phoneNumber=null, $locationCode=null, $retailNetworkId=null, $saleschannel=null, $terminalType=null, $warnings=null, $downPartnerID=null, $downPartnerLocation=null)
	
		.. rst-class:: phpdoc-description
		
			| ResponseLocation constructor\.
			
		
		
		:Parameters:
			* **$address** (:any:`ThirtyBees\\PostNL\\Entity\\Address <ThirtyBees\\PostNL\\Entity\\Address>` | null)  
			* **$deliveryOptions** (string[] | null)  
			* **$distance** (string | null)  
			* **$latitude** (string | null)  
			* **$longitude** (string | null)  
			* **$name** (string | null)  
			* **$openingHours** (string[] | null)  
			* **$partnerName** (string | null)  
			* **$phoneNumber** (string | null)  
			* **$locationCode** (string | null)  
			* **$retailNetworkId** (string | null)  
			* **$saleschannel** (string | null)  
			* **$terminalType** (string | null)  
			* **$warnings** (:any:`ThirtyBees\\PostNL\\Entity\\Warning\[\] <ThirtyBees\\PostNL\\Entity\\Warning>` | null)  
			* **$downPartnerID** (string | null)  
			* **$downPartnerLocation** (string | null)  

		
	
	

