.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Expectation
===========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Expectation


	.. rst-class:: phpdoc-description
	
		| Class Expectation\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($ETAFrom, $ETATo\)<Firstred\\PostNL\\Entity\\Expectation::\_\_construct\(\)>`
* :php:meth:`public setETAFrom\($ETAFrom\)<Firstred\\PostNL\\Entity\\Expectation::setETAFrom\(\)>`
* :php:meth:`public setETATo\($ETATo\)<Firstred\\PostNL\\Entity\\Expectation::setETATo\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static ETAFrom

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static ETATo

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $ETAFrom=null, $ETATo=null)
	
		
		:Parameters:
			* **$ETAFrom** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  
			* **$ETATo** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setETAFrom( $ETAFrom=null)
	
		
		:Parameters:
			* **$ETAFrom** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setETATo( $ETATo=null)
	
		
		:Parameters:
			* **$ETATo** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

