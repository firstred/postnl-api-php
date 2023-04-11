.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CompleteStatusResponse
======================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CompleteStatusResponse


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Warnings\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::\_\_construct\(\)>`
* :php:meth:`public getShipments\(\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::getShipments\(\)>`
* :php:meth:`public setShipments\($Shipments\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::setShipments\(\)>`
* :php:meth:`public getWarnings\(\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::getWarnings\(\)>`
* :php:meth:`public setWarnings\($Warnings\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::setWarnings\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Warning <Firstred\\PostNL\\Entity\\Warning>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Warnings=null)
	
		
		:Parameters:
			* **$Shipments** (array | null)  
			* **$Warnings** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getShipments()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setShipments( $Shipments)
	
		
		:Parameters:
			* **$Shipments** (:any:`Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getWarnings()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Warning <Firstred\\PostNL\\Entity\\Warning>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setWarnings( $Warnings)
	
		
		:Parameters:
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Warning <Firstred\\PostNL\\Entity\\Warning>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
	
	

