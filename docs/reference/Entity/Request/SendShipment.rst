.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


SendShipment
============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: SendShipment


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Message, $Customer\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::\_\_construct\(\)>`
* :php:meth:`public getCustomer\(\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::getCustomer\(\)>`
* :php:meth:`public setCustomer\($Customer\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::setCustomer\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::setMessage\(\)>`
* :php:meth:`public getShipments\(\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::getShipments\(\)>`
* :php:meth:`public setShipments\($Shipments\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::setShipments\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Request\\SendShipment::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null 


.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Message=null, $Customer=null)
	
		
		:Parameters:
			* **$Shipments** (array | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  

		
	
	

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
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null)  

		
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
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ServiceNotSetException <Firstred\\PostNL\\Exception\\ServiceNotSetException>` 
	
	

