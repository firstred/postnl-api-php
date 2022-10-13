.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TaskQueue
=========


.. php:namespace:: Firstred\PostNL\Util

.. php:class:: TaskQueue


	.. rst-class:: phpdoc-description
	
		| A task queue that executes tasks in a FIFO order\.
		
		| This task queue class is used to settle promises asynchronously and
		| maintains a constant stack size\. You can use the task queue asynchronously
		| by calling the \`run\(\)\` function of the global task queue in an event loop\.
		| 
		| queue\(\)\-\>run\(\);
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($withShutdown\)<Firstred\\PostNL\\Util\\TaskQueue::\_\_construct\(\)>`
* :php:meth:`public isEmpty\(\)<Firstred\\PostNL\\Util\\TaskQueue::isEmpty\(\)>`
* :php:meth:`public add\($task\)<Firstred\\PostNL\\Util\\TaskQueue::add\(\)>`
* :php:meth:`public run\(\)<Firstred\\PostNL\\Util\\TaskQueue::run\(\)>`
* :php:meth:`public disableShutdown\(\)<Firstred\\PostNL\\Util\\TaskQueue::disableShutdown\(\)>`


Properties
----------

.. php:attr:: private static enableShutdown



.. php:attr:: private static queue



Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $withShutdown=true)
	
		.. rst-class:: phpdoc-description
		
			| TaskQueue constructor\.
			
		
		
		:Parameters:
			* **$withShutdown** (bool)  

		
	
	

.. rst-class:: public

	.. php:method:: public isEmpty()
	
		
		:Returns: bool 
	
	

.. rst-class:: public

	.. php:method:: public add( $task)
	
		
		:Parameters:
			* **$task** (callable)  

		
	
	

.. rst-class:: public

	.. php:method:: public run()
	
		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public disableShutdown()
	
		.. rst-class:: phpdoc-description
		
			| The task queue will be run and exhausted by default when the process
			| exits IFF the exit is not the result of a PHP E\_ERROR error\.
			
			| You can disable running the automatic shutdown of the queue by calling
			| this function\. If you disable the task queue shutdown process, then you
			| MUST either run the task queue \(as a result of running your event loop
			| or manually using the run\(\) method\) or wait on each outstanding promise\.
			| 
			| Note: This shutdown will occur before any destructors are triggered\.
			
		
		
	
	

