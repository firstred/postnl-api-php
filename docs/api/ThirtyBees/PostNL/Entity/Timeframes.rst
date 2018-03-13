.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Timeframes
==========


.. php:namespace:: ThirtyBees\PostNL\Entity

.. php:class:: Timeframes


	.. rst-class:: phpdoc-description
	
		| Class Timeframes
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Timeframes

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Timeframe\[\] <ThirtyBees\\PostNL\\Entity\\Timeframe>` | null 


.. php:attr:: protected static TimeframeTimeFrames

	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame\[\] <ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $timeframes=null, $timeframetimeframes=null)
	
		.. rst-class:: phpdoc-description
		
			| Timeframes constructor\.
			
		
		
		:Parameters:
			* **$timeframes** (array | null)  
			* **$timeframetimeframes** (:any:`ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame\[\] <ThirtyBees\\PostNL\\Entity\\TimeframeTimeFrame>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`
			
		
		
		:Returns: array 
	
	

