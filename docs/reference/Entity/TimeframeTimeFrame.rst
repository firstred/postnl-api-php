.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TimeframeTimeFrame
==================


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: TimeframeTimeFrame


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GetSentDate, $From, $To, $Options, $Sustainability\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::\_\_construct\(\)>`
* :php:meth:`public getDate\(\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::getDate\(\)>`
* :php:meth:`public setDate\($Date\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::setDate\(\)>`
* :php:meth:`public getFrom\(\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::getFrom\(\)>`
* :php:meth:`public setFrom\($From\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::setFrom\(\)>`
* :php:meth:`public getTo\(\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::getTo\(\)>`
* :php:meth:`public setTo\($To\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::setTo\(\)>`
* :php:meth:`public getOptions\(\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::getOptions\(\)>`
* :php:meth:`public setOptions\($Options\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::setOptions\(\)>`
* :php:meth:`public getSustainability\(\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::getSustainability\(\)>`
* :php:meth:`public setSustainability\($Sustainability\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::setSustainability\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\TimeframeTimeFrame::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: protected static Date

	:Type: string | null 


.. php:attr:: protected static From

	:Type: string | null 


.. php:attr:: protected static To

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static Sustainability

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $GetSentDate=null, $From=null, $To=null, $Options=null, $Sustainability=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getDate()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDate(string|\\DateTimeInterface|null $Date=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getFrom()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setFrom( $From)
	
		
		:Parameters:
			* **$From** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getTo()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setTo( $To)
	
		
		:Parameters:
			* **$To** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getOptions()
	
		
		:Returns: string[] | null 
	
	

.. rst-class:: public

	.. php:method:: public setOptions( $Options)
	
		
		:Parameters:
			* **$Options** (string[] | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getSustainability()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null 
		:Since: 1.4.2 
	
	

.. rst-class:: public

	.. php:method:: public setSustainability( $Sustainability)
	
		
		:Parameters:
			* **$Sustainability** (:any:`Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null)  

		
		:Returns: static 
		:Since: 1.4.2 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\TimeframeTimeFrame <Firstred\\PostNL\\Entity\\TimeframeTimeFrame>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 1.2.0 
	
	

