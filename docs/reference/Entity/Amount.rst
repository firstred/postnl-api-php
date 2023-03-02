.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Amount
======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Amount


	.. rst-class:: phpdoc-description
	
		| Class Amount\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AccountName, $AmountType, $BIC, $Currency, $IBAN, $Reference, $TransactionNumber, $Value, $VerzekerdBedrag\)<Firstred\\PostNL\\Entity\\Amount::\_\_construct\(\)>`
* :php:meth:`public setAmountType\($AmountType\)<Firstred\\PostNL\\Entity\\Amount::setAmountType\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Amount::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static AccountName

	:Type: string | null 


.. php:attr:: protected static AmountType

	:Type: string | null 


.. php:attr:: protected static BIC

	:Type: string | null 


.. php:attr:: protected static Currency

	:Type: string | null 


.. php:attr:: protected static IBAN

	:Type: string | null 


.. php:attr:: protected static Reference

	:Type: string | null 


.. php:attr:: protected static TransactionNumber

	:Type: string | null 


.. php:attr:: protected static Value

	:Type: string | null 


.. php:attr:: protected static VerzekerdBedrag

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $AccountName=null, $AmountType=null, $BIC=null, $Currency=null, $IBAN=null, $Reference=null, $TransactionNumber=null, $Value=null, $VerzekerdBedrag=null)
	
		
		:Parameters:
			* **$AccountName** (string | null)  
			* **$AmountType** (string | null)  
			* **$BIC** (string | null)  
			* **$Currency** (string | null)  
			* **$IBAN** (string | null)  
			* **$Reference** (string | null)  
			* **$TransactionNumber** (string | null)  
			* **$Value** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setAmountType( $AmountType=null)
	
		.. rst-class:: phpdoc-description
		
			| Set amount type\.
			
		
		
		:Parameters:
			* **$AmountType** (string | int | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
		:Throws: :any:`\\InvalidArgumentException <InvalidArgumentException>` 
	
	

