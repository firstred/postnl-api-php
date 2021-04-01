.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


PendingPromise
==============


.. php:namespace:: Firstred\PostNL\Util

.. php:class:: PendingPromise


	.. rst-class:: phpdoc-description
	
		| Promises/A\+ implementation that avoids recursion when possible\.
		
	
	:Implements:
		:php:interface:`Http\\Promise\\Promise` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($waitFn, $cancelFn\)<Firstred\\PostNL\\Util\\PendingPromise::\_\_construct\(\)>`
* :php:meth:`public then\($onFulfilled, $onRejected\)<Firstred\\PostNL\\Util\\PendingPromise::then\(\)>`
* :php:meth:`public otherwise\($onRejected\)<Firstred\\PostNL\\Util\\PendingPromise::otherwise\(\)>`
* :php:meth:`public wait\($unwrap\)<Firstred\\PostNL\\Util\\PendingPromise::wait\(\)>`
* :php:meth:`public getState\(\)<Firstred\\PostNL\\Util\\PendingPromise::getState\(\)>`
* :php:meth:`public cancel\(\)<Firstred\\PostNL\\Util\\PendingPromise::cancel\(\)>`
* :php:meth:`public resolve\($value\)<Firstred\\PostNL\\Util\\PendingPromise::resolve\(\)>`
* :php:meth:`public reject\($reason\)<Firstred\\PostNL\\Util\\PendingPromise::reject\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $waitFn=null, $cancelFn=null)
	
		
		:Parameters:
			* **$waitFn** (callable)  fn that when invoked resolves the promise
			* **$cancelFn** (callable)  fn that when invoked cancels the promise

		
	
	

.. rst-class:: public

	.. php:method:: public then( $onFulfilled=null, $onRejected=null)
	
		
		:Parameters:
			* **$onFulfilled** (callable | null)  
			* **$onRejected** (callable | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Util\\PendingPromise <Firstred\\PostNL\\Util\\PendingPromise>` | :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public

	.. php:method:: public otherwise( $onRejected)
	
		
		:Parameters:
			* **$onRejected** (callable)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Util\\PendingPromise <Firstred\\PostNL\\Util\\PendingPromise>` | :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public

	.. php:method:: public wait( $unwrap=true)
	
		
		:Parameters:
			* **$unwrap** (bool)  

		
		:Returns: mixed | void 
		:Throws: :any:`\\Exception <Exception>` 
	
	

.. rst-class:: public

	.. php:method:: public getState()
	
		
		:Returns: string 
	
	

.. rst-class:: public

	.. php:method:: public cancel()
	
		
		:Returns: void 
	
	

.. rst-class:: public

	.. php:method:: public resolve( $value)
	
		
		:Parameters:
			* **$value** (mixed)  

		
	
	

.. rst-class:: public

	.. php:method:: public reject( $reason)
	
		
		:Parameters:
			* **$reason** (mixed)  

		
	
	

