.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetDeliveryDateResponse
=======================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: GetDeliveryDateResponse


	.. rst-class:: phpdoc-description
	
		| Class GetDeliveryDateResponse
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API
		
	
	:Type: array 


.. php:attr:: protected static DeliveryDate

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $date=null, $options=null)
	
		.. rst-class:: phpdoc-description
		
			| GetDeliveryDateResponse constructor\.
			
		
		
		:Parameters:
			* **$date** (string | null)  
			* **$options** (string[] | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

