.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Customer
========


.. php:namespace:: ThirtyBees\PostNL\Entity

.. php:class:: Customer


	.. rst-class:: phpdoc-description
	
		| Class Customer
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Address

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Address <ThirtyBees\\PostNL\\Entity\\Address>` | null 


.. php:attr:: protected static CollectionLocation

	:Type: string | null 


.. php:attr:: protected static ContactPerson

	:Type: string | null 


.. php:attr:: protected static CustomerCode

	:Type: string | null 


.. php:attr:: protected static CustomerNumber

	:Type: string | null 


.. php:attr:: protected static GlobalPackCustomerCode

	:Type: null | string 


.. php:attr:: protected static GlobalPackBarcodeType

	:Type: null | string 


.. php:attr:: protected static Email

	:Type: string | null 


.. php:attr:: protected static Name

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $customerNr=null, $customerCode=null, $collectionLocation=null, $contactPerson=null, $email=null, $name=null, $address=null)
	
		
		:Parameters:
			* **$customerNr** (string)  
			* **$customerCode** (string)  
			* **$collectionLocation** (string)  
			* **$contactPerson** (string)  
			* **$email** (string)  
			* **$name** (string)  
			* **$address** (:any:`ThirtyBees\\PostNL\\Entity\\Address <ThirtyBees\\PostNL\\Entity\\Address>`)  

		
	
	

