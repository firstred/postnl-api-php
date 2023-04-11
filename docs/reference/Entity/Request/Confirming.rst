.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Confirming
==========


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: Confirming


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Customer, $Message\)<Firstred\\PostNL\\Entity\\Request\\Confirming::\_\_construct\(\)>`
* :php:meth:`public getCustomer\(\)<Firstred\\PostNL\\Entity\\Request\\Confirming::getCustomer\(\)>`
* :php:meth:`public setCustomer\($Customer\)<Firstred\\PostNL\\Entity\\Request\\Confirming::setCustomer\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\Confirming::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\Confirming::setMessage\(\)>`
* :php:meth:`public getShipments\(\)<Firstred\\PostNL\\Entity\\Request\\Confirming::getShipments\(\)>`
* :php:meth:`public setShipments\($Shipments\)<Firstred\\PostNL\\Entity\\Request\\Confirming::setShipments\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Request\\Confirming::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Customer=null, $Message=null)
	
		
		:Parameters:
			* **$Shipments** (:any:`Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getCustomer()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setCustomer( $Customer)
	
		
		:Parameters:
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getShipments()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setShipments( $Shipments)
	
		
		:Parameters:
			* **$Shipments** (:any:`Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		
		:Returns: array 
	
	

