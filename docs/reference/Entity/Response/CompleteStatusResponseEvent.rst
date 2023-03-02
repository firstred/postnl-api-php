.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CompleteStatusResponseEvent
===========================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: CompleteStatusResponseEvent


	.. rst-class:: phpdoc-description
	
		| Class CompleteStatusResponseEvent\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Code, $Description, $DestinationLocationCode, $LocationCode, $RouteCode, $RouteName, $TimeStamp\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent::\_\_construct\(\)>`
* :php:meth:`public setTimeStamp\($TimeStamp\)<Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseEvent::setTimeStamp\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Code

	:Type: string | null 


.. php:attr:: protected static Description

	:Type: string | null 


.. php:attr:: protected static DestinationLocationCode

	:Type: string | null 


.. php:attr:: protected static LocationCode

	:Type: string | null 


.. php:attr:: protected static RouteCode

	:Type: string | null 


.. php:attr:: protected static RouteName

	:Type: string | null 


.. php:attr:: protected static TimeStamp

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Code=null, $Description=null, $DestinationLocationCode=null, $LocationCode=null, $RouteCode=null, $RouteName=null, $TimeStamp=null)
	
		.. rst-class:: phpdoc-description
		
			| CompleteStatusResponseEvent constructor\.
			
		
		
		:Parameters:
			* **$Code** (string | null)  
			* **$Description** (string | null)  
			* **$DestinationLocationCode** (string | null)  
			* **$LocationCode** (string | null)  
			* **$RouteCode** (string | null)  
			* **$RouteName** (string | null)  
			* **$TimeStamp** (string | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setTimeStamp( $TimeStamp=null)
	
		
		:Parameters:
			* **$TimeStamp** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

