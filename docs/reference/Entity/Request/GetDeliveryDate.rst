.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetDeliveryDate
===============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetDeliveryDate


	.. rst-class:: phpdoc-description
	
		| Class GetDeliveryDate\.
		
		| This class is both the container and can be the actual GetDeliveryDate object itself\!
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AllowSundaySorting, $City, $CountryCode, $CutOffTimes, $HouseNr, $HouseNrExt, $Options, $OriginCountryCode, $PostalCode, $ShippingDate, $ShippingDuration, $Street, $GetDeliveryDate, $Message\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::\_\_construct\(\)>`
* :php:meth:`public setShippingDate\($shippingDate\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setShippingDate\(\)>`
* :php:meth:`public setPostalCode\($postcode\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setPostalCode\(\)>`
* :php:meth:`public setAllowSundaySorting\($AllowSundaySorting\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setAllowSundaySorting\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setMessage\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static AllowSundaySorting

	:Type: bool | null 


.. php:attr:: protected static City

	:Type: string | null 


.. php:attr:: protected static CountryCode

	:Type: string | null 


.. php:attr:: protected static CutOffTimes

	:Type: :any:`\\Firstred\\PostNL\\Entity\\CutOffTime\[\] <Firstred\\PostNL\\Entity\\CutOffTime>` | null 


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

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static ShippingDuration

	:Type: string | null 


.. php:attr:: protected static Street

	:Type: string | null 


.. php:attr:: protected static GetDeliveryDate

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate <Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	:Deprecated: 1.4.1 SOAP support is going to be removed


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $AllowSundaySorting=null, $City=null, $CountryCode=null, $CutOffTimes=null, $HouseNr=null, $HouseNrExt=null, $Options=null, $OriginCountryCode=null, $PostalCode=null, $ShippingDate=null, $ShippingDuration=null, $Street=null, $GetDeliveryDate=null, $Message=null)
	
		.. rst-class:: phpdoc-description
		
			| GetDeliveryDate constructor\.
			
		
		
		:Parameters:
			* **$AllowSundaySorting** (bool | null)  
			* **$City** (string | null)  
			* **$CountryCode** (string | null)  
			* **$CutOffTimes** (array | null)  
			* **$HouseNr** (string | null)  
			* **$HouseNrExt** (string | null)  
			* **$Options** (array | null)  
			* **$OriginCountryCode** (string | null)  
			* **$PostalCode** (string | null)  
			* **$ShippingDate** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  
			* **$ShippingDuration** (string | null)  
			* **$Street** (string | null)  
			* **$GetDeliveryDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate <Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setShippingDate( $shippingDate=null)
	
		
		:Parameters:
			* **$shippingDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setPostalCode( $postcode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the postcode\.
			
		
		
		:Parameters:
			* **$postcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setAllowSundaySorting( $AllowSundaySorting=null)
	
		
		:Parameters:
			* **$AllowSundaySorting** (string | bool | int | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate <Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate>` 
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public deprecated

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

