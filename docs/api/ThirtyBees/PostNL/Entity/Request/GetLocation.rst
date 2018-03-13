.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetLocation
===========


.. php:namespace:: ThirtyBees\PostNL\Entity\Request

.. php:class:: GetLocation


	.. rst-class:: phpdoc-description
	
		| Class GetLocation
		
		| This class is both the container and can be the actual GetLocation object itself\!
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static LocationCode

	:Type: string | null 


.. php:attr:: protected static Message

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static RetailNetworkID

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $location=null, $message=null, $networkId=null)
	
		.. rst-class:: phpdoc-description
		
			| GetLocation constructor\.
			
		
		
		:Parameters:
			* **$location** (string | null)  
			* **$message** (:any:`ThirtyBees\\PostNL\\Entity\\Message\\Message <ThirtyBees\\PostNL\\Entity\\Message\\Message>` | null)  
			* **$networkId** (string | null)  

		
	
	

