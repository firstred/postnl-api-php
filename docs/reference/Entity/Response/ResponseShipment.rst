.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseShipment
================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: ResponseShipment


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Barcode, $ProductCodeDelivery, $Labels, $DownPartnerBarcode, $DownPartnerID, $DownPartnerLocation, $Warnings, $CodingText\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::\_\_construct\(\)>`
* :php:meth:`public getBarcode\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::getBarcode\(\)>`
* :php:meth:`public setBarcode\($Barcode\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::setBarcode\(\)>`
* :php:meth:`public getDownPartnerBarcode\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::getDownPartnerBarcode\(\)>`
* :php:meth:`public setDownPartnerBarcode\($DownPartnerBarcode\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::setDownPartnerBarcode\(\)>`
* :php:meth:`public getDownPartnerID\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::getDownPartnerID\(\)>`
* :php:meth:`public setDownPartnerID\($DownPartnerID\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::setDownPartnerID\(\)>`
* :php:meth:`public getDownPartnerLocation\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::getDownPartnerLocation\(\)>`
* :php:meth:`public setDownPartnerLocation\($DownPartnerLocation\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::setDownPartnerLocation\(\)>`
* :php:meth:`public getLabels\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::getLabels\(\)>`
* :php:meth:`public setLabels\($Labels\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::setLabels\(\)>`
* :php:meth:`public getProductCodeDelivery\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::getProductCodeDelivery\(\)>`
* :php:meth:`public setProductCodeDelivery\($ProductCodeDelivery\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::setProductCodeDelivery\(\)>`
* :php:meth:`public getWarnings\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::getWarnings\(\)>`
* :php:meth:`public setWarnings\($Warnings\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::setWarnings\(\)>`
* :php:meth:`public setCodingText\($CodingText\)<Firstred\\PostNL\\Entity\\Response\\ResponseShipment::setCodingText\(\)>`


Properties
----------

.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static DownPartnerBarcode

	:Type: string | null 


.. php:attr:: protected static DownPartnerID

	:Type: string | null 


.. php:attr:: protected static DownPartnerLocation

	:Type: string | null 


.. php:attr:: protected static Labels

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Label\[\] <Firstred\\PostNL\\Entity\\Label>` | null 


.. php:attr:: protected static ProductCodeDelivery

	:Type: string | null 


.. php:attr:: protected static Warnings

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 


.. php:attr:: protected static CodingText

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Barcode=null, $ProductCodeDelivery=null, $Labels=null, $DownPartnerBarcode=null, $DownPartnerID=null, $DownPartnerLocation=null, $Warnings=null, $CodingText=null)
	
		
		:Parameters:
			* **$Barcode** (string | null)  
			* **$ProductCodeDelivery** (string | null)  
			* **$Labels** (array | null)  
			* **$DownPartnerBarcode** (string | null)  
			* **$DownPartnerID** (string | null)  
			* **$DownPartnerLocation** (string | null)  
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

	.. php:method:: public getDownPartnerBarcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDownPartnerBarcode( $DownPartnerBarcode)
	
		
		:Parameters:
			* **$DownPartnerBarcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDownPartnerID()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDownPartnerID( $DownPartnerID)
	
		
		:Parameters:
			* **$DownPartnerID** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDownPartnerLocation()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDownPartnerLocation( $DownPartnerLocation)
	
		
		:Parameters:
			* **$DownPartnerLocation** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getLabels()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Label\[\] <Firstred\\PostNL\\Entity\\Label>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setLabels( $Labels)
	
		
		:Parameters:
			* **$Labels** (:any:`Firstred\\PostNL\\Entity\\Label\[\] <Firstred\\PostNL\\Entity\\Label>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getProductCodeDelivery()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setProductCodeDelivery( $ProductCodeDelivery)
	
		
		:Parameters:
			* **$ProductCodeDelivery** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getWarnings()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setWarnings( $Warnings)
	
		
		:Parameters:
			* **$Warnings** (:any:`Firstred\\PostNL\\Entity\\Warning\[\] <Firstred\\PostNL\\Entity\\Warning>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setCodingText( $CodingText)
	
		
		:Parameters:
			* **$CodingText** (string | null)  

		
		:Returns: static 
	
	

