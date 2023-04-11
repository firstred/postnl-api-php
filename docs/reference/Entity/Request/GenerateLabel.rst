.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GenerateLabel
=============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GenerateLabel


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Message, $Customer, $LabelSignature\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::\_\_construct\(\)>`
* :php:meth:`public getCustomer\(\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::getCustomer\(\)>`
* :php:meth:`public setCustomer\($Customer\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::setCustomer\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::setMessage\(\)>`
* :php:meth:`public getShipments\(\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::getShipments\(\)>`
* :php:meth:`public setShipments\($Shipments\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::setShipments\(\)>`
* :php:meth:`public getLabelSignature\(\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::getLabelSignature\(\)>`
* :php:meth:`public setLabelSignature\($LabelSignature\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::setLabelSignature\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Request\\GenerateLabel::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null 


.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>` | null 


.. php:attr:: protected static LabelSignature

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Message=null, $Customer=null, $LabelSignature=null)
	
		
		:Parameters:
			* **$Shipments** (array | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\LabellingMessage <Firstred\\PostNL\\Entity\\Message\\LabellingMessage>` | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$LabelSignature** (string | null)  

		
	
	

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

	.. php:method:: public getLabelSignature()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setLabelSignature( $LabelSignature)
	
		
		:Parameters:
			* **$LabelSignature** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		
		:Returns: array 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ServiceNotSetException <Firstred\\PostNL\\Exception\\ServiceNotSetException>` 
	
	

