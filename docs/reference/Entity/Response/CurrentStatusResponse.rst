.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CurrentStatusResponse
=====================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CurrentStatusResponse


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Shipments, $Warnings\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse::\_\_construct\(\)>`
* :php:meth:`public getShipments\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse::getShipments\(\)>`
* :php:meth:`public setShipments\($Shipments\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse::setShipments\(\)>`
* :php:meth:`public getWarnings\(\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse::getWarnings\(\)>`
* :php:meth:`public setWarnings\($Warnings\)<Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse::setWarnings\(\)>`


Properties
----------

.. php:attr:: protected static Shipments

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Shipments=null, $Warnings=null)
	
		
		:Parameters:
			* **$Shipments** (array | null)  
			* **$Warnings** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getShipments()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setShipments( $Shipments)
	
		
		:Parameters:
			* **$Shipments** (:any:`Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getWarnings()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setWarnings( $Warnings)
	
		
		:Parameters:
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null)  

		
		:Returns: static 
	
	

