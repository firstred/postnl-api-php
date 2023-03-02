.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetTimeframes
=============


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetTimeframes


	.. rst-class:: phpdoc-description
	
		| Class GetTimeframes\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Message, $Timeframes\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::\_\_construct\(\)>`
* :php:meth:`public setTimeframe\($timeframes\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::setTimeframe\(\)>`
* :php:meth:`public setTimeframes\($timeframes\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::setTimeframes\(\)>`
* :php:meth:`public getTimeframe\(\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::getTimeframe\(\)>`
* :php:meth:`public getTimeframes\(\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::getTimeframes\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Request\\GetTimeframes::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


.. php:attr:: protected static Timeframe

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Message=null, $Timeframes=null)
	
		.. rst-class:: phpdoc-description
		
			| GetTimeframes constructor\.
			
		
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  
			* **$Timeframes** (:any:`Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public setTimeframe( $timeframes)
	
		.. rst-class:: phpdoc-description
		
			| Set timeframes
			
		
		
		:Parameters:
			* **$timeframes** (:any:`Firstred\\PostNL\\Entity\\Timeframe <Firstred\\PostNL\\Entity\\Timeframe>` | :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null)  

		
		:Returns: $this 
		:Since: 1.0.0 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setTimeframes( $timeframes)
	
		.. rst-class:: phpdoc-description
		
			| Set timeframes
			
		
		
		:Parameters:
			* **$timeframes** (:any:`Firstred\\PostNL\\Entity\\Timeframe <Firstred\\PostNL\\Entity\\Timeframe>` | :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null)  

		
		:Returns: $this 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframe()
	
		.. rst-class:: phpdoc-description
		
			| Get timeframes
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframes()
	
		.. rst-class:: phpdoc-description
		
			| Get timeframes
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Timeframe\[\] <Firstred\\PostNL\\Entity\\Timeframe>` | null 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

