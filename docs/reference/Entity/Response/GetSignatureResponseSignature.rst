.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSignatureResponseSignature
=============================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetSignatureResponseSignature


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Barcode, $SignatureDate, $SignatureImage\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::\_\_construct\(\)>`
* :php:meth:`public getBarcode\(\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::getBarcode\(\)>`
* :php:meth:`public setBarcode\($Barcode\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::setBarcode\(\)>`
* :php:meth:`public getSignatureImage\(\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::getSignatureImage\(\)>`
* :php:meth:`public setSignatureImage\($SignatureImage\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::setSignatureImage\(\)>`
* :php:meth:`public getSignatureDate\(\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::getSignatureDate\(\)>`
* :php:meth:`public setSignatureDate\($SignatureDate\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::setSignatureDate\(\)>`


Properties
----------

.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static SignatureDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static SignatureImage

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Barcode=null, $SignatureDate=null, $SignatureImage=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getBarcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setBarcode( $Barcode)
	
		
		:Parameters:
			* **$Barcode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getSignatureImage()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setSignatureImage( $SignatureImage)
	
		
		:Parameters:
			* **$SignatureImage** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getSignatureDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setSignatureDate(string|\\DateTimeInterface|null $SignatureDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

