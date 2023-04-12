.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TimeframeTimeFrame
==================


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: TimeframeTimeFrame


	.. rst-class:: phpdoc-description
	
		| Class TimeframeTimeFrame\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GetSentDate, $From, $To, $Options, $Sustainability\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::\_\_construct\(\)>`
* :php:meth:`public setDate\($Date\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::setDate\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Date

	:Type: string | null 


.. php:attr:: protected static From

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static To

	:Type: string | null 


.. php:attr:: protected static Sustainability

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $GetSentDate=null, $From=null, $To=null, $Options=null, $Sustainability=null)
	
		
		:Parameters:
			* **$GetSentDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$From** (string | null)  
			* **$To** (string | null)  
			* **$Options** (string[] | null)  
			* **$Sustainability** (:any:`Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setDate( $Date=null)
	
		
		:Parameters:
			* **$Date** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: mixed | :any:`\\stdClass <stdClass>` | null 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Since: 1.2.0 
	
	

