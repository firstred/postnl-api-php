.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurrentStatusResponseShipment
=============================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: CurrentStatusResponseShipment


	.. rst-class:: phpdoc-description
	
		| Class CurrentStatusResponseShipment
		
	
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

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Barcode <ThirtyBees\\PostNL\\Entity\\Barcode>` | null 


.. php:attr:: protected static DeliveryDate

	:Type: string | null 


.. php:attr:: protected static Dimension

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Dimension <ThirtyBees\\PostNL\\Entity\\Dimension>` | null Dimension


.. php:attr:: protected static Expectation

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Expectation <ThirtyBees\\PostNL\\Entity\\Expectation>` | null 


.. php:attr:: protected static Groups

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Group\[\] <ThirtyBees\\PostNL\\Entity\\Group>` | null 


.. php:attr:: protected static ProductCode

	:Type: string | null 


.. php:attr:: protected static ProductOptions

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\ProductOption\[\] <ThirtyBees\\PostNL\\Entity\\ProductOption>` | null 


.. php:attr:: protected static Reference

	:Type: string | null 


.. php:attr:: protected static Status

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Status <ThirtyBees\\PostNL\\Entity\\Status>` | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Warning\[\] <ThirtyBees\\PostNL\\Entity\\Warning>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $addresses=null, $amounts=null, $barcode=null, $deliveryDate=null, $dimension=null, $expectation=null, $groups=null, $productCode=null, $productOptions=null, $reference=null, $status=null, $warnings=null)
	
		.. rst-class:: phpdoc-description
		
			| CurrentStatusResponseShipment constructor\.
			
		
		
		:Parameters:
			* **$addresses** (:any:`ThirtyBees\\PostNL\\Entity\\Address\[\] <ThirtyBees\\PostNL\\Entity\\Address>` | null)  
			* **$amounts** (:any:`ThirtyBees\\PostNL\\Entity\\Amount\[\] <ThirtyBees\\PostNL\\Entity\\Amount>` | null)  
			* **$barcode** (:any:`ThirtyBees\\PostNL\\Entity\\Barcode <ThirtyBees\\PostNL\\Entity\\Barcode>` | null)  
			* **$deliveryDate** (string | null)  
			* **$dimension** (:any:`ThirtyBees\\PostNL\\Entity\\Dimension <ThirtyBees\\PostNL\\Entity\\Dimension>` | null)  
			* **$expectation** (:any:`ThirtyBees\\PostNL\\Entity\\Expectation <ThirtyBees\\PostNL\\Entity\\Expectation>` | null)  
			* **$groups** (:any:`ThirtyBees\\PostNL\\Entity\\Group\[\] <ThirtyBees\\PostNL\\Entity\\Group>` | null)  
			* **$productCode** (string | null)  
			* **$productOptions** (:any:`ThirtyBees\\PostNL\\Entity\\ProductOption\[\] <ThirtyBees\\PostNL\\Entity\\ProductOption>` | null)  
			* **$reference** (string | null)  
			* **$status** (:any:`ThirtyBees\\PostNL\\Entity\\Status <ThirtyBees\\PostNL\\Entity\\Status>` | null)  
			* **$warnings** (:any:`ThirtyBees\\PostNL\\Entity\\Warning\[\] <ThirtyBees\\PostNL\\Entity\\Warning>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

