.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


DummyLogger
===========


.. php:namespace:: Firstred\PostNL\Util

.. php:class:: DummyLogger


	.. rst-class:: phpdoc-description
	
		| Class DummyLogger\.
		
	
	:Implements:
		:php:interface:`Psr\\Log\\LoggerInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public emergency\($message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::emergency\(\)>`
* :php:meth:`public alert\($message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::alert\(\)>`
* :php:meth:`public critical\($message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::critical\(\)>`
* :php:meth:`public error\($message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::error\(\)>`
* :php:meth:`public warning\($message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::warning\(\)>`
* :php:meth:`public notice\($message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::notice\(\)>`
* :php:meth:`public info\($message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::info\(\)>`
* :php:meth:`public debug\($message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::debug\(\)>`
* :php:meth:`public log\($level, $message, $context\)<Firstred\\PostNL\\Util\\DummyLogger::log\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public emergency(string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| System is unusable\.
			
		
		
		:Parameters:
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public alert(string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Action must be taken immediately\.
			
			| Example: Entire website down, database unavailable, etc\. This should
			| trigger the SMS alerts and wake you up\.
			
		
		
		:Parameters:
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public critical(string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Critical conditions\.
			
			| Example: Application component unavailable, unexpected exception\.
			
		
		
		:Parameters:
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public error(string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Runtime errors that do not require immediate action but should typically
			| be logged and monitored\.
			
		
		
		:Parameters:
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public warning(string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Exceptional occurrences that are not errors\.
			
			| Example: Use of deprecated APIs, poor use of an API, undesirable things
			| that are not necessarily wrong\.
			
		
		
		:Parameters:
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public notice(string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Normal but significant events\.
			
		
		
		:Parameters:
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public info(string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Interesting events\.
			
			| Example: User logs in, SQL logs\.
			
		
		
		:Parameters:
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public debug(string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Detailed debug information\.
			
		
		
		:Parameters:
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public log( $level, string|\\Stringable $message, $context=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Logs with an arbitrary level\.
			
		
		
		:Parameters:
			* **$level** (mixed)  
			* **$message** (string | :any:`\\Stringable <Stringable>`)  
			* **$context** (array)  

		
		:Returns: void 
		:Throws: :any:`\\Psr\\Log\\InvalidArgumentException <Psr\\Log\\InvalidArgumentException>` 
	
	

