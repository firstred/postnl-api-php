.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Amount
======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Amount


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($AccountName, $AmountType, $BIC, $Currency, $IBAN, $Reference, $TransactionNumber, $Value, $VerzekerdBedrag\)<Firstred\\PostNL\\Entity\\Amount::\_\_construct\(\)>`
* :php:meth:`public getAccountName\(\)<Firstred\\PostNL\\Entity\\Amount::getAccountName\(\)>`
* :php:meth:`public setAccountName\($AccountName\)<Firstred\\PostNL\\Entity\\Amount::setAccountName\(\)>`
* :php:meth:`public getBIC\(\)<Firstred\\PostNL\\Entity\\Amount::getBIC\(\)>`
* :php:meth:`public setBIC\($BIC\)<Firstred\\PostNL\\Entity\\Amount::setBIC\(\)>`
* :php:meth:`public getCurrency\(\)<Firstred\\PostNL\\Entity\\Amount::getCurrency\(\)>`
* :php:meth:`public setCurrency\($Currency\)<Firstred\\PostNL\\Entity\\Amount::setCurrency\(\)>`
* :php:meth:`public getIBAN\(\)<Firstred\\PostNL\\Entity\\Amount::getIBAN\(\)>`
* :php:meth:`public setIBAN\($IBAN\)<Firstred\\PostNL\\Entity\\Amount::setIBAN\(\)>`
* :php:meth:`public getReference\(\)<Firstred\\PostNL\\Entity\\Amount::getReference\(\)>`
* :php:meth:`public setReference\($Reference\)<Firstred\\PostNL\\Entity\\Amount::setReference\(\)>`
* :php:meth:`public getTransactionNumber\(\)<Firstred\\PostNL\\Entity\\Amount::getTransactionNumber\(\)>`
* :php:meth:`public setTransactionNumber\($TransactionNumber\)<Firstred\\PostNL\\Entity\\Amount::setTransactionNumber\(\)>`
* :php:meth:`public getValue\(\)<Firstred\\PostNL\\Entity\\Amount::getValue\(\)>`
* :php:meth:`public setValue\($Value\)<Firstred\\PostNL\\Entity\\Amount::setValue\(\)>`
* :php:meth:`public getVerzekerdBedrag\(\)<Firstred\\PostNL\\Entity\\Amount::getVerzekerdBedrag\(\)>`
* :php:meth:`public setVerzekerdBedrag\($VerzekerdBedrag\)<Firstred\\PostNL\\Entity\\Amount::setVerzekerdBedrag\(\)>`
* :php:meth:`public getAmountType\(\)<Firstred\\PostNL\\Entity\\Amount::getAmountType\(\)>`
* :php:meth:`public setAmountType\($AmountType\)<Firstred\\PostNL\\Entity\\Amount::setAmountType\(\)>`


Properties
----------

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
			* **$VerzekerdBedrag** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getAccountName()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setAccountName( $AccountName)
	
		
		:Parameters:
			* **$AccountName** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getBIC()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setBIC( $BIC)
	
		
		:Parameters:
			* **$BIC** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCurrency()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCurrency( $Currency)
	
		
		:Parameters:
			* **$Currency** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getIBAN()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setIBAN( $IBAN)
	
		
		:Parameters:
			* **$IBAN** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getReference()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setReference( $Reference)
	
		
		:Parameters:
			* **$Reference** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getTransactionNumber()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setTransactionNumber( $TransactionNumber)
	
		
		:Parameters:
			* **$TransactionNumber** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getValue()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setValue( $Value)
	
		
		:Parameters:
			* **$Value** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getVerzekerdBedrag()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setVerzekerdBedrag( $VerzekerdBedrag)
	
		
		:Parameters:
			* **$VerzekerdBedrag** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getAmountType()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setAmountType(string|int|null $AmountType=null)
	
		
		:Parameters:
			* **$AmountType** (string | int | null)  

		
		:Returns: static 
	
	

