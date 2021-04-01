.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseTimeframes
==================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: ResponseTimeframes


	.. rst-class:: phpdoc-description
	
		| Class ResponseTimeframes\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($ReasonNoTimeframes, $Timeframes\)<Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes::\_\_construct\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: array 


.. php:attr:: protected static ReasonNoTimeframes

	:Type: :any:`\\Firstred\\PostNL\\Entity\\ReasonNoTimeframe\[\] <Firstred\\PostNL\\Entity\\ReasonNoTimeframe>` | null 


.. php:attr:: protected static Timeframes

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $ReasonNoTimeframes=null, $Timeframes=null)
	
		
		:Parameters:
			* **$ReasonNoTimeframes** (:any:`Firstred\\PostNL\\Entity\\ReasonNoTimeframe\[\] <Firstred\\PostNL\\Entity\\ReasonNoTimeframe>` | null)  
			* **$Timeframes** (:any:`Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`\.
			
		
		
		:Returns: array 
	
	

