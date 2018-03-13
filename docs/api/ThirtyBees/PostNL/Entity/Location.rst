.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Location
========


.. php:namespace:: ThirtyBees\PostNL\Entity

.. php:class:: Location


	.. rst-class:: phpdoc-description
	
		| Class Location
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

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

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Coordinates <ThirtyBees\\PostNL\\Entity\\Coordinates>` | null 


.. php:attr:: protected static CoordinatesNorthWest

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\CoordinatesNorthWest <ThirtyBees\\PostNL\\Entity\\CoordinatesNorthWest>` | null 


.. php:attr:: protected static CoordinatesSouthEast

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\CoordinatesSouthEast <ThirtyBees\\PostNL\\Entity\\CoordinatesSouthEast>` | null 


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

	.. php:method:: public __construct( $zipcode=null, $allowSundaySorting=null, $deliveryDate=null, $deliveryOptions=null, $options=null, $coordinates=null, $coordinatesNW=null, $coordinatesSE=null, $city=null, $street=null, $houseNr=null, $houseNrExt=null, $locationCode=null, $saleschannel=null, $terminalType=null, $retailNetworkId=null, $downPartnerID=null, $downPartnerLocation=null)
	
		
		:Parameters:
			* **$zipcode** (string | null)  
			* **$allowSundaySorting** (string | null)  
			* **$deliveryDate** (string | null)  
			* **$deliveryOptions** (array | null)  
			* **$options** (array | null)  
			* **$coordinates** (:any:`ThirtyBees\\PostNL\\Entity\\Coordinates <ThirtyBees\\PostNL\\Entity\\Coordinates>` | null)  
			* **$coordinatesNW** (:any:`ThirtyBees\\PostNL\\Entity\\CoordinatesNorthWest <ThirtyBees\\PostNL\\Entity\\CoordinatesNorthWest>` | null)  
			* **$coordinatesSE** (:any:`ThirtyBees\\PostNL\\Entity\\CoordinatesSouthEast <ThirtyBees\\PostNL\\Entity\\CoordinatesSouthEast>` | null)  
			* **$city** (string | null)  
			* **$street** (string | null)  
			* **$houseNr** (string | null)  
			* **$houseNrExt** (string | null)  
			* **$locationCode** (string | null)  
			* **$saleschannel** (string | null)  
			* **$terminalType** (string | null)  
			* **$retailNetworkId** (string | null)  
			* **$downPartnerID** (string | null)  
			* **$downPartnerLocation** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setPostalcode( $postcode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the postcode
			
		
		
		:Parameters:
			* **$postcode** (string | null)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Location <ThirtyBees\\PostNL\\Entity\\Location>` 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

