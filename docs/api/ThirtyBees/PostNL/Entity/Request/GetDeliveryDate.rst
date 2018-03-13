.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetDeliveryDate
===============


.. php:namespace:: ThirtyBees\PostNL\Entity\Request

.. php:class:: GetDeliveryDate


	.. rst-class:: phpdoc-description
	
		| Class GetDeliveryDate
		
		| This class is both the container and can be the actual GetDeliveryDate object itself\!
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static AllowSundaySorting

	:Type: bool | null 


.. php:attr:: protected static City

	:Type: string | null 


.. php:attr:: protected static CountryCode

	:Type: string | null 


.. php:attr:: protected static CutOffTimes

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\CutOffTime\[\] <ThirtyBees\\PostNL\\Entity\\CutOffTime>` | null 


.. php:attr:: protected static HouseNr

	:Type: string | null 


.. php:attr:: protected static HouseNrExt

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static OriginCountryCode

	:Type: string | null 


.. php:attr:: protected static PostalCode

	:Type: string | null 


.. php:attr:: protected static ShippingDate

	:Type: string | null 


.. php:attr:: protected static ShippingDuration

	:Type: string | null 


.. php:attr:: protected static Street

	:Type: string | null 


.. php:attr:: protected static GetDeliveryDate

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate <ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $allowSundaySorting=null, $city=null, $countryCode=null, $cutOffTimes=null, $houseNr=null, $houseNrExt=null, $options=null, $originCountryCode=null, $postalCode=null, $shippingDate=null, $shippingDuration=null, $street=null, $getDeliveryDate=null, $message=null)
	
		.. rst-class:: phpdoc-description
		
			| GetDeliveryDate constructor\.
			
		
		
		:Parameters:
			* **$allowSundaySorting** (bool | null)  
			* **$city** (string | null)  
			* **$countryCode** (string | null)  
			* **$cutOffTimes** (array | null)  
			* **$houseNr** (string | null)  
			* **$houseNrExt** (string | null)  
			* **$options** (array | null)  
			* **$originCountryCode** (string | null)  
			* **$postalCode** (string | null)  
			* **$shippingDate** (string | null)  
			* **$shippingDuration** (string | null)  
			* **$street** (string | null)  
			* **$getDeliveryDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate <ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate>` | null)  
			* **$message** (:any:`ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setPostalCode( $postcode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the postcode
			
		
		
		:Parameters:
			* **$postcode** (string | null)  

		
		:Returns: $this 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

