.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Contact
=======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Contact


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($ContactType, $Email, $SMSNr, $TelNr\)<Firstred\\PostNL\\Entity\\Contact::\_\_construct\(\)>`
* :php:meth:`public getContactType\(\)<Firstred\\PostNL\\Entity\\Contact::getContactType\(\)>`
* :php:meth:`public setContactType\($ContactType\)<Firstred\\PostNL\\Entity\\Contact::setContactType\(\)>`
* :php:meth:`public getEmail\(\)<Firstred\\PostNL\\Entity\\Contact::getEmail\(\)>`
* :php:meth:`public setEmail\($Email\)<Firstred\\PostNL\\Entity\\Contact::setEmail\(\)>`
* :php:meth:`public getSMSNr\(\)<Firstred\\PostNL\\Entity\\Contact::getSMSNr\(\)>`
* :php:meth:`public getTelNr\(\)<Firstred\\PostNL\\Entity\\Contact::getTelNr\(\)>`
* :php:meth:`public setTelNr\($TelNr, $countryCode\)<Firstred\\PostNL\\Entity\\Contact::setTelNr\(\)>`
* :php:meth:`public setSMSNr\($SMSNr, $countryCode\)<Firstred\\PostNL\\Entity\\Contact::setSMSNr\(\)>`


Properties
----------

.. php:attr:: protected static ContactType

	:Type: string | null 


.. php:attr:: protected static Email

	:Type: string | null 


.. php:attr:: protected static SMSNr

	:Type: string | null 


.. php:attr:: protected static TelNr

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $ContactType=null, $Email=null, $SMSNr=null, $TelNr=null)
	
		
		:Parameters:
			* **$ContactType** (string | null)  
			* **$Email** (string | null)  
			* **$SMSNr** (string | null)  
			* **$TelNr** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getContactType()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setContactType( $ContactType)
	
		
		:Parameters:
			* **$ContactType** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getEmail()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setEmail( $Email)
	
		
		:Parameters:
			* **$Email** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getSMSNr()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public getTelNr()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setTelNr( $TelNr=null, $countryCode=null)
	
		
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setSMSNr( $SMSNr=null, $countryCode=null)
	
		
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

