.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Timeframe
=========


.. php:namespace:: ThirtyBees\PostNL\Entity

.. php:class:: Timeframe


	.. rst-class:: phpdoc-description
	
		| Class Timeframe
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static City

	:Type: string | null 


.. php:attr:: protected static CountryCode

	:Type: string | null 


.. php:attr:: protected static Date

	:Type: string | null 


.. php:attr:: protected static EndDate

	:Type: string | null 


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

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame\[\] <ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame>` | :any:`\\ThirtyBees\\PostNL\\Entity\\Timeframe\[\] <ThirtyBees\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $city=null, $countryCode=null, $date=null, $endDate=null, $houseNr=null, $houseNrExt=null, $options=\[\], $postalCode=null, $street=null, $sundaySorting=false, $interval=null, $range=null, $timeframes=null)
	
		.. rst-class:: phpdoc-description
		
			| Timeframe constructor\.
			
		
		
		:Parameters:
			* **$city** (string | null)  
			* **$countryCode** (string | null)  
			* **$date** (string | null)  
			* **$endDate** (string | null)  
			* **$houseNr** (string | null)  
			* **$houseNrExt** (string | null)  
			* **$options** (array | null)  
			* **$postalCode** (string | null)  
			* **$street** (string | null)  
			* **$sundaySorting** (string | null)  
			* **$interval** (string | null)  
			* **$range** (string | null)  
			* **$timeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Timeframe\[\] <ThirtyBees\\PostNL\\Entity\\Timeframe>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setPostalCode( $postcode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the postcode
			
		
		
		:Parameters:
			* **$postcode** (string | null)  

		
		:Returns: $this 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`
			
		
		
		:Returns: array 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
		:Throws: :any:`\\InvalidArgumentException <InvalidArgumentException>` 
	
	

