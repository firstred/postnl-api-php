.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ReasonNoTimeframe
=================


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: ReasonNoTimeframe


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Code, $Date, $Description, $Options, $From, $To, $Sustainability\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::\_\_construct\(\)>`
* :php:meth:`public getCode\(\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::getCode\(\)>`
* :php:meth:`public setCode\($Code\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::setCode\(\)>`
* :php:meth:`public getDescription\(\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::getDescription\(\)>`
* :php:meth:`public setDescription\($Description\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::setDescription\(\)>`
* :php:meth:`public getOptions\(\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::getOptions\(\)>`
* :php:meth:`public setOptions\($Options\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::setOptions\(\)>`
* :php:meth:`public getFrom\(\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::getFrom\(\)>`
* :php:meth:`public setFrom\($From\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::setFrom\(\)>`
* :php:meth:`public getTo\(\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::getTo\(\)>`
* :php:meth:`public getDate\(\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::getDate\(\)>`
* :php:meth:`public setTo\($To\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::setTo\(\)>`
* :php:meth:`public setDate\($date\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::setDate\(\)>`
* :php:meth:`public getSustainability\(\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::getSustainability\(\)>`
* :php:meth:`public setSustainability\($Sustainability\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::setSustainability\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\ReasonNoTimeframe::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: protected static Code

	:Type: string | null 


.. php:attr:: protected static Date

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Description

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


.. php:attr:: protected static From

	:Type: string | null 


.. php:attr:: protected static To

	:Type: string | null 


.. php:attr:: protected static Sustainability

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Sustainability <Firstred\\PostNL\\Entity\\Sustainability>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct(int|string|null $Code=null, $Date=null, $Description=null, $Options=null, $From=null, $To=null, $Sustainability=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCode(string|int|null $Code)
	
		
		:Parameters:
			* **$Code** (string | int | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDescription()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDescription( $Description)
	
		
		:Parameters:
			* **$Description** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getOptions()
	
		
		:Returns: string[] | null 
	
	

.. rst-class:: public

	.. php:method:: public setOptions( $Options)
	
		
		:Parameters:
			* **$Options** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\ReasonNoTimeframe <Firstred\\PostNL\\Entity\\ReasonNoTimeframe>` 
	
	

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

	.. php:method:: public getDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setTo( $To)
	
		
		:Parameters:
			* **$To** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setDate(string|\\DateTimeInterface|null $date=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

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

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\ReasonNoTimeframe <Firstred\\PostNL\\Entity\\ReasonNoTimeframe>` 
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
	
	

