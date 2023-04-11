.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetNearestLocations
===================


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetNearestLocations


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Countrycode, $Location, $Message\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::\_\_construct\(\)>`
* :php:meth:`public getCountrycode\(\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::getCountrycode\(\)>`
* :php:meth:`public setCountrycode\($Countrycode\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::setCountrycode\(\)>`
* :php:meth:`public getLocation\(\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::getLocation\(\)>`
* :php:meth:`public setLocation\($Location\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::setLocation\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetNearestLocations::setMessage\(\)>`


Properties
----------

.. php:attr:: protected static Countrycode

	:Type: string | null 


.. php:attr:: protected static Location

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Location <Firstred\\PostNL\\Entity\\Location>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Countrycode=null, $Location=null, $Message=null)
	
		
		:Parameters:
			* **$Countrycode** (string | null)  
			* **$Location** (:any:`Firstred\\PostNL\\Entity\\Location <Firstred\\PostNL\\Entity\\Location>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getCountrycode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCountrycode( $Countrycode)
	
		
		:Parameters:
			* **$Countrycode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getLocation()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Location <Firstred\\PostNL\\Entity\\Location>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setLocation( $Location)
	
		
		:Parameters:
			* **$Location** (:any:`Firstred\\PostNL\\Entity\\Location <Firstred\\PostNL\\Entity\\Location>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
	
	

