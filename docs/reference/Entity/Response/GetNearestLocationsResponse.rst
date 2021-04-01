.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetNearestLocationsResponse
===========================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetNearestLocationsResponse


	.. rst-class:: phpdoc-description
	
		| Class GetNearestLocationsResponse\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GetLocationsResult\)<Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse::\_\_construct\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse::jsonDeserialize\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static GetLocationsResult

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetLocationsResult <Firstred\\PostNL\\Entity\\Response\\GetLocationsResult>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $GetLocationsResult=null)
	
		.. rst-class:: phpdoc-description
		
			| GetNearestLocationsResponse constructor\.
			
		
		
		:Parameters:
			* **$GetLocationsResult** (:any:`Firstred\\PostNL\\Entity\\Response\\GetLocationsResult <Firstred\\PostNL\\Entity\\Response\\GetLocationsResult>` | null)  

		
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: mixed | :any:`\\stdClass <stdClass>` | null 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`\.
			
		
		
		:Returns: array 
	
	

