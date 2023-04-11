.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetDeliveryDate
===============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetDeliveryDate


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Cache\\CacheableRequestEntityInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AllowSundaySorting, $City, $CountryCode, $CutOffTimes, $HouseNr, $HouseNrExt, $Options, $OriginCountryCode, $PostalCode, $ShippingDate, $ShippingDuration, $Street, $GetDeliveryDate, $Message\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::\_\_construct\(\)>`
* :php:meth:`public getCity\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getCity\(\)>`
* :php:meth:`public setCity\($City\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setCity\(\)>`
* :php:meth:`public getCountryCode\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getCountryCode\(\)>`
* :php:meth:`public setCountryCode\($CountryCode\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setCountryCode\(\)>`
* :php:meth:`public getCutOffTimes\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getCutOffTimes\(\)>`
* :php:meth:`public setCutOffTimes\($CutOffTimes\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setCutOffTimes\(\)>`
* :php:meth:`public getHouseNr\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getHouseNr\(\)>`
* :php:meth:`public setHouseNr\($HouseNr\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setHouseNr\(\)>`
* :php:meth:`public getHouseNrExt\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getHouseNrExt\(\)>`
* :php:meth:`public setHouseNrExt\($HouseNrExt\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setHouseNrExt\(\)>`
* :php:meth:`public getOptions\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getOptions\(\)>`
* :php:meth:`public setOptions\($Options\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setOptions\(\)>`
* :php:meth:`public getOriginCountryCode\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getOriginCountryCode\(\)>`
* :php:meth:`public setOriginCountryCode\($OriginCountryCode\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setOriginCountryCode\(\)>`
* :php:meth:`public getShippingDuration\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getShippingDuration\(\)>`
* :php:meth:`public setShippingDuration\($ShippingDuration\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setShippingDuration\(\)>`
* :php:meth:`public getStreet\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getStreet\(\)>`
* :php:meth:`public setStreet\($Street\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setStreet\(\)>`
* :php:meth:`public getGetDeliveryDate\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getGetDeliveryDate\(\)>`
* :php:meth:`public setGetDeliveryDate\($GetDeliveryDate\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setGetDeliveryDate\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setMessage\(\)>`
* :php:meth:`public getShippingDate\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getShippingDate\(\)>`
* :php:meth:`public setShippingDate\($shippingDate\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setShippingDate\(\)>`
* :php:meth:`public getPostalCode\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getPostalCode\(\)>`
* :php:meth:`public setPostalCode\($PostalCode\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setPostalCode\(\)>`
* :php:meth:`public getAllowSundaySorting\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getAllowSundaySorting\(\)>`
* :php:meth:`public setAllowSundaySorting\($AllowSundaySorting\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::setAllowSundaySorting\(\)>`
* :php:meth:`public getCacheKey\(\)<Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate::getCacheKey\(\)>`


Properties
----------

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

	:Type: self | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $AllowSundaySorting=null, $City=null, $CountryCode=null, $CutOffTimes=null, $HouseNr=null, $HouseNrExt=null, $Options=null, $OriginCountryCode=null, $PostalCode=null, \\DateTimeInterface|string|null $ShippingDate=null, $ShippingDuration=null, $Street=null, $GetDeliveryDate=null, $Message=null)
	
		
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

	.. php:method:: public getCutOffTimes()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setCutOffTimes( $CutOffTimes)
	
		
		:Parameters:
			* **$CutOffTimes** (array | null)  

		
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
			* **$Options** (string[] | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getOriginCountryCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setOriginCountryCode( $OriginCountryCode)
	
		
		:Parameters:
			* **$OriginCountryCode** (string | null)  

		
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

	.. php:method:: public getGetDeliveryDate()
	
		
		:Returns: static | null 
	
	

.. rst-class:: public

	.. php:method:: public setGetDeliveryDate( $GetDeliveryDate)
	
		
		:Parameters:
			* **$GetDeliveryDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate <Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getShippingDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setShippingDate(\\DateTimeInterface|string|null $shippingDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getPostalCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setPostalCode( $PostalCode=null)
	
		
		:Parameters:
			* **$PostalCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getAllowSundaySorting()
	
		
		:Returns: bool | null 
	
	

.. rst-class:: public

	.. php:method:: public setAllowSundaySorting(bool|int|string|null $AllowSundaySorting=null)
	
		
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getCacheKey()
	
		.. rst-class:: phpdoc-description
		
			| This method returns a unique cache key for every unique cacheable request as defined by PSR\-6\.
			
		
		
		:See: :any:`https://www\.php\-fig\.org/psr/psr\-6/\#definitions <https://www\.php\-fig\.org/psr/psr\-6/\#definitions>` 
		:Returns: string 
	
	

