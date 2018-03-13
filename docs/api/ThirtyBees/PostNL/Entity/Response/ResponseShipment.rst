.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseShipment
================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: ResponseShipment


	.. rst-class:: phpdoc-description
	
		| Class ResponseShipment
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static DownPartnerBarcode

	:Type: string | null 


.. php:attr:: protected static DownPartnerID

	:Type: string | null 


.. php:attr:: protected static DownPartnerLocation

	:Type: string | null 


.. php:attr:: protected static Labels

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Label\[\] <ThirtyBees\\PostNL\\Entity\\Label>` | null 


.. php:attr:: protected static ProductCodeDelivery

	:Type: string | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Warning\[\] <ThirtyBees\\PostNL\\Entity\\Warning>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $barcode=null, $productCodeDelivery=null, $labels=null, $downPartnerBarcode=null, $downPartnerId=null, $downPartnerLocation=null, $warnings=null)
	
		
		:Parameters:
			* **$barcode** (string | null)  
			* **$productCodeDelivery** (string | null)  
			* **$labels** (:any:`ThirtyBees\\PostNL\\Entity\\Label\[\] <ThirtyBees\\PostNL\\Entity\\Label>` | null)  
			* **$downPartnerBarcode** (string | null)  
			* **$downPartnerId** (string | null)  
			* **$downPartnerLocation** (string | null)  
			* **$warnings** (array | null)  

		
	
	

