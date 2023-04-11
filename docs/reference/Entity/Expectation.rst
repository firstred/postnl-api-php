.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Expectation
===========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Expectation


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($ETAFrom, $ETATo\)<Firstred\\PostNL\\Entity\\Expectation::\_\_construct\(\)>`
* :php:meth:`public getETAFrom\(\)<Firstred\\PostNL\\Entity\\Expectation::getETAFrom\(\)>`
* :php:meth:`public setETAFrom\($ETAFrom\)<Firstred\\PostNL\\Entity\\Expectation::setETAFrom\(\)>`
* :php:meth:`public getETATo\(\)<Firstred\\PostNL\\Entity\\Expectation::getETATo\(\)>`
* :php:meth:`public setETATo\($ETATo\)<Firstred\\PostNL\\Entity\\Expectation::setETATo\(\)>`


Properties
----------

.. php:attr:: protected static ETAFrom

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static ETATo

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct(\\DateTimeInterface|string|null $ETAFrom=null, \\DateTimeInterface|string|null $ETATo=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getETAFrom()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setETAFrom(\\DateTimeInterface|string|null $ETAFrom=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getETATo()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setETATo(\\DateTimeInterface|string|null $ETATo=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

