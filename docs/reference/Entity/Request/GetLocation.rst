.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetLocation
===========


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetLocation


	.. rst-class:: phpdoc-description
	
		| Class GetLocation\.
		
		| This class is both the container and can be the actual GetLocation object itself\!
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($LocationCode, $Message, $RetailNetworkID\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::\_\_construct\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::setMessage\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static LocationCode

	:Type: string | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	:Deprecated: 1.4.1 SOAP support is going to be removed


.. php:attr:: protected static RetailNetworkID

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $LocationCode=null, $Message=null, $RetailNetworkID=null)
	
		.. rst-class:: phpdoc-description
		
			| GetLocation constructor\.
			
		
		
		:Parameters:
			* **$LocationCode** (string | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  
			* **$RetailNetworkID** (string | null)  

		
	
	

.. rst-class:: public deprecated

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

.. rst-class:: public deprecated

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

