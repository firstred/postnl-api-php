.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


OpeningHours
============


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: OpeningHours


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	
	:Implements:
		:php:interface:`ArrayAccess` :php:interface:`Iterator` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Monday, $Tuesday, $Wednesday, $Thursday, $Friday, $Saturday, $Sunday\)<Firstred\\PostNL\\Entity\\OpeningHours::\_\_construct\(\)>`
* :php:meth:`public getMonday\(\)<Firstred\\PostNL\\Entity\\OpeningHours::getMonday\(\)>`
* :php:meth:`public setMonday\($Monday\)<Firstred\\PostNL\\Entity\\OpeningHours::setMonday\(\)>`
* :php:meth:`public getTuesday\(\)<Firstred\\PostNL\\Entity\\OpeningHours::getTuesday\(\)>`
* :php:meth:`public setTuesday\($Tuesday\)<Firstred\\PostNL\\Entity\\OpeningHours::setTuesday\(\)>`
* :php:meth:`public getWednesday\(\)<Firstred\\PostNL\\Entity\\OpeningHours::getWednesday\(\)>`
* :php:meth:`public setWednesday\($Wednesday\)<Firstred\\PostNL\\Entity\\OpeningHours::setWednesday\(\)>`
* :php:meth:`public getThursday\(\)<Firstred\\PostNL\\Entity\\OpeningHours::getThursday\(\)>`
* :php:meth:`public setThursday\($Thursday\)<Firstred\\PostNL\\Entity\\OpeningHours::setThursday\(\)>`
* :php:meth:`public getFriday\(\)<Firstred\\PostNL\\Entity\\OpeningHours::getFriday\(\)>`
* :php:meth:`public setFriday\($Friday\)<Firstred\\PostNL\\Entity\\OpeningHours::setFriday\(\)>`
* :php:meth:`public getSaturday\(\)<Firstred\\PostNL\\Entity\\OpeningHours::getSaturday\(\)>`
* :php:meth:`public setSaturday\($Saturday\)<Firstred\\PostNL\\Entity\\OpeningHours::setSaturday\(\)>`
* :php:meth:`public getSunday\(\)<Firstred\\PostNL\\Entity\\OpeningHours::getSunday\(\)>`
* :php:meth:`public setSunday\($Sunday\)<Firstred\\PostNL\\Entity\\OpeningHours::setSunday\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\OpeningHours::jsonDeserialize\(\)>`
* :php:meth:`public toArray\(\)<Firstred\\PostNL\\Entity\\OpeningHours::toArray\(\)>`
* :php:meth:`public offsetExists\($offset\)<Firstred\\PostNL\\Entity\\OpeningHours::offsetExists\(\)>`
* :php:meth:`public offsetGet\($offset\)<Firstred\\PostNL\\Entity\\OpeningHours::offsetGet\(\)>`
* :php:meth:`public offsetSet\($offset, $value\)<Firstred\\PostNL\\Entity\\OpeningHours::offsetSet\(\)>`
* :php:meth:`public offsetUnset\($offset\)<Firstred\\PostNL\\Entity\\OpeningHours::offsetUnset\(\)>`
* :php:meth:`public current\(\)<Firstred\\PostNL\\Entity\\OpeningHours::current\(\)>`
* :php:meth:`public next\(\)<Firstred\\PostNL\\Entity\\OpeningHours::next\(\)>`
* :php:meth:`public key\(\)<Firstred\\PostNL\\Entity\\OpeningHours::key\(\)>`
* :php:meth:`public valid\(\)<Firstred\\PostNL\\Entity\\OpeningHours::valid\(\)>`
* :php:meth:`public rewind\(\)<Firstred\\PostNL\\Entity\\OpeningHours::rewind\(\)>`
* :php:meth:`private static findCurrentDayString\($currentDay\)<Firstred\\PostNL\\Entity\\OpeningHours::findCurrentDayString\(\)>`


Properties
----------

.. php:attr:: private static currentDay



.. php:attr:: protected static Monday

	:Type: string[] | null 


.. php:attr:: protected static Tuesday

	:Type: string[] | null 


.. php:attr:: protected static Wednesday

	:Type: string[] | null 


.. php:attr:: protected static Thursday

	:Type: string[] | null 


.. php:attr:: protected static Friday

	:Type: string[] | null 


.. php:attr:: protected static Saturday

	:Type: string[] | null 


.. php:attr:: protected static Sunday

	:Type: string[] | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct(array|null $Monday=null, array|null $Tuesday=null, array|null $Wednesday=null, array|null $Thursday=null, array|null $Friday=null, array|null $Saturday=null, array|null $Sunday=null)
	
		
		:Parameters:
			* **$Monday** (array | null)  
			* **$Tuesday** (array | null)  
			* **$Wednesday** (array | null)  
			* **$Thursday** (array | null)  
			* **$Friday** (array | null)  
			* **$Saturday** (array | null)  
			* **$Sunday** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getMonday()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setMonday(array|null $Monday)
	
		
		:Parameters:
			* **$Monday** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
	
	

.. rst-class:: public

	.. php:method:: public getTuesday()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setTuesday(array|null $Tuesday)
	
		
		:Parameters:
			* **$Tuesday** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
	
	

.. rst-class:: public

	.. php:method:: public getWednesday()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setWednesday(array|null $Wednesday)
	
		
		:Parameters:
			* **$Wednesday** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
	
	

.. rst-class:: public

	.. php:method:: public getThursday()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setThursday(array|null $Thursday)
	
		
		:Parameters:
			* **$Thursday** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
	
	

.. rst-class:: public

	.. php:method:: public getFriday()
	
		
		:Returns: array | string | null 
	
	

.. rst-class:: public

	.. php:method:: public setFriday(array|null $Friday)
	
		
		:Parameters:
			* **$Friday** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
	
	

.. rst-class:: public

	.. php:method:: public getSaturday()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setSaturday(array|null $Saturday)
	
		
		:Parameters:
			* **$Saturday** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
	
	

.. rst-class:: public

	.. php:method:: public getSunday()
	
		
		:Returns: array | null 
	
	

.. rst-class:: public

	.. php:method:: public setSunday(array|null $Sunday)
	
		
		:Parameters:
			* **$Sunday** (array | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public toArray()
	
		
		:Returns: :any:`array\{Monday: string\[\], Tuesday: string\[\], Wednesday: string\[\], Thursday: string\[\], Friday: string\[\], Saturday: string\[\], Sunday: string\[\]\} <array\{Monday: string, Tuesday: string, Wednesday: string, Thursday: string, Friday: string, Saturday: string, Sunday: string\}>` 
	
	

.. rst-class:: public

	.. php:method:: public offsetExists( $offset)
	
		
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public offsetGet( $offset)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public offsetSet( $offset, $value)
	
		
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public offsetUnset( $offset)
	
		
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public current()
	
		
		:Returns: mixed 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public next()
	
		
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public key()
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public valid()
	
		
		:Returns: bool 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public rewind()
	
		
		:Since: 1.2.0 
	
	

.. rst-class:: private static

	.. php:method:: private static findCurrentDayString(string|int $currentDay)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

