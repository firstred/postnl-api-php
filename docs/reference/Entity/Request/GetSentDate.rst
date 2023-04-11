.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSentDate
===========


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetSentDate


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AllowSundaySorting, $City, $CountryCode, $HouseNr, $HouseNrExt, $Options, $PostalCode, $DeliveryDate, $Street, $ShippingDuration\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::\_\_construct\(\)>`
* :php:meth:`public getCity\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getCity\(\)>`
* :php:meth:`public setCity\($City\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setCity\(\)>`
* :php:meth:`public getCountryCode\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getCountryCode\(\)>`
* :php:meth:`public setCountryCode\($CountryCode\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setCountryCode\(\)>`
* :php:meth:`public getHouseNr\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getHouseNr\(\)>`
* :php:meth:`public setHouseNr\($HouseNr\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setHouseNr\(\)>`
* :php:meth:`public getHouseNrExt\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getHouseNrExt\(\)>`
* :php:meth:`public setHouseNrExt\($HouseNrExt\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setHouseNrExt\(\)>`
* :php:meth:`public getOptions\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getOptions\(\)>`
* :php:meth:`public setOptions\($Options\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setOptions\(\)>`
* :php:meth:`public getShippingDuration\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getShippingDuration\(\)>`
* :php:meth:`public setShippingDuration\($ShippingDuration\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setShippingDuration\(\)>`
* :php:meth:`public getStreet\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getStreet\(\)>`
* :php:meth:`public setStreet\($Street\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setStreet\(\)>`
* :php:meth:`public getAllowSundaySorting\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getAllowSundaySorting\(\)>`
* :php:meth:`public getDeliveryDate\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getDeliveryDate\(\)>`
* :php:meth:`public getPostalCode\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::getPostalCode\(\)>`
* :php:meth:`public setDeliveryDate\($deliveryDate\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setDeliveryDate\(\)>`
* :php:meth:`public setPostalCode\($postcode\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setPostalCode\(\)>`
* :php:meth:`public setAllowSundaySorting\($AllowSundaySorting\)<Firstred\\PostNL\\Entity\\Request\\GetSentDate::setAllowSundaySorting\(\)>`


Properties
----------

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

	.. php:method:: public __construct( $AllowSundaySorting=false, $City=null, $CountryCode=null, $HouseNr=null, $HouseNrExt=null, $Options=null, $PostalCode=null, \\DateTimeInterface|string|null $DeliveryDate=null, $Street=null, $ShippingDuration=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getCity()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCity( $City)
	
		
		:Parameters:
			* **$City** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCountryCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCountryCode( $CountryCode)
	
		
		:Parameters:
			* **$CountryCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getHouseNr()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNr( $HouseNr)
	
		
		:Parameters:
			* **$HouseNr** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getHouseNrExt()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNrExt( $HouseNrExt)
	
		
		:Parameters:
			* **$HouseNrExt** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getOptions()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setOptions( $Options)
	
		
		:Parameters:
			* **$Options** (array | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getShippingDuration()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setShippingDuration( $ShippingDuration)
	
		
		:Parameters:
			* **$ShippingDuration** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getStreet()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setStreet( $Street)
	
		
		:Parameters:
			* **$Street** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getAllowSundaySorting()
	
		
		:Returns: bool | null 
	
	

.. rst-class:: public

	.. php:method:: public getDeliveryDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public getPostalCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDate(string|\\DateTimeInterface|null $deliveryDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setPostalCode( $postcode=null)
	
		
		:Parameters:
			* **$postcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setAllowSundaySorting(string|bool|int|null $AllowSundaySorting=null)
	
		
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

