.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetNearestLocationsResponse
===========================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetNearestLocationsResponse


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GetLocationsResult\)<Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse::\_\_construct\(\)>`
* :php:meth:`public getGetLocationsResult\(\)<Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse::getGetLocationsResult\(\)>`
* :php:meth:`public setGetLocationsResult\($GetLocationsResult\)<Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse::setGetLocationsResult\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse::jsonDeserialize\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: protected static GetLocationsResult

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetLocationsResult <Firstred\\PostNL\\Entity\\Response\\GetLocationsResult>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $GetLocationsResult=null)
	
		
		:Parameters:
			* **$GetLocationsResult** (:any:`Firstred\\PostNL\\Entity\\Response\\GetLocationsResult <Firstred\\PostNL\\Entity\\Response\\GetLocationsResult>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getGetLocationsResult()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetLocationsResult <Firstred\\PostNL\\Entity\\Response\\GetLocationsResult>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setGetLocationsResult( $GetLocationsResult)
	
		
		:Parameters:
			* **$GetLocationsResult** (:any:`Firstred\\PostNL\\Entity\\Response\\GetLocationsResult <Firstred\\PostNL\\Entity\\Response\\GetLocationsResult>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse <Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		
		:Returns: array 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ServiceNotSetException <Firstred\\PostNL\\Exception\\ServiceNotSetException>` 
	
	

