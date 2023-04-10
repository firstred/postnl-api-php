.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Status
======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Status


	.. rst-class:: phpdoc-description
	
		| Class Status\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($PhaseCode, $PhaseDescription, $StatusCode, $StatusDescription, $TimeStamp\)<Firstred\\PostNL\\Entity\\Status::\_\_construct\(\)>`
* :php:meth:`public setTimeStamp\($TimeStamp\)<Firstred\\PostNL\\Entity\\Status::setTimeStamp\(\)>`
* :php:meth:`public getCurrentStatusPhaseCode\(\)<Firstred\\PostNL\\Entity\\Status::getCurrentStatusPhaseCode\(\)>`
* :php:meth:`public getCurrentStatusPhaseDescription\(\)<Firstred\\PostNL\\Entity\\Status::getCurrentStatusPhaseDescription\(\)>`
* :php:meth:`public getCurrentStatusStatusCode\(\)<Firstred\\PostNL\\Entity\\Status::getCurrentStatusStatusCode\(\)>`
* :php:meth:`public getCurrentStatusStatusDescription\(\)<Firstred\\PostNL\\Entity\\Status::getCurrentStatusStatusDescription\(\)>`
* :php:meth:`public getCurrentStatusTimeStamp\(\)<Firstred\\PostNL\\Entity\\Status::getCurrentStatusTimeStamp\(\)>`
* :php:meth:`public getCompleteStatusPhaseCode\(\)<Firstred\\PostNL\\Entity\\Status::getCompleteStatusPhaseCode\(\)>`
* :php:meth:`public getCompleteStatusPhaseDescription\(\)<Firstred\\PostNL\\Entity\\Status::getCompleteStatusPhaseDescription\(\)>`
* :php:meth:`public getCompleteStatusStatusCode\(\)<Firstred\\PostNL\\Entity\\Status::getCompleteStatusStatusCode\(\)>`
* :php:meth:`public getCompleteStatusStatusDescription\(\)<Firstred\\PostNL\\Entity\\Status::getCompleteStatusStatusDescription\(\)>`
* :php:meth:`public getCompleteStatusTimeStamp\(\)<Firstred\\PostNL\\Entity\\Status::getCompleteStatusTimeStamp\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static PhaseCode

	:Type: string | null 


.. php:attr:: protected static PhaseDescription

	:Type: string | null 


.. php:attr:: protected static StatusCode

	:Type: string | null 


.. php:attr:: protected static StatusDescription

	:Type: string | null 


.. php:attr:: protected static TimeStamp

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $PhaseCode=null, $PhaseDescription=null, $StatusCode=null, $StatusDescription=null, $TimeStamp=null)
	
		.. rst-class:: phpdoc-description
		
			| Status constructor\.
			
		
		
		:Parameters:
			* **$PhaseCode** (string | null)  
			* **$PhaseDescription** (string | null)  
			* **$StatusCode** (string | null)  
			* **$StatusDescription** (string | null)  
			* **$TimeStamp** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setTimeStamp( $TimeStamp=null)
	
		
		:Parameters:
			* **$TimeStamp** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCurrentStatusPhaseCode()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCurrentStatusPhaseDescription()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCurrentStatusStatusCode()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCurrentStatusStatusDescription()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCurrentStatusTimeStamp()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCompleteStatusPhaseCode()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCompleteStatusPhaseDescription()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCompleteStatusStatusCode()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCompleteStatusStatusDescription()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCompleteStatusTimeStamp()
	
		.. rst-class:: phpdoc-description
		
			| Backward compatible with SOAP API
			
		
		
		:Returns: string | null 
		:Since: 1.2.0 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

