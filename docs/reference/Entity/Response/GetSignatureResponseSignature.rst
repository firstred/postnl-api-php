.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSignatureResponseSignature
=============================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetSignatureResponseSignature


	.. rst-class:: phpdoc-description
	
		| Class GetSignatureResponseSignature\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Barcode, $SignatureDate, $SignatureImage\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::\_\_construct\(\)>`
* :php:meth:`public setSignatureDate\($SignatureDate\)<Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature::setSignatureDate\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Barcode

	:Type: string | null 


.. php:attr:: protected static SignatureDate

	:Type: string | null 


.. php:attr:: protected static SignatureImage

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Barcode=null, $SignatureDate=null, $SignatureImage=null)
	
		.. rst-class:: phpdoc-description
		
			| GetSignatureResponseSignature constructor\.
			
		
		
		:Parameters:
			* **$Barcode** (string | null)  
			* **$SignatureDate** (string | null)  
			* **$SignatureImage** (string | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setSignatureDate( $SignatureDate=null)
	
		
		:Parameters:
			* **$SignatureDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

