.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


PromiseTool
===========


.. php:namespace:: Firstred\PostNL\Util

.. php:class:: PromiseTool


	.. rst-class:: phpdoc-description
	
		| Class PromiseTool\.
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public static queue\($assign\)<Firstred\\PostNL\\Util\\PromiseTool::queue\(\)>`
* :php:meth:`public static task\($task\)<Firstred\\PostNL\\Util\\PromiseTool::task\(\)>`
* :php:meth:`public static promiseFor\($value\)<Firstred\\PostNL\\Util\\PromiseTool::promiseFor\(\)>`
* :php:meth:`public static rejectionFor\($reason\)<Firstred\\PostNL\\Util\\PromiseTool::rejectionFor\(\)>`
* :php:meth:`public static exceptionFor\($reason\)<Firstred\\PostNL\\Util\\PromiseTool::exceptionFor\(\)>`
* :php:meth:`public static iterFor\($value\)<Firstred\\PostNL\\Util\\PromiseTool::iterFor\(\)>`
* :php:meth:`public static inspect\($promise\)<Firstred\\PostNL\\Util\\PromiseTool::inspect\(\)>`
* :php:meth:`public static inspectAll\($promises\)<Firstred\\PostNL\\Util\\PromiseTool::inspectAll\(\)>`
* :php:meth:`public static unwrap\($promises\)<Firstred\\PostNL\\Util\\PromiseTool::unwrap\(\)>`
* :php:meth:`public static all\($promises, $recursive\)<Firstred\\PostNL\\Util\\PromiseTool::all\(\)>`
* :php:meth:`public static some\($count, $promises\)<Firstred\\PostNL\\Util\\PromiseTool::some\(\)>`
* :php:meth:`public static any\($promises\)<Firstred\\PostNL\\Util\\PromiseTool::any\(\)>`
* :php:meth:`public static settle\($promises\)<Firstred\\PostNL\\Util\\PromiseTool::settle\(\)>`
* :php:meth:`public static each\($iterable, $onFulfilled, $onRejected\)<Firstred\\PostNL\\Util\\PromiseTool::each\(\)>`
* :php:meth:`public static eachLimit\($iterable, $concurrency, $onFulfilled, $onRejected\)<Firstred\\PostNL\\Util\\PromiseTool::eachLimit\(\)>`
* :php:meth:`public static eachLimitAll\($iterable, $concurrency, $onFulfilled\)<Firstred\\PostNL\\Util\\PromiseTool::eachLimitAll\(\)>`
* :php:meth:`public static isFulfilled\($promise\)<Firstred\\PostNL\\Util\\PromiseTool::isFulfilled\(\)>`
* :php:meth:`public static isRejected\($promise\)<Firstred\\PostNL\\Util\\PromiseTool::isRejected\(\)>`
* :php:meth:`public static isSettled\($promise\)<Firstred\\PostNL\\Util\\PromiseTool::isSettled\(\)>`


Methods
-------

.. rst-class:: public static

	.. php:method:: public static queue( $assign=null)
	
		.. rst-class:: phpdoc-description
		
			| Get the global task queue used for promise resolution\.
			
			| This task queue MUST be run in an event loop in order for promises to be
			| settled asynchronously\. It will be automatically run when synchronously
			| waiting on a promise\.
			| 
			| <code\>
			| while \($eventLoop\-\>isRunning\(\)\) \{
			|     queue\(\)\-\>run\(\);
			| \}
			| </code\>
			
		
		
		:Parameters:
			* **$assign** (:any:`Firstred\\PostNL\\Util\\TaskQueue <Firstred\\PostNL\\Util\\TaskQueue>`)  optionally specify a new queue instance

		
		:Returns: :any:`\\Firstred\\PostNL\\Util\\TaskQueue <Firstred\\PostNL\\Util\\TaskQueue>` 
	
	

.. rst-class:: public static

	.. php:method:: public static task( $task)
	
		.. rst-class:: phpdoc-description
		
			| Adds a function to run in the task queue when it is next \`run\(\)\` and returns
			| a promise that is fulfilled or rejected with the result\.
			
		
		
		:Parameters:
			* **$task** (callable)  task function to run

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static promiseFor( $value)
	
		.. rst-class:: phpdoc-description
		
			| Creates a promise for a value if the value is not a promise\.
			
		
		
		:Parameters:
			* **$value** (mixed)  promise or value

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static rejectionFor( $reason)
	
		.. rst-class:: phpdoc-description
		
			| Creates a rejected promise for a reason if the reason is not a promise\. If
			| the provided reason is a promise, then it is returned as\-is\.
			
		
		
		:Parameters:
			* **$reason** (mixed)  promise or reason

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static exceptionFor( $reason)
	
		.. rst-class:: phpdoc-description
		
			| Create an exception for a rejected promise value\.
			
		
		
		:Parameters:
			* **$reason** (mixed)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Util\\Throwable <Firstred\\PostNL\\Util\\Throwable>` 
	
	

.. rst-class:: public static

	.. php:method:: public static iterFor( $value)
	
		.. rst-class:: phpdoc-description
		
			| Returns an iterator for the given value\.
			
		
		
		:Parameters:
			* **$value** (mixed)  

		
		:Returns: :any:`\\Iterator <Iterator>` 
	
	

.. rst-class:: public static

	.. php:method:: public static inspect( $promise)
	
		.. rst-class:: phpdoc-description
		
			| Synchronously waits on a promise to resolve and returns an inspection state
			| array\.
			
			| Returns a state associative array containing a "state" key mapping to a
			| valid promise state\. If the state of the promise is "fulfilled", the array
			| will contain a "value" key mapping to the fulfilled value of the promise\. If
			| the promise is rejected, the array will contain a "reason" key mapping to
			| the rejection reason of the promise\.
			
		
		
		:Parameters:
			* **$promise** (:any:`Http\\Promise\\Promise <Http\\Promise\\Promise>`)  promise or value

		
		:Returns: array 
		:Throws: :any:`\\Exception <Exception>` 
	
	

.. rst-class:: public static

	.. php:method:: public static inspectAll( $promises)
	
		.. rst-class:: phpdoc-description
		
			| Waits on all of the provided promises, but does not unwrap rejected promises
			| as thrown exception\.
			
			| Returns an array of inspection state arrays\.
			
		
		
		:Parameters:
			* **$promises** (:any:`Http\\Promise\\Promise\[\] <Http\\Promise\\Promise>`)  traversable of promises to wait upon

		
		:Returns: array 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\Exception <Exception>` 
	
	

.. rst-class:: public static

	.. php:method:: public static unwrap( $promises)
	
		.. rst-class:: phpdoc-description
		
			| Waits on all of the provided promises and returns the fulfilled values\.
			
			| Returns an array that contains the value of each promise \(in the same order
			| the promises were provided\)\. An exception is thrown if any of the promises
			| are rejected\.
			
		
		
		:Parameters:
			* **$promises** (mixed)  iterable of Promise objects to wait on

		
		:Returns: array 
		:Throws: :any:`\\Exception <Exception>` on error
		:Throws: :any:`\\Firstred\\PostNL\\Util\\Throwable <Firstred\\PostNL\\Util\\Throwable>` on error in PHP \>=7
		:Throws: :any:`\\Exception <Exception>` on error
		:Throws: :any:`\\Firstred\\PostNL\\Util\\Throwable <Firstred\\PostNL\\Util\\Throwable>` on error in PHP \>=7
	
	

.. rst-class:: public static

	.. php:method:: public static all( $promises, $recursive=false)
	
		.. rst-class:: phpdoc-description
		
			| Given an array of promises, return a promise that is fulfilled when all the
			| items in the array are fulfilled\.
			
			| The promise\'s fulfillment value is an array with fulfillment values at
			| respective positions to the original array\. If any promise in the array
			| rejects, the returned promise is rejected with the rejection reason\.
			
		
		
		:Parameters:
			* **$promises** (mixed)  promises or values
			* **$recursive** (bool)  - If true, resolves new promises that might have been added to the stack during its own resolution

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static some( $count, $promises)
	
		.. rst-class:: phpdoc-description
		
			| Initiate a competitive race between multiple promises or values \(values will
			| become immediately fulfilled promises\)\.
			
			| When count amount of promises have been fulfilled, the returned promise is
			| fulfilled with an array that contains the fulfillment values of the winners
			| in order of resolution\.
			
		
		
		:Parameters:
			* **$count** (int)  total number of promises
			* **$promises** (mixed)  promises or values

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static any( $promises)
	
		.. rst-class:: phpdoc-description
		
			| Like some\(\), with 1 as count\. However, if the promise fulfills, the
			| fulfillment value is not an array of 1 but the value directly\.
			
		
		
		:Parameters:
			* **$promises** (mixed)  promises or values

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static settle( $promises)
	
		.. rst-class:: phpdoc-description
		
			| Returns a promise that is fulfilled when all of the provided promises have
			| been fulfilled or rejected\.
			
			| The returned promise is fulfilled with an array of inspection state arrays\.
			
		
		
		:Parameters:
			* **$promises** (mixed)  promises or values

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static each( $iterable, $onFulfilled=null, $onRejected=null)
	
		.. rst-class:: phpdoc-description
		
			| Given an iterator that yields promises or values, returns a promise that is
			| fulfilled with a null value when the iterator has been consumed or the
			| aggregate promise has been fulfilled or rejected\.
			
			| $onFulfilled is a function that accepts the fulfilled value, iterator
			| index, and the aggregate promise\. The callback can invoke any necessary side
			| effects and choose to resolve or reject the aggregate promise if needed\.
			| 
			| $onRejected is a function that accepts the rejection reason, iterator
			| index, and the aggregate promise\. The callback can invoke any necessary side
			| effects and choose to resolve or reject the aggregate promise if needed\.
			
		
		
		:Parameters:
			* **$iterable** (mixed)  iterator or array to iterate over
			* **$onFulfilled** (callable)  
			* **$onRejected** (callable)  

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static eachLimit( $iterable, $concurrency, $onFulfilled=null, $onRejected=null)
	
		.. rst-class:: phpdoc-description
		
			| Like each, but only allows a certain number of outstanding promises at any
			| given time\.
			
			| $concurrency may be an integer or a function that accepts the number of
			| pending promises and returns a numeric concurrency limit value to allow for
			| dynamic a concurrency size\.
			
		
		
		:Parameters:
			* **$iterable** (mixed)  
			* **$concurrency** (int | callable)  
			* **$onFulfilled** (callable)  
			* **$onRejected** (callable)  

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static eachLimitAll( $iterable, $concurrency, $onFulfilled=null)
	
		.. rst-class:: phpdoc-description
		
			| Like each\_limit, but ensures that no promise in the given $iterable argument
			| is rejected\. If any promise is rejected, then the aggregate promise is
			| rejected with the encountered rejection\.
			
		
		
		:Parameters:
			* **$iterable** (mixed)  
			* **$concurrency** (int | callable)  
			* **$onFulfilled** (callable)  

		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

.. rst-class:: public static

	.. php:method:: public static isFulfilled( $promise)
	
		.. rst-class:: phpdoc-description
		
			| Returns true if a promise is fulfilled\.
			
		
		
		:Parameters:
			* **$promise** (:any:`Http\\Promise\\Promise <Http\\Promise\\Promise>`)  

		
		:Returns: bool 
	
	

.. rst-class:: public static

	.. php:method:: public static isRejected( $promise)
	
		.. rst-class:: phpdoc-description
		
			| Returns true if a promise is rejected\.
			
		
		
		:Parameters:
			* **$promise** (:any:`Http\\Promise\\Promise <Http\\Promise\\Promise>`)  

		
		:Returns: bool 
	
	

.. rst-class:: public static

	.. php:method:: public static isSettled( $promise)
	
		.. rst-class:: phpdoc-description
		
			| Returns true if a promise is fulfilled or rejected\.
			
		
		
		:Parameters:
			* **$promise** (:any:`Http\\Promise\\Promise <Http\\Promise\\Promise>`)  

		
		:Returns: bool 
	
	

