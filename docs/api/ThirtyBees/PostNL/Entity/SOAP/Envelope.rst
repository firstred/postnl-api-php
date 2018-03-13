.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Envelope
========


.. php:namespace:: ThirtyBees\PostNL\Entity\SOAP

.. php:class:: Envelope


	.. rst-class:: phpdoc-description
	
		| Class Envelope
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static Header

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\SOAP\\Header <ThirtyBees\\PostNL\\Entity\\SOAP\\Header>` | null 


.. php:attr:: protected static Body

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\SOAP\\Body <ThirtyBees\\PostNL\\Entity\\SOAP\\Body>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $header=null, $body=null)
	
		.. rst-class:: phpdoc-description
		
			| Envelope constructor\.
			
		
		
		:Parameters:
			* **$header** (:any:`ThirtyBees\\PostNL\\Entity\\SOAP\\Header <ThirtyBees\\PostNL\\Entity\\SOAP\\Header>` | null)  
			* **$body** (:any:`ThirtyBees\\PostNL\\Entity\\SOAP\\Body <ThirtyBees\\PostNL\\Entity\\SOAP\\Body>` | null)  

		
	
	

