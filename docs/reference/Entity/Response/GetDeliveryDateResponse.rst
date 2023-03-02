.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetDeliveryDateResponse
=======================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetDeliveryDateResponse


	.. rst-class:: phpdoc-description
	
		| Class GetDeliveryDateResponse\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($DeliveryDate, $Options\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::\_\_construct\(\)>`
* :php:meth:`public setDeliveryDate\($DeliveryDate\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::setDeliveryDate\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::xmlSerialize\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static DeliveryDate

	:Type: string | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $DeliveryDate=null, $Options=null)
	
		.. rst-class:: phpdoc-description
		
			| GetDeliveryDateResponse constructor\.
			
		
		
		:Parameters:
			* **$DeliveryDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  
			* **$Options** (string[] | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDate( $DeliveryDate=null)
	
		
		:Parameters:
			* **$DeliveryDate** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  

		
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
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse <Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse>` | object | :any:`\\stdClass <stdClass>` | null 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

