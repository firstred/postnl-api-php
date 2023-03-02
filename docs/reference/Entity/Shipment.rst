.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Shipment
========


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Shipment


	.. rst-class:: phpdoc-description
	
		| Class Shipment\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Addresses, $Amounts, $Barcode, $Contacts, $Content, $CollectionTimeStampEnd, $CollectionTimeStampStart, $CostCenter, $Customer, $CustomerOrderNumber, $Customs, $DeliveryAddress, $DeliveryDate, $Dimension, $DownPartnerBarcode, $DownPartnerID, $DownPartnerLocation, $Events, $Groups, $IDExpiration, $IDNumber, $IDType, $OldStatuses, $ProductCodeCollect, $ProductCodeDelivery, $ProductOptions, $ReceiverDateOfBirth, $Reference, $ReferenceCollect, $Remark, $ReturnBarcode, $ReturnReference, $StatusCode, $PhaseCode, $DateFrom, $DateTo, $DeliveryTimeStampStart, $DeliveryTimeStampEnd\)<Firstred\\PostNL\\Entity\\Shipment::\_\_construct\(\)>`
* :php:meth:`public setCollectionTimeStampStart\($CollectionTimeStampStart\)<Firstred\\PostNL\\Entity\\Shipment::setCollectionTimeStampStart\(\)>`
* :php:meth:`public setCollectionTimeStampEnd\($CollectionTimeStampEnd\)<Firstred\\PostNL\\Entity\\Shipment::setCollectionTimeStampEnd\(\)>`
* :php:meth:`public setDeliveryTimeStampStart\($DeliveryTimeStampStart\)<Firstred\\PostNL\\Entity\\Shipment::setDeliveryTimeStampStart\(\)>`
* :php:meth:`public setDeliveryTimeStampEnd\($DeliveryTimeStampEnd\)<Firstred\\PostNL\\Entity\\Shipment::setDeliveryTimeStampEnd\(\)>`
* :php:meth:`public setDeliveryDate\($DeliveryDate\)<Firstred\\PostNL\\Entity\\Shipment::setDeliveryDate\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Shipment::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Addresses

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Address\[\] <Firstred\\PostNL\\Entity\\Address>` | null 


.. php:attr:: protected static Amounts

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Amount\[\] <Firstred\\PostNL\\Entity\\Amount>` | null 


.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static CollectionTimeStampEnd

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static CollectionTimeStampStart

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Contacts

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Contact\[\] <Firstred\\PostNL\\Entity\\Contact>` | null 


.. php:attr:: protected static Content

	:Type: string | null 


.. php:attr:: protected static CostCenter

	:Type: string | null 


.. php:attr:: protected static CustomerOrderNumber

	:Type: string | null 


.. php:attr:: protected static Customer

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Customs

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customs <Firstred\\PostNL\\Entity\\Customs>` | null 


.. php:attr:: protected static StatusCode

	:Type: string \|null$StatusCode


.. php:attr:: protected static PhaseCode

	:Type: int | null 


.. php:attr:: protected static DateFrom

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static DateTo

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static DeliveryAddress

	:Type: string | null 


.. php:attr:: protected static DeliveryTimeStampStart

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static DeliveryTimeStampEnd

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static DeliveryDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Dimension

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Dimension <Firstred\\PostNL\\Entity\\Dimension>` | null 


.. php:attr:: protected static DownPartnerBarcode

	:Type: string | null 


.. php:attr:: protected static DownPartnerID

	:Type: string | null 


.. php:attr:: protected static DownPartnerLocation

	:Type: string | null 


.. php:attr:: protected static Events

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Event\[\] <Firstred\\PostNL\\Entity\\Event>` | null 


.. php:attr:: protected static Groups

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Group\[\] <Firstred\\PostNL\\Entity\\Group>` | null 


.. php:attr:: protected static IDExpiration

	:Type: string | null 


.. php:attr:: protected static IDNumber

	:Type: string | null 


.. php:attr:: protected static IDType

	:Type: string | null 


.. php:attr:: protected static OldStatuses

	:Type: string | null 


.. php:attr:: protected static ProductCodeCollect

	:Type: string | null 


.. php:attr:: protected static ProductCodeDelivery

	:Type: string | null 


.. php:attr:: protected static ProductOptions

	:Type: :any:`\\Firstred\\PostNL\\Entity\\ProductOption\[\] <Firstred\\PostNL\\Entity\\ProductOption>` | null 


.. php:attr:: protected static ReceiverDateOfBirth

	:Type: string | null 


.. php:attr:: protected static Reference

	:Type: string | null 


.. php:attr:: protected static ReferenceCollect

	:Type: string | null 


.. php:attr:: protected static Remark

	:Type: string | null 


.. php:attr:: protected static ReturnBarcode

	:Type: string | null 


.. php:attr:: protected static ReturnReference

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Addresses=null, $Amounts=null, $Barcode=null, $Contacts=null, $Content=null, $CollectionTimeStampEnd=null, $CollectionTimeStampStart=null, $CostCenter=null, $Customer=null, $CustomerOrderNumber=null, $Customs=null, $DeliveryAddress=null, $DeliveryDate=null, $Dimension=null, $DownPartnerBarcode=null, $DownPartnerID=null, $DownPartnerLocation=null, $Events=null, $Groups=null, $IDExpiration=null, $IDNumber=null, $IDType=null, $OldStatuses=null, $ProductCodeCollect=null, $ProductCodeDelivery=null, $ProductOptions=null, $ReceiverDateOfBirth=null, $Reference=null, $ReferenceCollect=null, $Remark=null, $ReturnBarcode=null, $ReturnReference=null, $StatusCode=null, $PhaseCode=null, $DateFrom=null, $DateTo=null, $DeliveryTimeStampStart=null, $DeliveryTimeStampEnd=null)
	
		.. rst-class:: phpdoc-description
		
			| Shipment constructor\.
			
		
		
		:Parameters:
			* **$Addresses** (:any:`Firstred\\PostNL\\Entity\\Address\[\] <Firstred\\PostNL\\Entity\\Address>` | null)  
			* **$Amounts** (array | null)  
			* **$Barcode** (string | null)  
			* **$Contacts** (:any:`Firstred\\PostNL\\Entity\\Contact\[\] <Firstred\\PostNL\\Entity\\Contact>` | null)  
			* **$Content** (string | null)  
			* **$CollectionTimeStampEnd** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$CollectionTimeStampStart** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$CostCenter** (string | null)  
			* **$Customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` | null)  
			* **$CustomerOrderNumber** (string | null)  
			* **$Customs** (:any:`Firstred\\PostNL\\Entity\\Customs <Firstred\\PostNL\\Entity\\Customs>` | null)  
			* **$DeliveryAddress** (string | null)  
			* **$DeliveryDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$Dimension** (:any:`Firstred\\PostNL\\Entity\\Dimension <Firstred\\PostNL\\Entity\\Dimension>` | null)  
			* **$DownPartnerBarcode** (string | null)  
			* **$DownPartnerID** (string | null)  
			* **$DownPartnerLocation** (string | null)  
			* **$Events** (:any:`Firstred\\PostNL\\Entity\\Event\[\] <Firstred\\PostNL\\Entity\\Event>` | null)  
			* **$Groups** (:any:`Firstred\\PostNL\\Entity\\Group\[\] <Firstred\\PostNL\\Entity\\Group>` | null)  
			* **$IDExpiration** (string | null)  
			* **$IDNumber** (string | null)  
			* **$IDType** (string | null)  
			* **$OldStatuses** (array | null)  
			* **$ProductCodeCollect** (string | null)  
			* **$ProductCodeDelivery** (string | null)  
			* **$ProductOptions** (:any:`Firstred\\PostNL\\Entity\\ProductOption\[\] <Firstred\\PostNL\\Entity\\ProductOption>` | null)  
			* **$ReceiverDateOfBirth** (string | null)  
			* **$Reference** (string | null)  
			* **$ReferenceCollect** (string | null)  
			* **$Remark** (string | null)  
			* **$ReturnBarcode** (string | null)  
			* **$ReturnReference** (string | null)  
			* **$StatusCode** (string | null)  
			* **$PhaseCode** (int | null)  
			* **$DateFrom** (string | null)  
			* **$DateTo** (string | null)  
			* **$DeliveryTimeStampStart** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$DeliveryTimeStampEnd** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setCollectionTimeStampStart( $CollectionTimeStampStart=null)
	
		
		:Parameters:
			* **$CollectionTimeStampStart** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setCollectionTimeStampEnd( $CollectionTimeStampEnd=null)
	
		
		:Parameters:
			* **$CollectionTimeStampEnd** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryTimeStampStart( $DeliveryTimeStampStart=null)
	
		
		:Parameters:
			* **$DeliveryTimeStampStart** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryTimeStampEnd( $DeliveryTimeStampEnd=null)
	
		
		:Parameters:
			* **$DeliveryTimeStampEnd** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDate( $DeliveryDate=null)
	
		
		:Parameters:
			* **$DeliveryDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

