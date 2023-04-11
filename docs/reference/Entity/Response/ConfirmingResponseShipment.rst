.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ConfirmingResponseShipment
==========================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: ConfirmingResponseShipment


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Barcode, $Warnings\)<Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment::\_\_construct\(\)>`
* :php:meth:`public getBarcode\(\)<Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment::getBarcode\(\)>`
* :php:meth:`public setBarcode\($Barcode\)<Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment::setBarcode\(\)>`
* :php:meth:`public getWarnings\(\)<Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment::getWarnings\(\)>`
* :php:meth:`public setWarnings\($Warnings\)<Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment::setWarnings\(\)>`


Properties
----------

.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Barcode=null, $Warnings=null)
	
		
		:Parameters:
			* **$Barcode** (string | null)  
			* **$Warnings** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getBarcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setBarcode( $Barcode)
	
		
		:Parameters:
			* **$Barcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getWarnings()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setWarnings( $Warnings)
	
		
		:Parameters:
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null)  

		
		:Returns: static 
	
	

