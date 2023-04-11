.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Timeframe
=========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Timeframe


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($City, $CountryCode, $Date, $EndDate, $HouseNr, $HouseNrExt, $Options, $PostalCode, $Street, $SundaySorting, $Interval, $Range, $Timeframes, $StartDate\)<Firstred\\PostNL\\Entity\\Timeframe::\_\_construct\(\)>`
* :php:meth:`public setDate\($Date\)<Firstred\\PostNL\\Entity\\Timeframe::setDate\(\)>`
* :php:meth:`public setStartDate\($StartDate\)<Firstred\\PostNL\\Entity\\Timeframe::setStartDate\(\)>`
* :php:meth:`public setEndDate\($EndDate\)<Firstred\\PostNL\\Entity\\Timeframe::setEndDate\(\)>`
* :php:meth:`public setPostalCode\($PostalCode\)<Firstred\\PostNL\\Entity\\Timeframe::setPostalCode\(\)>`
* :php:meth:`public getCity\(\)<Firstred\\PostNL\\Entity\\Timeframe::getCity\(\)>`
* :php:meth:`public setCity\($City\)<Firstred\\PostNL\\Entity\\Timeframe::setCity\(\)>`
* :php:meth:`public getCountryCode\(\)<Firstred\\PostNL\\Entity\\Timeframe::getCountryCode\(\)>`
* :php:meth:`public setCountryCode\($CountryCode\)<Firstred\\PostNL\\Entity\\Timeframe::setCountryCode\(\)>`
* :php:meth:`public getHouseNr\(\)<Firstred\\PostNL\\Entity\\Timeframe::getHouseNr\(\)>`
* :php:meth:`public setHouseNr\($HouseNr\)<Firstred\\PostNL\\Entity\\Timeframe::setHouseNr\(\)>`
* :php:meth:`public getHouseNrExt\(\)<Firstred\\PostNL\\Entity\\Timeframe::getHouseNrExt\(\)>`
* :php:meth:`public setHouseNrExt\($HouseNrExt\)<Firstred\\PostNL\\Entity\\Timeframe::setHouseNrExt\(\)>`
* :php:meth:`public getOptions\(\)<Firstred\\PostNL\\Entity\\Timeframe::getOptions\(\)>`
* :php:meth:`public setOptions\($Options\)<Firstred\\PostNL\\Entity\\Timeframe::setOptions\(\)>`
* :php:meth:`public getStreet\(\)<Firstred\\PostNL\\Entity\\Timeframe::getStreet\(\)>`
* :php:meth:`public setStreet\($Street\)<Firstred\\PostNL\\Entity\\Timeframe::setStreet\(\)>`
* :php:meth:`public getInterval\(\)<Firstred\\PostNL\\Entity\\Timeframe::getInterval\(\)>`
* :php:meth:`public setInterval\($Interval\)<Firstred\\PostNL\\Entity\\Timeframe::setInterval\(\)>`
* :php:meth:`public getTimeframeRange\(\)<Firstred\\PostNL\\Entity\\Timeframe::getTimeframeRange\(\)>`
* :php:meth:`public setTimeframeRange\($TimeframeRange\)<Firstred\\PostNL\\Entity\\Timeframe::setTimeframeRange\(\)>`
* :php:meth:`public getTimeframes\(\)<Firstred\\PostNL\\Entity\\Timeframe::getTimeframes\(\)>`
* :php:meth:`public setTimeframes\($Timeframes\)<Firstred\\PostNL\\Entity\\Timeframe::setTimeframes\(\)>`
* :php:meth:`public getDate\(\)<Firstred\\PostNL\\Entity\\Timeframe::getDate\(\)>`
* :php:meth:`public getEndDate\(\)<Firstred\\PostNL\\Entity\\Timeframe::getEndDate\(\)>`
* :php:meth:`public getPostalCode\(\)<Firstred\\PostNL\\Entity\\Timeframe::getPostalCode\(\)>`
* :php:meth:`public getStartDate\(\)<Firstred\\PostNL\\Entity\\Timeframe::getStartDate\(\)>`
* :php:meth:`public getSundaySorting\(\)<Firstred\\PostNL\\Entity\\Timeframe::getSundaySorting\(\)>`
* :php:meth:`public setSundaySorting\($SundaySorting\)<Firstred\\PostNL\\Entity\\Timeframe::setSundaySorting\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Timeframe::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: protected static City

	:Type: string | null 


.. php:attr:: protected static CountryCode

	:Type: string | null 


.. php:attr:: protected static Date

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static EndDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static HouseNr

	:Type: string | null 


.. php:attr:: protected static HouseNrExt

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static PostalCode

	:Type: string | null 


.. php:attr:: protected static StartDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Street

	:Type: string | null 


.. php:attr:: protected static SundaySorting

	:Type: bool | null 


.. php:attr:: protected static Interval

	:Type: string | null 


.. php:attr:: protected static TimeframeRange

	:Type: string | null 


.. php:attr:: protected static Timeframes

	:Type: :any:`\\Firstred\\PostNL\\Entity\\TimeframeTimeFrame\[\] <Firstred\\PostNL\\Entity\\TimeframeTimeFrame>` | :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $City=null, $CountryCode=null, string|\\DateTimeInterface|null $Date=null, string|\\DateTimeInterface|null $EndDate=null, $HouseNr=null, $HouseNrExt=null, $Options=\[\], $PostalCode=null, $Street=null, $SundaySorting=\'false\', $Interval=null, $Range=null, $Timeframes=null, string|\\DateTimeInterface|null $StartDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setDate(string|\\DateTimeInterface|null $Date=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setStartDate(string|\\DateTimeInterface|null $StartDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setEndDate(string|\\DateTimeInterface|null $EndDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setPostalCode( $PostalCode=null)
	
		
		:Parameters:
			* **$PostalCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCity()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCity( $City)
	
		
		:Parameters:
			* **$City** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe <Firstred\\PostNL\\Entity\\Timeframe>` 
	
	

.. rst-class:: public

	.. php:method:: public getCountryCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCountryCode( $CountryCode)
	
		
		:Parameters:
			* **$CountryCode** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe <Firstred\\PostNL\\Entity\\Timeframe>` 
	
	

.. rst-class:: public

	.. php:method:: public getHouseNr()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNr( $HouseNr)
	
		
		:Parameters:
			* **$HouseNr** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe <Firstred\\PostNL\\Entity\\Timeframe>` 
	
	

.. rst-class:: public

	.. php:method:: public getHouseNrExt()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setHouseNrExt( $HouseNrExt)
	
		
		:Parameters:
			* **$HouseNrExt** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe <Firstred\\PostNL\\Entity\\Timeframe>` 
	
	

.. rst-class:: public

	.. php:method:: public getOptions()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setOptions( $Options)
	
		
		:Parameters:
			* **$Options** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe <Firstred\\PostNL\\Entity\\Timeframe>` 
	
	

.. rst-class:: public

	.. php:method:: public getStreet()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setStreet( $Street)
	
		
		:Parameters:
			* **$Street** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getInterval()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setInterval( $Interval)
	
		
		:Parameters:
			* **$Interval** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframeRange()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setTimeframeRange( $TimeframeRange)
	
		
		:Parameters:
			* **$TimeframeRange** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframes()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\TimeframeTimeFrame\[\] <Firstred\\PostNL\\Entity\\TimeframeTimeFrame>` | :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setTimeframes( $Timeframes)
	
		
		:Parameters:
			* **$Timeframes** (:any:`Firstred\\PostNL\\Entity\\TimeframeTimeFrame\[\] <Firstred\\PostNL\\Entity\\TimeframeTimeFrame>` | :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public getEndDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public getPostalCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public getStartDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public getSundaySorting()
	
		
		:Returns: bool | null 
	
	

.. rst-class:: public

	.. php:method:: public setSundaySorting(string|bool|int|null $SundaySorting=null)
	
		
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		
		:Returns: array 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ServiceNotSetException <Firstred\\PostNL\\Exception\\ServiceNotSetException>` 
	
	

