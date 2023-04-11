.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetUpdatedShipments
===================


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetUpdatedShipments


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Cache\\CacheableRequestEntityInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Customer, $DateTimeFrom, $DateTimeTo\)<Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments::\_\_construct\(\)>`
* :php:meth:`public getCustomer\(\)<Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments::getCustomer\(\)>`
* :php:meth:`public setCustomer\($Customer\)<Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments::setCustomer\(\)>`
* :php:meth:`public getDateTimeFrom\(\)<Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments::getDateTimeFrom\(\)>`
* :php:meth:`public setDateTimeFrom\($DateTimeFrom\)<Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments::setDateTimeFrom\(\)>`
* :php:meth:`public getDateTimeTo\(\)<Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments::getDateTimeTo\(\)>`
* :php:meth:`public setDateTimeTo\($DateTimeTo\)<Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments::setDateTimeTo\(\)>`
* :php:meth:`public getCacheKey\(\)<Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments::getCacheKey\(\)>`


Properties
----------

.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static DateTimeFrom

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static DateTimeTo

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Customer=null, $DateTimeFrom=null, $DateTimeTo=null)
	
		
		:Parameters:
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$DateTimeFrom** (:any:`DateTimeInterface <DateTimeInterface>` | null)  
			* **$DateTimeTo** (:any:`DateTimeInterface <DateTimeInterface>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getCustomer()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setCustomer( $Customer)
	
		
		:Parameters:
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDateTimeFrom()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setDateTimeFrom( $DateTimeFrom)
	
		
		:Parameters:
			* **$DateTimeFrom** (:any:`DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDateTimeTo()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setDateTimeTo( $DateTimeTo)
	
		
		:Parameters:
			* **$DateTimeTo** (:any:`DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCacheKey()
	
		.. rst-class:: phpdoc-description
		
			| This method returns a unique cache key for every unique cacheable request as defined by PSR\-6\.
			
		
		
		:See: :any:`https://www\.php\-fig\.org/psr/psr\-6/\#definitions <https://www\.php\-fig\.org/psr/psr\-6/\#definitions>` 
		:Returns: string 
	
	

