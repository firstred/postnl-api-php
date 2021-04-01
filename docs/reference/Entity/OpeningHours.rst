.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


OpeningHours
============


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: OpeningHours


	.. rst-class:: phpdoc-description
	
		| Class OpeningHours\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	
	:Implements:
		:php:interface:`ArrayAccess` :php:interface:`Iterator` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Monday, $Tuesday, $Wednesday, $Thursday, $Friday, $Saturday, $Sunday\)<Firstred\\PostNL\\Entity\\OpeningHours::\_\_construct\(\)>`
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


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Monday

	:Type: string | null 


.. php:attr:: protected static Tuesday

	:Type: string | null 


.. php:attr:: protected static Wednesday

	:Type: string | null 


.. php:attr:: protected static Thursday

	:Type: string | null 


.. php:attr:: protected static Friday

	:Type: string | null 


.. php:attr:: protected static Saturday

	:Type: string | null 


.. php:attr:: protected static Sunday

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Monday=\'\', $Tuesday=\'\', $Wednesday=\'\', $Thursday=\'\', $Friday=\'\', $Saturday=\'\', $Sunday=\'\')
	
		.. rst-class:: phpdoc-description
		
			| OpeningHours constructor\.
			
		
		
		:Parameters:
			* **$Monday** (string | null)  
			* **$Tuesday** (string | null)  
			* **$Wednesday** (string | null)  
			* **$Thursday** (string | null)  
			* **$Friday** (string | null)  
			* **$Saturday** (string | null)  
			* **$Sunday** (string | null)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		.. rst-class:: phpdoc-description
		
			| Deserialize opening hours
			
		
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\OpeningHours <Firstred\\PostNL\\Entity\\OpeningHours>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public toArray()
	
		
		:Returns: array 
	
	

.. rst-class:: public

	.. php:method:: public offsetExists( $offset)
	
		
		:Parameters:
			* **$offset** (mixed)  

		
		:Returns: bool 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public offsetGet( $offset)
	
		
		:Parameters:
			* **$offset** (mixed)  

		
		:Returns: array 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public offsetSet( $offset, $value)
	
		
		:Parameters:
			* **$offset** (mixed)  
			* **$value** (mixed)  

		
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public offsetUnset( $offset)
	
		
		:Parameters:
			* **$offset** (mixed)  

		
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
	
		
		:Returns: string 
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
	
	

