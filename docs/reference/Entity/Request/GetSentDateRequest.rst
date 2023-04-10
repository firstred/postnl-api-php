.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSentDateRequest
==================


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetSentDateRequest


	.. rst-class:: phpdoc-description
	
		| Class GetSentDateRequest\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GetSentDate, $Message\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::\_\_construct\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::setMessage\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static GetSentDate

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Request\\GetSentDate <Firstred\\PostNL\\Entity\\Request\\GetSentDate>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	:Deprecated: 1.4.1 SOAP support is going to be removed


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $GetSentDate=null, $Message=null)
	
		.. rst-class:: phpdoc-description
		
			| GetSentDate constructor\.
			
		
		
		:Parameters:
			* **$GetSentDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSentDate <Firstred\\PostNL\\Entity\\Request\\GetSentDate>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public deprecated

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
		:Deprecated: 1.4.1 SOAP support is going to be removec
	
	

