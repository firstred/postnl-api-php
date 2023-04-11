.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetLocation
===========


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetLocation


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($LocationCode, $Message, $RetailNetworkID\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::\_\_construct\(\)>`
* :php:meth:`public getLocationCode\(\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::getLocationCode\(\)>`
* :php:meth:`public setLocationCode\($LocationCode\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::setLocationCode\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::setMessage\(\)>`
* :php:meth:`public getRetailNetworkID\(\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::getRetailNetworkID\(\)>`
* :php:meth:`public setRetailNetworkID\($RetailNetworkID\)<Firstred\\PostNL\\Entity\\Request\\GetLocation::setRetailNetworkID\(\)>`


Properties
----------

.. php:attr:: protected static LocationCode

	:Type: string | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static RetailNetworkID

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $LocationCode=null, $Message=null, $RetailNetworkID=null)
	
		
		:Parameters:
			* **$LocationCode** (string | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  
			* **$RetailNetworkID** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getLocationCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setLocationCode( $LocationCode)
	
		
		:Parameters:
			* **$LocationCode** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getRetailNetworkID()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setRetailNetworkID( $RetailNetworkID)
	
		
		:Parameters:
			* **$RetailNetworkID** (string | null)  

		
		:Returns: static 
	
	

