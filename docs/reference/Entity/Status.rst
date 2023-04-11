.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Status
======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Status


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($PhaseCode, $PhaseDescription, $StatusCode, $StatusDescription, $TimeStamp\)<Firstred\\PostNL\\Entity\\Status::\_\_construct\(\)>`
* :php:meth:`public getPhaseCode\(\)<Firstred\\PostNL\\Entity\\Status::getPhaseCode\(\)>`
* :php:meth:`public setPhaseCode\($PhaseCode\)<Firstred\\PostNL\\Entity\\Status::setPhaseCode\(\)>`
* :php:meth:`public getPhaseDescription\(\)<Firstred\\PostNL\\Entity\\Status::getPhaseDescription\(\)>`
* :php:meth:`public setPhaseDescription\($PhaseDescription\)<Firstred\\PostNL\\Entity\\Status::setPhaseDescription\(\)>`
* :php:meth:`public getStatusCode\(\)<Firstred\\PostNL\\Entity\\Status::getStatusCode\(\)>`
* :php:meth:`public setStatusCode\($StatusCode\)<Firstred\\PostNL\\Entity\\Status::setStatusCode\(\)>`
* :php:meth:`public getStatusDescription\(\)<Firstred\\PostNL\\Entity\\Status::getStatusDescription\(\)>`
* :php:meth:`public setStatusDescription\($StatusDescription\)<Firstred\\PostNL\\Entity\\Status::setStatusDescription\(\)>`
* :php:meth:`public getTimeStamp\(\)<Firstred\\PostNL\\Entity\\Status::getTimeStamp\(\)>`
* :php:meth:`public setTimeStamp\($TimeStamp\)<Firstred\\PostNL\\Entity\\Status::setTimeStamp\(\)>`


Properties
----------

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

	.. php:method:: public __construct( $PhaseCode=null, $PhaseDescription=null, $StatusCode=null, $StatusDescription=null, string|\\DateTimeInterface|null $TimeStamp=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getPhaseCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setPhaseCode( $PhaseCode)
	
		
		:Parameters:
			* **$PhaseCode** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` 
	
	

.. rst-class:: public

	.. php:method:: public getPhaseDescription()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setPhaseDescription( $PhaseDescription)
	
		
		:Parameters:
			* **$PhaseDescription** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` 
	
	

.. rst-class:: public

	.. php:method:: public getStatusCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setStatusCode( $StatusCode)
	
		
		:Parameters:
			* **$StatusCode** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` 
	
	

.. rst-class:: public

	.. php:method:: public getStatusDescription()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setStatusDescription( $StatusDescription)
	
		
		:Parameters:
			* **$StatusDescription** (string | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Status <Firstred\\PostNL\\Entity\\Status>` 
	
	

.. rst-class:: public

	.. php:method:: public getTimeStamp()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setTimeStamp(string|\\DateTimeInterface|null $TimeStamp=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

