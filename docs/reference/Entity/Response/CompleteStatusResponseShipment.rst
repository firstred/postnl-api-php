.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CompleteStatusResponseShipment
==============================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CompleteStatusResponseShipment


	.. rst-class:: phpdoc-description
	
		| Class CompleteStatusResponseShipment\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Addresses, $Amounts, $Barcode, $Customer, $DeliveryDate, $Dimension, $Events, $Expectation, $Groups, $OldStatuses, $ProductCode, $ProductOptions, $Reference, $Status, $Warnings, $MainBarcode, $ShipmentAmount, $ShipmentCounter, $ProductDescription\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment::\_\_construct\(\)>`
* :php:meth:`public setDeliveryDate\($deliveryDate\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment::setDeliveryDate\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment::jsonDeserialize\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Addresses

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\StatusAddress\[\] <Firstred\\PostNL\\Entity\\Response\\StatusAddress>` | null 


.. php:attr:: protected static Amounts

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Amount\[\] <Firstred\\PostNL\\Entity\\Amount>` | null 


.. php:attr:: protected static Barcode

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Barcode <Firstred\\PostNL\\Entity\\Barcode>` | null 


.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static DeliveryDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Dimension

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Dimension <Firstred\\PostNL\\Entity\\Dimension>` | null Dimension


.. php:attr:: protected static Events

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent>` | null 


.. php:attr:: protected static Expectation

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Expectation <Firstred\\PostNL\\Entity\\Expectation>` | null 


.. php:attr:: protected static Groups

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Group\[\] <Firstred\\PostNL\\Entity\\Group>` | null 


.. php:attr:: protected static MainBarcode

	:Type: string | null 


.. php:attr:: protected static OldStatuses

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus>` | null 


.. php:attr:: protected static ProductCode

	:Type: string | null 


.. php:attr:: protected static ProductDescription

	:Type: string | null 


.. php:attr:: protected static ProductOptions

	:Type: :any:`\\Firstred\\PostNL\\Entity\\ProductOption\[\] <Firstred\\PostNL\\Entity\\ProductOption>` | null 


.. php:attr:: protected static Reference

	:Type: string | null 


.. php:attr:: protected static ShipmentAmount

	:Type: string | null 


.. php:attr:: protected static ShipmentCounter

	:Type: string | null 


.. php:attr:: protected static Status

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Addresses=null, $Amounts=null, $Barcode=null, $Customer=null, $DeliveryDate=null, $Dimension=null, $Events=null, $Expectation=null, $Groups=null, $OldStatuses=null, $ProductCode=null, $ProductOptions=null, $Reference=null, $Status=null, $Warnings=null, $MainBarcode=null, $ShipmentAmount=null, $ShipmentCounter=null, $ProductDescription=null)
	
		.. rst-class:: phpdoc-description
		
			| CompleteStatusResponseShipment constructor\.
			
		
		
		:Parameters:
			* **$Addresses** (:any:`Firstred\\PostNL\\Entity\\Response\\StatusAddress\[\] <Firstred\\PostNL\\Entity\\Response\\StatusAddress>` | null)  
			* **$Amounts** (:any:`Firstred\\PostNL\\Entity\\Amount\[\] <Firstred\\PostNL\\Entity\\Amount>` | null)  
			* **$Barcode** (string | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$DeliveryDate** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  
			* **$Dimension** (:any:`Firstred\\PostNL\\Entity\\Dimension <Firstred\\PostNL\\Entity\\Dimension>` | null)  
			* **$Events** (:any:`Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent>` | null)  
			* **$Expectation** (:any:`Firstred\\PostNL\\Entity\\Expectation <Firstred\\PostNL\\Entity\\Expectation>` | null)  
			* **$Groups** (:any:`Firstred\\PostNL\\Entity\\Group\[\] <Firstred\\PostNL\\Entity\\Group>` | null)  
			* **$OldStatuses** (:any:`Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus>` | null)  
			* **$ProductCode** (string | null)  
			* **$ProductOptions** (:any:`Firstred\\PostNL\\Entity\\ProductOption\[\] <Firstred\\PostNL\\Entity\\ProductOption>` | null)  
			* **$Reference** (string | null)  
			* **$Status** (:any:`Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` | null)  
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null)  
			* **$MainBarcode** (string | null)  
			* **$ShipmentAmount** (string | null)  
			* **$ShipmentCounter** (string | null)  
			* **$ProductDescription** (string | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDate( $deliveryDate=null)
	
		
		:Parameters:
			* **$deliveryDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: mixed | :any:`\\stdClass <stdClass>` | null 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

