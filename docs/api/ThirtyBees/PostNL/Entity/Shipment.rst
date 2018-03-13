.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Shipment
========


.. php:namespace:: ThirtyBees\PostNL\Entity

.. php:class:: Shipment


	.. rst-class:: phpdoc-description
	
		| Class Shipment
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Addresses

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Address\[\] <ThirtyBees\\PostNL\\Entity\\Address>` | null 


.. php:attr:: protected static Amounts

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Amount\[\] <ThirtyBees\\PostNL\\Entity\\Amount>` | null 


.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static CollectionTimeStampEnd

	:Type: string | null 


.. php:attr:: protected static CollectionTimeStampStart

	:Type: string | null 


.. php:attr:: protected static Contacts

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Contact\[\] <ThirtyBees\\PostNL\\Entity\\Contact>` | null 


.. php:attr:: protected static Content

	:Type: string | null 


.. php:attr:: protected static CostCenter

	:Type: string | null 


.. php:attr:: protected static CustomerOrderNumber

	:Type: string | null 


.. php:attr:: protected static Customer

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` | null 


.. php:attr:: protected static Customs

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Customs <ThirtyBees\\PostNL\\Entity\\Customs>` | null 


.. php:attr:: protected static StatusCode

	:Type: string \|null$StatusCode


.. php:attr:: protected static PhaseCode

	:Type: int | null 


.. php:attr:: protected static DateFrom

	:Type: string | null 


.. php:attr:: protected static DateTo

	:Type: string | null 


.. php:attr:: protected static DeliveryAddress

	:Type: string | null 


.. php:attr:: protected static DeliveryTimeStampStart

	:Type: string | null 


.. php:attr:: protected static DeliveryTimeStampEnd

	:Type: string | null 


.. php:attr:: protected static DeliveryDate

	:Type: string | null 


.. php:attr:: protected static Dimension

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Dimension <ThirtyBees\\PostNL\\Entity\\Dimension>` | null 


.. php:attr:: protected static DownPartnerBarcode

	:Type: string | null 


.. php:attr:: protected static DownPartnerID

	:Type: string | null 


.. php:attr:: protected static DownPartnerLocation

	:Type: string | null 


.. php:attr:: protected static Events

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Event\[\] <ThirtyBees\\PostNL\\Entity\\Event>` | null 


.. php:attr:: protected static Groups

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Group\[\] <ThirtyBees\\PostNL\\Entity\\Group>` | null 


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

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\ProductOption\[\] <ThirtyBees\\PostNL\\Entity\\ProductOption>` | null 


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

	.. php:method:: public __construct( $addresses=null, $amounts=null, $barcode=null, $contacts=null, $content=null, $collectionTimeStampEnd=null, $collectionTimeStampStart=null, $costCenter=null, $customer=null, $customerOrderNumber=null, $customs=null, $deliveryAddress=null, $deliveryDate=null, $dimension=null, $downPartnerBarcode=null, $downPartnerId=null, $downPartnerLocation=null, $events=null, $groups=null, $idExpiration=null, $idNumber=null, $idType=null, $oldStatuses=null, $productCodeCollect=null, $productCodeDelivery=null, $productOptions=null, $receiverDateOfBirth=null, $reference=null, $referenceCollect=null, $remark=null, $returnBarcode=null, $returnReference=null, $statusCode=null, $phaseCode=null, $dateFrom=null, $dateTo=null)
	
		.. rst-class:: phpdoc-description
		
			| Shipment constructor\.
			
		
		
		:Parameters:
			* **$addresses** (:any:`ThirtyBees\\PostNL\\Entity\\Address\[\] <ThirtyBees\\PostNL\\Entity\\Address>` | null)  
			* **$amounts** (array | null)  
			* **$barcode** (string | null)  
			* **$contacts** (:any:`ThirtyBees\\PostNL\\Entity\\Contact\[\] <ThirtyBees\\PostNL\\Entity\\Contact>` | null)  
			* **$content** (string | null)  
			* **$collectionTimeStampEnd** (string | null)  
			* **$collectionTimeStampStart** (string | null)  
			* **$costCenter** (string | null)  
			* **$customer** (:any:`ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` | null)  
			* **$customerOrderNumber** (string | null)  
			* **$customs** (:any:`ThirtyBees\\PostNL\\Entity\\Customs <ThirtyBees\\PostNL\\Entity\\Customs>` | null)  
			* **$deliveryAddress** (string | null)  
			* **$deliveryDate** (string | null)  
			* **$dimension** (:any:`ThirtyBees\\PostNL\\Entity\\Dimension <ThirtyBees\\PostNL\\Entity\\Dimension>` | null)  
			* **$downPartnerBarcode** (string | null)  
			* **$downPartnerId** (string | null)  
			* **$downPartnerLocation** (string | null)  
			* **$events** (:any:`ThirtyBees\\PostNL\\Entity\\Event\[\] <ThirtyBees\\PostNL\\Entity\\Event>` | null)  
			* **$groups** (:any:`ThirtyBees\\PostNL\\Entity\\Group\[\] <ThirtyBees\\PostNL\\Entity\\Group>` | null)  
			* **$idExpiration** (string | null)  
			* **$idNumber** (string | null)  
			* **$idType** (string | null)  
			* **$oldStatuses** (array | null)  
			* **$productCodeCollect** (string | null)  
			* **$productCodeDelivery** (string | null)  
			* **$productOptions** (:any:`ThirtyBees\\PostNL\\Entity\\ProductOption\[\] <ThirtyBees\\PostNL\\Entity\\ProductOption>` | null)  
			* **$receiverDateOfBirth** (string | null)  
			* **$reference** (string | null)  
			* **$referenceCollect** (string | null)  
			* **$remark** (string | null)  
			* **$returnBarcode** (string | null)  
			* **$returnReference** (string | null)  
			* **$statusCode** (string | null)  
			* **$phaseCode** (int | null)  
			* **$dateFrom** (string | null)  
			* **$dateTo** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

