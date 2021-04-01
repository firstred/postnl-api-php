.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetLocationsResult
==================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetLocationsResult


	.. rst-class:: phpdoc-description
	
		| Class GetLocationsResult\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($ResponseLocation\)<Firstred\\PostNL\\Entity\\Response\\GetLocationsResult::\_\_construct\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Response\\GetLocationsResult::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static ResponseLocation

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Response\\ResponseLocation\[\] <Firstred\\PostNL\\Entity\\Response\\ResponseLocation>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $ResponseLocation=null)
	
		.. rst-class:: phpdoc-description
		
			| GetLocationsResult constructor\.
			
		
		
		:Parameters:
			* **$ResponseLocation** (:any:`Firstred\\PostNL\\Entity\\Response\\ResponseLocation\[\] <Firstred\\PostNL\\Entity\\Response\\ResponseLocation>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

