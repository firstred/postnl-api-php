.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurrentStatus
=============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: CurrentStatus


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Cache\\CacheableRequestEntityInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipment, $Customer, $Message\)<Firstred\\PostNL\\Entity\\Request\\CurrentStatus::\_\_construct\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\CurrentStatus::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\CurrentStatus::setMessage\(\)>`
* :php:meth:`public getCustomer\(\)<Firstred\\PostNL\\Entity\\Request\\CurrentStatus::getCustomer\(\)>`
* :php:meth:`public setCustomer\($Customer\)<Firstred\\PostNL\\Entity\\Request\\CurrentStatus::setCustomer\(\)>`
* :php:meth:`public getShipment\(\)<Firstred\\PostNL\\Entity\\Request\\CurrentStatus::getShipment\(\)>`
* :php:meth:`public setShipment\($Shipment\)<Firstred\\PostNL\\Entity\\Request\\CurrentStatus::setShipment\(\)>`
* :php:meth:`public getCacheKey\(\)<Firstred\\PostNL\\Entity\\Request\\CurrentStatus::getCacheKey\(\)>`


Properties
----------

.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Shipment

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipment=null, $Customer=null, $Message=null)
	
		
		:Parameters:
			* **$Shipment** (:any:`Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>` | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCustomer()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setCustomer( $Customer)
	
		
		:Parameters:
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getShipment()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setShipment( $Shipment)
	
		
		:Parameters:
			* **$Shipment** (:any:`Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCacheKey()
	
		.. rst-class:: phpdoc-description
		
			| This method returns a unique cache key for every unique cacheable request as defined by PSR\-6\.
			
		
		
		:See: :any:`https://www\.php\-fig\.org/psr/psr\-6/\#definitions <https://www\.php\-fig\.org/psr/psr\-6/\#definitions>` 
		:Returns: string 
	
	

