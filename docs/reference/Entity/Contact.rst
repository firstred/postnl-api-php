.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Contact
=======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Contact


	.. rst-class:: phpdoc-description
	
		| Class Contact\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($ContactType, $Email, $SMSNr, $TelNr\)<Firstred\\PostNL\\Entity\\Contact::\_\_construct\(\)>`
* :php:meth:`public setTelNr\($TelNr, $countryCode\)<Firstred\\PostNL\\Entity\\Contact::setTelNr\(\)>`
* :php:meth:`public setSMSNr\($SMSNr, $countryCode\)<Firstred\\PostNL\\Entity\\Contact::setSMSNr\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


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
	
		.. rst-class:: phpdoc-description
		
			| Contact constructor\.
			
		
		
		:Parameters:
			* **$ContactType** (string | null)  
			* **$Email** (string | null)  
			* **$SMSNr** (string | null)  
			* **$TelNr** (string | null)  

		
		:Throws: :any:`\\libphonenumber\\NumberParseException <libphonenumber\\NumberParseException>` 
	
	

.. rst-class:: public

	.. php:method:: public setTelNr( $TelNr=null, $countryCode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the telephone number\.
			
		
		
		:Parameters:
			* **$TelNr** (string | null)  
			* **$countryCode** (string | null)  

		
		:Returns: static 
		:Throws: :any:`\\libphonenumber\\NumberParseException <libphonenumber\\NumberParseException>` 
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setSMSNr( $SMSNr=null, $countryCode=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the mobile number\.
			
		
		
		:Parameters:
			* **$SMSNr** (string | null)  
			* **$countryCode** (string | null)  

		
		:Returns: static 
		:Throws: :any:`\\libphonenumber\\NumberParseException <libphonenumber\\NumberParseException>` 
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

