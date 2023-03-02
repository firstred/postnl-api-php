.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Location
========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Location


	.. rst-class:: phpdoc-description
	
		| Class Location\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Postalcode, $AllowSundaySorting, $DeliveryDate, $DeliveryOptions, $Options, $Coordinates, $CoordinatesNorthWest, $CoordinatesSouthEast, $City, $Street, $HouseNr, $HouseNrExt, $LocationCode, $Saleschannel, $TerminalType, $RetailNetworkID, $DownPartnerID, $DownPartnerLocation\)<Firstred\\PostNL\\Entity\\Location::\_\_construct\(\)>`
* :php:meth:`public setDeliveryDate\($DeliveryDate\)<Firstred\\PostNL\\Entity\\Location::setDeliveryDate\(\)>`
* :php:meth:`public setPostalcode\($Postalcode\)<Firstred\\PostNL\\Entity\\Location::setPostalcode\(\)>`
* :php:meth:`public setAllowSundaySorting\($AllowSundaySorting\)<Firstred\\PostNL\\Entity\\Location::setAllowSundaySorting\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Location::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static AllowSundaySorting

	:Type: string | null 


.. php:attr:: protected static DeliveryDate

	:Type: string | null 


.. php:attr:: protected static DeliveryOptions

	:Type: string[] | null 


.. php:attr:: protected static OpeningTime

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static City

	:Type: string | null 


.. php:attr:: protected static HouseNr

	:Type: string | null 


.. php:attr:: protected static HouseNrExt

	:Type: string | null 


.. php:attr:: protected static Postalcode

	:Type: string | null 


.. php:attr:: protected static Street

	:Type: string | null 


.. php:attr:: protected static Coordinates

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Coordinates <Firstred\\PostNL\\Entity\\Coordinates>` | null 


.. php:attr:: protected static CoordinatesNorthWest

	:Type: :any:`\\Firstred\\PostNL\\Entity\\CoordinatesNorthWest <Firstred\\PostNL\\Entity\\CoordinatesNorthWest>` | null 


.. php:attr:: protected static CoordinatesSouthEast

	:Type: :any:`\\Firstred\\PostNL\\Entity\\CoordinatesSouthEast <Firstred\\PostNL\\Entity\\CoordinatesSouthEast>` | null 


.. php:attr:: protected static LocationCode

	:Type: string | null 


.. php:attr:: protected static Saleschannel

	:Type: string | null 


.. php:attr:: protected static TerminalType

	:Type: string | null 


.. php:attr:: protected static RetailNetworkID

	:Type: string | null 


.. php:attr:: protected static DownPartnerID

	:Type: string | null 


.. php:attr:: protected static DownPartnerLocation

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Postalcode=null, $AllowSundaySorting=null, $DeliveryDate=null, $DeliveryOptions=null, $Options=null, $Coordinates=null, $CoordinatesNorthWest=null, $CoordinatesSouthEast=null, $City=null, $Street=null, $HouseNr=null, $HouseNrExt=null, $LocationCode=null, $Saleschannel=null, $TerminalType=null, $RetailNetworkID=null, $DownPartnerID=null, $DownPartnerLocation=null)
	
		
		:Parameters:
			* **$Postalcode** (string | null)  
			* **$AllowSundaySorting** (string | null)  
			* **$DeliveryDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$DeliveryOptions** (array | null)  
			* **$Options** (array | null)  
			* **$Coordinates** (:any:`Firstred\\PostNL\\Entity\\Coordinates <Firstred\\PostNL\\Entity\\Coordinates>` | null)  
			* **$CoordinatesNorthWest** (:any:`Firstred\\PostNL\\Entity\\CoordinatesNorthWest <Firstred\\PostNL\\Entity\\CoordinatesNorthWest>` | null)  
			* **$CoordinatesSouthEast** (:any:`Firstred\\PostNL\\Entity\\CoordinatesSouthEast <Firstred\\PostNL\\Entity\\CoordinatesSouthEast>` | null)  
			* **$City** (string | null)  
			* **$Street** (string | null)  
			* **$HouseNr** (string | null)  
			* **$HouseNrExt** (string | null)  
			* **$LocationCode** (string | null)  
			* **$Saleschannel** (string | null)  
			* **$TerminalType** (string | null)  
			* **$RetailNetworkID** (string | null)  
			* **$DownPartnerID** (string | null)  
			* **$DownPartnerLocation** (string | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDate( $DeliveryDate=null)
	
		
		:Parameters:
			* **$DeliveryDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setPostalcode( $Postalcode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the postcode\.
			
		
		
		:Parameters:
			* **$Postalcode** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Location <Firstred\\PostNL\\Entity\\Location>` 
	
	

.. rst-class:: public

	.. php:method:: public setAllowSundaySorting( $AllowSundaySorting=null)
	
		
		:Parameters:
			* **$AllowSundaySorting** (string | bool | int | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Location <Firstred\\PostNL\\Entity\\Location>` 
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

