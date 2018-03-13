.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSentDate
===========


.. php:namespace:: ThirtyBees\PostNL\Entity\Request

.. php:class:: GetSentDate


	.. rst-class:: phpdoc-description
	
		| Class GetSentDate
		
	
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


.. php:attr:: protected static DeliveryDate

	:Type: string | null 


.. php:attr:: protected static HouseNr

	:Type: string | null 


.. php:attr:: protected static HouseNrExt

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static PostalCode

	:Type: string | null 


.. php:attr:: protected static ShippingDuration

	:Type: string | null 


.. php:attr:: protected static Street

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $allowSundaySorting=false, $city=null, $countryCode=null, $houseNr=null, $houseNrExt=null, $options=null, $postalCode=null, $DeliveryDate=null, $street=null, $shippingDuration=null)
	
		.. rst-class:: phpdoc-description
		
			| GetSentDate constructor\.
			
		
		
		:Parameters:
			* **$allowSundaySorting** (bool | null)  
			* **$city** (string | null)  
			* **$countryCode** (string | null)  
			* **$houseNr** (string | null)  
			* **$houseNrExt** (string | null)  
			* **$options** (array | null)  
			* **$postalCode** (string | null)  
			* **$DeliveryDate** (string | null)  
			* **$street** (string | null)  
			* **$shippingDuration** (string | null)  

		
	
	

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
	
	

