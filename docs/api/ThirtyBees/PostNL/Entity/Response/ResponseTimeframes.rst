.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseTimeframes
==================


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: ResponseTimeframes


	.. rst-class:: phpdoc-description
	
		| Class ResponseTimeframes
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: array 


.. php:attr:: protected static ReasonNoTimeframes

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\ReasonNoTimeframe\[\] <ThirtyBees\\PostNL\\Entity\\ReasonNoTimeframe>` | null 


.. php:attr:: protected static Timeframes

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Timeframe\[\] <ThirtyBees\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $noTimeframes=null, $timeframes=null)
	
		
		:Parameters:
			* **$noTimeframes** (:any:`ThirtyBees\\PostNL\\Entity\\ReasonNoTimeframe\[\] <ThirtyBees\\PostNL\\Entity\\ReasonNoTimeframe>` | null)  
			* **$timeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Timeframe\[\] <ThirtyBees\\PostNL\\Entity\\Timeframe>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`
			
		
		
		:Returns: array 
	
	

