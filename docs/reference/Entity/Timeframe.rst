.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Timeframe
=========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Timeframe


	.. rst-class:: phpdoc-description
	
		| Class Timeframe\.
		
	
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
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Timeframe::jsonSerialize\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Timeframe::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


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

	:Type: string | null 


.. php:attr:: protected static Street

	:Type: string | null 


.. php:attr:: protected static SundaySorting

	:Type: string | null 


.. php:attr:: protected static Interval

	:Type: string | null 


.. php:attr:: protected static TimeframeRange

	:Type: string | null 


.. php:attr:: protected static Timeframes

	:Type: :any:`\\Firstred\\PostNL\\Entity\\TimeframeTimeFrame\[\] <Firstred\\PostNL\\Entity\\TimeframeTimeFrame>` | :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $City=null, $CountryCode=null, $Date=null, $EndDate=null, $HouseNr=null, $HouseNrExt=null, $Options=\[\], $PostalCode=null, $Street=null, $SundaySorting=\'false\', $Interval=null, $Range=null, $Timeframes=null, $StartDate=null)
	
		.. rst-class:: phpdoc-description
		
			| Timeframe constructor\.
			
		
		
		:Parameters:
			* **$City** (string | null)  
			* **$CountryCode** (string | null)  
			* **$Date** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$EndDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$HouseNr** (string | null)  
			* **$HouseNrExt** (string | null)  
			* **$Options** (array | null)  
			* **$PostalCode** (string | null)  
			* **$Street** (string | null)  
			* **$SundaySorting** (string | null)  
			* **$Interval** (string | null)  
			* **$Range** (string | null)  
			* **$Timeframes** (:any:`Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null)  
			* **$StartDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setDate( $Date=null)
	
		
		:Parameters:
			* **$Date** (null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setStartDate( $StartDate=null)
	
		
		:Parameters:
			* **$StartDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setEndDate( $EndDate=null)
	
		
		:Parameters:
			* **$EndDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setPostalCode( $PostalCode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the postcode\.
			
		
		
		:Parameters:
			* **$PostalCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`\.
			
		
		
		:Returns: array 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
		:Throws: :any:`\\InvalidArgumentException <InvalidArgumentException>` 
	
	

