.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseTimeframes
==================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: ResponseTimeframes


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($ReasonNoTimeframes, $Timeframes\)<Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes::\_\_construct\(\)>`
* :php:meth:`public getReasonNoTimeframes\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes::getReasonNoTimeframes\(\)>`
* :php:meth:`public setReasonNoTimeframes\($ReasonNoTimeframes\)<Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes::setReasonNoTimeframes\(\)>`
* :php:meth:`public getTimeframes\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes::getTimeframes\(\)>`
* :php:meth:`public setTimeframes\($Timeframes\)<Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes::setTimeframes\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes::jsonSerialize\(\)>`


Properties
----------

.. php:attr:: protected static ReasonNoTimeframes

	:Type: :any:`\\Firstred\\PostNL\\Entity\\ReasonNoTimeframe\[\] <Firstred\\PostNL\\Entity\\ReasonNoTimeframe>` | null 


.. php:attr:: protected static Timeframes

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $ReasonNoTimeframes=null, $Timeframes=null)
	
		
		:Parameters:
			* **$ReasonNoTimeframes** (array | null)  
			* **$Timeframes** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getReasonNoTimeframes()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\ReasonNoTimeframe\[\] <Firstred\\PostNL\\Entity\\ReasonNoTimeframe>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setReasonNoTimeframes( $ReasonNoTimeframes)
	
		
		:Parameters:
			* **$ReasonNoTimeframes** (:any:`Firstred\\PostNL\\Entity\\ReasonNoTimeframe\[\] <Firstred\\PostNL\\Entity\\ReasonNoTimeframe>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframes()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setTimeframes( $Timeframes)
	
		
		:Parameters:
			* **$Timeframes** (:any:`Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		
		:Returns: array 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ServiceNotSetException <Firstred\\PostNL\\Exception\\ServiceNotSetException>` 
	
	

