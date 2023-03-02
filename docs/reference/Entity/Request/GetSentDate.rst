.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSentDate
===========


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetSentDate


	.. rst-class:: phpdoc-description
	
		| Class GetSentDate\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AllowSundaySorting, $City, $CountryCode, $HouseNr, $HouseNrExt, $Options, $PostalCode, $DeliveryDate, $Street, $ShippingDuration\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::\_\_construct\(\)>`
* :php:meth:`public setDeliveryDate\($deliveryDate\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setDeliveryDate\(\)>`
* :php:meth:`public setPostalCode\($postcode\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setPostalCode\(\)>`
* :php:meth:`public setAllowSundaySorting\($AllowSundaySorting\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setAllowSundaySorting\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::xmlSerialize\(\)>`


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


.. php:attr:: protected static DeliveryDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


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

	.. php:method:: public __construct( $AllowSundaySorting=false, $City=null, $CountryCode=null, $HouseNr=null, $HouseNrExt=null, $Options=null, $PostalCode=null, $DeliveryDate=null, $Street=null, $ShippingDuration=null)
	
		.. rst-class:: phpdoc-description
		
			| GetSentDate constructor\.
			
		
		
		:Parameters:
			* **$AllowSundaySorting** (bool | null)  
			* **$City** (string | null)  
			* **$CountryCode** (string | null)  
			* **$HouseNr** (string | null)  
			* **$HouseNrExt** (string | null)  
			* **$Options** (array | null)  
			* **$PostalCode** (string | null)  
			* **$DeliveryDate** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  
			* **$Street** (string | null)  
			* **$ShippingDuration** (string | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDate( $deliveryDate=null)
	
		
		:Parameters:
			* **$deliveryDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
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

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Request\\GetSentDate <Firstred\\PostNL\\Entity\\Request\\GetSentDate>` 
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

