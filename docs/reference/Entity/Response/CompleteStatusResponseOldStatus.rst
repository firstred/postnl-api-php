.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CompleteStatusResponseOldStatus
===============================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CompleteStatusResponseOldStatus


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($StatusCode, $StatusDescription, $PhaseCode, $PhaseDescription, $TimeStamp\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::\_\_construct\(\)>`
* :php:meth:`public getStatusCode\(\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::getStatusCode\(\)>`
* :php:meth:`public setStatusCode\($StatusCode\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::setStatusCode\(\)>`
* :php:meth:`public getStatusDescription\(\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::getStatusDescription\(\)>`
* :php:meth:`public setStatusDescription\($StatusDescription\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::setStatusDescription\(\)>`
* :php:meth:`public getPhaseCode\(\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::getPhaseCode\(\)>`
* :php:meth:`public setPhaseCode\($PhaseCode\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::setPhaseCode\(\)>`
* :php:meth:`public getPhaseDescription\(\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::getPhaseDescription\(\)>`
* :php:meth:`public setPhaseDescription\($PhaseDescription\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::setPhaseDescription\(\)>`
* :php:meth:`public getTimeStamp\(\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::getTimeStamp\(\)>`
* :php:meth:`public setTimeStamp\($TimeStamp\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseOldStatus::setTimeStamp\(\)>`


Properties
----------

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

	.. php:method:: public __construct( $StatusCode=null, $StatusDescription=null, $PhaseCode=null, $PhaseDescription=null, \\DateTimeInterface|string|null $TimeStamp=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getStatusCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setStatusCode( $StatusCode)
	
		
		:Parameters:
			* **$StatusCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getStatusDescription()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setStatusDescription( $StatusDescription)
	
		
		:Parameters:
			* **$StatusDescription** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getPhaseCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setPhaseCode( $PhaseCode)
	
		
		:Parameters:
			* **$PhaseCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getPhaseDescription()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setPhaseDescription( $PhaseDescription)
	
		
		:Parameters:
			* **$PhaseDescription** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getTimeStamp()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setTimeStamp(\\DateTimeInterface|string|null $TimeStamp=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

