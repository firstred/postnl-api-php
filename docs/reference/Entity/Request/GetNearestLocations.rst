.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetNearestLocations
===================


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetNearestLocations


	.. rst-class:: phpdoc-description
	
		| Class GetNearestLocations\.
		
		| This class is both the container and can be the actual GetNearestLocations object itself\!
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Countrycode, $Location, $Message\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::\_\_construct\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::setMessage\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Countrycode

	:Type: string | null 


.. php:attr:: protected static Location

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Location <Firstred\\PostNL\\Entity\\Location>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	:Deprecated: 1.4.1 SOAP support is going to be removed


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Countrycode=null, $Location=null, $Message=null)
	
		.. rst-class:: phpdoc-description
		
			| GetNearestLocations constructor\.
			
		
		
		:Parameters:
			* **$Countrycode** (string | null)  
			* **$Location** (:any:`Firstred\\PostNL\\Entity\\Location <Firstred\\PostNL\\Entity\\Location>` | null)  
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
		:Deprecated: 1.4.1 SOAP support is going to be removed
	
	

