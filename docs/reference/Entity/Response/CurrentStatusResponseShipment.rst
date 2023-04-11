.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurrentStatusResponseShipment
=============================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CurrentStatusResponseShipment


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Addresses, $Amounts, $Barcode, $Customer, $DeliveryDate, $Dimension, $Expectation, $Groups, $ProductCode, $ProductOptions, $Reference, $Status, $Warnings, $MainBarcode, $ShipmentAmount, $ShipmentCounter, $ProductDescription\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::\_\_construct\(\)>`
* :php:meth:`public getDeliveryDate\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getDeliveryDate\(\)>`
* :php:meth:`public setDeliveryDate\($DeliveryDate\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setDeliveryDate\(\)>`
* :php:meth:`public getAddresses\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getAddresses\(\)>`
* :php:meth:`public setAddresses\($Addresses\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setAddresses\(\)>`
* :php:meth:`public getAmounts\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getAmounts\(\)>`
* :php:meth:`public setAmounts\($Amounts\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setAmounts\(\)>`
* :php:meth:`public getBarcode\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getBarcode\(\)>`
* :php:meth:`public setBarcode\($Barcode\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setBarcode\(\)>`
* :php:meth:`public getCustomer\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getCustomer\(\)>`
* :php:meth:`public setCustomer\($Customer\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setCustomer\(\)>`
* :php:meth:`public getDimension\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getDimension\(\)>`
* :php:meth:`public setDimension\($Dimension\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setDimension\(\)>`
* :php:meth:`public getExpectation\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getExpectation\(\)>`
* :php:meth:`public setExpectation\($Expectation\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setExpectation\(\)>`
* :php:meth:`public getGroups\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getGroups\(\)>`
* :php:meth:`public setGroups\($Groups\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setGroups\(\)>`
* :php:meth:`public getMainBarcode\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getMainBarcode\(\)>`
* :php:meth:`public setMainBarcode\($MainBarcode\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setMainBarcode\(\)>`
* :php:meth:`public getProductCode\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getProductCode\(\)>`
* :php:meth:`public setProductCode\($ProductCode\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setProductCode\(\)>`
* :php:meth:`public getProductDescription\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getProductDescription\(\)>`
* :php:meth:`public setProductDescription\($ProductDescription\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setProductDescription\(\)>`
* :php:meth:`public getProductOptions\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getProductOptions\(\)>`
* :php:meth:`public setProductOptions\($ProductOptions\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setProductOptions\(\)>`
* :php:meth:`public getReference\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getReference\(\)>`
* :php:meth:`public setReference\($Reference\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setReference\(\)>`
* :php:meth:`public getShipmentAmount\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getShipmentAmount\(\)>`
* :php:meth:`public setShipmentAmount\($ShipmentAmount\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setShipmentAmount\(\)>`
* :php:meth:`public getShipmentCounter\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getShipmentCounter\(\)>`
* :php:meth:`public setShipmentCounter\($ShipmentCounter\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setShipmentCounter\(\)>`
* :php:meth:`public getStatus\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getStatus\(\)>`
* :php:meth:`public setStatus\($Status\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setStatus\(\)>`
* :php:meth:`public getWarnings\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::getWarnings\(\)>`
* :php:meth:`public setWarnings\($Warnings\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::setWarnings\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: protected static Addresses

	:Type: :any:`\\Firstred\\PostNL\\Entity\\StatusAddress\[\] <Firstred\\PostNL\\Entity\\StatusAddress>` | null 


.. php:attr:: protected static Amounts

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Amount\[\] <Firstred\\PostNL\\Entity\\Amount>` | null 


.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static DeliveryDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Dimension

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Dimension <Firstred\\PostNL\\Entity\\Dimension>` | null 


.. php:attr:: protected static Expectation

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Expectation <Firstred\\PostNL\\Entity\\Expectation>` | null 


.. php:attr:: protected static Groups

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Group\[\] <Firstred\\PostNL\\Entity\\Group>` | null 


.. php:attr:: protected static MainBarcode

	:Type: string | null 


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

	.. php:method:: public __construct( $Addresses=null, $Amounts=null, $Barcode=null, $Customer=null, \\DateTimeInterface|string|null $DeliveryDate=null, $Dimension=null, $Expectation=null, $Groups=null, $ProductCode=null, $ProductOptions=null, $Reference=null, $Status=null, $Warnings=null, $MainBarcode=null, $ShipmentAmount=null, $ShipmentCounter=null, $ProductDescription=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getDeliveryDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDate(string|\\DateTimeInterface|null $DeliveryDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getAddresses()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\StatusAddress\[\] <Firstred\\PostNL\\Entity\\StatusAddress>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setAddresses( $Addresses)
	
		
		:Parameters:
			* **$Addresses** (:any:`Firstred\\PostNL\\Entity\\StatusAddress\[\] <Firstred\\PostNL\\Entity\\StatusAddress>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getAmounts()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Amount\[\] <Firstred\\PostNL\\Entity\\Amount>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setAmounts( $Amounts)
	
		
		:Parameters:
			* **$Amounts** (:any:`Firstred\\PostNL\\Entity\\Amount\[\] <Firstred\\PostNL\\Entity\\Amount>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getBarcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setBarcode( $Barcode)
	
		
		:Parameters:
			* **$Barcode** (string | null)  

		
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

	.. php:method:: public getDimension()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Dimension <Firstred\\PostNL\\Entity\\Dimension>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setDimension( $Dimension)
	
		
		:Parameters:
			* **$Dimension** (:any:`Firstred\\PostNL\\Entity\\Dimension <Firstred\\PostNL\\Entity\\Dimension>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getExpectation()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Expectation <Firstred\\PostNL\\Entity\\Expectation>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setExpectation( $Expectation)
	
		
		:Parameters:
			* **$Expectation** (:any:`Firstred\\PostNL\\Entity\\Expectation <Firstred\\PostNL\\Entity\\Expectation>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getGroups()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Group\[\] <Firstred\\PostNL\\Entity\\Group>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setGroups( $Groups)
	
		
		:Parameters:
			* **$Groups** (:any:`Firstred\\PostNL\\Entity\\Group\[\] <Firstred\\PostNL\\Entity\\Group>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMainBarcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setMainBarcode( $MainBarcode)
	
		
		:Parameters:
			* **$MainBarcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getProductCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setProductCode( $ProductCode)
	
		
		:Parameters:
			* **$ProductCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getProductDescription()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setProductDescription( $ProductDescription)
	
		
		:Parameters:
			* **$ProductDescription** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getProductOptions()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\ProductOption\[\] <Firstred\\PostNL\\Entity\\ProductOption>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setProductOptions( $ProductOptions)
	
		
		:Parameters:
			* **$ProductOptions** (:any:`Firstred\\PostNL\\Entity\\ProductOption\[\] <Firstred\\PostNL\\Entity\\ProductOption>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getReference()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setReference( $Reference)
	
		
		:Parameters:
			* **$Reference** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getShipmentAmount()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setShipmentAmount( $ShipmentAmount)
	
		
		:Parameters:
			* **$ShipmentAmount** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getShipmentCounter()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setShipmentCounter( $ShipmentCounter)
	
		
		:Parameters:
			* **$ShipmentCounter** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getStatus()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setStatus( $Status)
	
		
		:Parameters:
			* **$Status** (:any:`Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getWarnings()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setWarnings( $Warnings)
	
		
		:Parameters:
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 1.2.0 
	
	

