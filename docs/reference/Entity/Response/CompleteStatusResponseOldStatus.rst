.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CompleteStatusResponseOldStatus
===============================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CompleteStatusResponseOldStatus


	.. rst-class:: phpdoc-description
	
		| Class CompleteStatusResponseOldStatus\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($StatusCode, $StatusDescription, $PhaseCode, $PhaseDescription, $TimeStamp\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::\_\_construct\(\)>`
* :php:meth:`public setTimeStamp\($TimeStamp\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::setTimeStamp\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static StatusCode

	:Type: string | null 


.. php:attr:: protected static StatusDescription

	:Type: string | null 


.. php:attr:: protected static PhaseCode

	:Type: string | null 


.. php:attr:: protected static PhaseDescription

	:Type: string | null 


.. php:attr:: protected static TimeStamp

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $StatusCode=null, $StatusDescription=null, $PhaseCode=null, $PhaseDescription=null, $TimeStamp=null)
	
		.. rst-class:: phpdoc-description
		
			| CompleteStatusResponseOldStatus constructor\.
			
		
		
		:Parameters:
			* **$StatusCode** (string | null)  
			* **$StatusDescription** (string | null)  
			* **$PhaseCode** (string | null)  
			* **$PhaseDescription** (string | null)  
			* **$TimeStamp** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setTimeStamp( $TimeStamp=null)
	
		
		:Parameters:
			* **$TimeStamp** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

