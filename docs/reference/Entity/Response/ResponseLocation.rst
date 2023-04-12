.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseLocation
================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: ResponseLocation


	.. rst-class:: phpdoc-description
	
		| Class ResponseLocation\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Address, $DeliveryOptions, $Distance, $Latitude, $Longitude, $Name, $OpeningHours, $PartnerName, $PhoneNumber, $LocationCode, $RetailNetworkID, $Saleschannel, $TerminalType, $Warnings, $DownPartnerID, $DownPartnerLocation, $Sustainability\)<Firstred\\PostNL\\Entity\\Response\\ResponseLocation::\_\_construct\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\ResponseLocation::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Address

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Address <Firstred\\PostNL\\Entity\\Address>` | null 


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

	:Type: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` | null 


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

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 


.. php:attr:: protected static DownPartnerID

	:Type: string | null 


.. php:attr:: protected static DownPartnerLocation

	:Type: string | null 


.. php:attr:: protected static Sustainability

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Address=null, $DeliveryOptions=null, $Distance=null, $Latitude=null, $Longitude=null, $Name=null, $OpeningHours=null, $PartnerName=null, $PhoneNumber=null, $LocationCode=null, $RetailNetworkID=null, $Saleschannel=null, $TerminalType=null, $Warnings=null, $DownPartnerID=null, $DownPartnerLocation=null, $Sustainability=null)
	
		.. rst-class:: phpdoc-description
		
			| ResponseLocation constructor\.
			
		
		
		:Parameters:
			* **$Address** (:any:`Firstred\\PostNL\\Entity\\Address <Firstred\\PostNL\\Entity\\Address>` | null)  
			* **$DeliveryOptions** (string[] | null)  
			* **$Distance** (string | null)  
			* **$Latitude** (string | null)  
			* **$Longitude** (string | null)  
			* **$Name** (string | null)  
			* **$OpeningHours** (string[] | null)  
			* **$PartnerName** (string | null)  
			* **$PhoneNumber** (string | null)  
			* **$LocationCode** (string | null)  
			* **$RetailNetworkID** (string | null)  
			* **$Saleschannel** (string | null)  
			* **$TerminalType** (string | null)  
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null)  
			* **$DownPartnerID** (string | null)  
			* **$DownPartnerLocation** (string | null)  
			* **$Sustainability** (:any:`Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
	
	

