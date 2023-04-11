.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetTimeframes
=============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetTimeframes


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Cache\\CacheableRequestEntityInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Message, $Timeframes\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::\_\_construct\(\)>`
* :php:meth:`public setTimeframe\($timeframes\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::setTimeframe\(\)>`
* :php:meth:`public setTimeframes\($timeframes\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::setTimeframes\(\)>`
* :php:meth:`public getTimeframe\(\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::getTimeframe\(\)>`
* :php:meth:`public getTimeframes\(\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::getTimeframes\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::setMessage\(\)>`
* :php:meth:`public getCacheKey\(\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::getCacheKey\(\)>`


Properties
----------

.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static Timeframe

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Message=null, $Timeframes=null)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  
			* **$Timeframes** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setTimeframe( $timeframes)
	
		
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setTimeframes(\\Firstred\\PostNL\\Entity\\Timeframe|array|null $timeframes)
	
		
		:Parameters:
			* **$timeframes**  TimeFrame|Timeframe[]|null

		
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframe()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframes()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCacheKey()
	
		.. rst-class:: phpdoc-description
		
			| This method returns a unique cache key for every unique cacheable request as defined by PSR\-6\.
			
		
		
		:See: :any:`https://www\.php\-fig\.org/psr/psr\-6/\#definitions <https://www\.php\-fig\.org/psr/psr\-6/\#definitions>` 
		:Returns: string 
	
	

