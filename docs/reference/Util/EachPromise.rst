.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


EachPromise
===========


.. php:namespace:: Firstred\PostNL\Util

.. php:class:: EachPromise


	.. rst-class:: phpdoc-description
	
		| Represents a promise that iterates over many promises and invokes
		| side\-effect functions in the process\.
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($iterable, $config\)<Firstred\\PostNL\\Util\\EachPromise::\_\_construct\(\)>`
* :php:meth:`public promise\(\)<Firstred\\PostNL\\Util\\EachPromise::promise\(\)>`


Constants
---------

.. php:const:: PENDING = \'pending\'



.. php:const:: FULFILLED = \'fulfilled\'



.. php:const:: REJECTED = \'rejected\'



Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $iterable, $config=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Configuration hash can include the following key value pairs:\.
			
			| \- fulfilled: \(callable\) Invoked when a promise fulfills\. The function
			|   is invoked with three arguments: the fulfillment value, the index
			|   position from the iterable list of the promise, and the aggregate
			|   promise that manages all of the promises\. The aggregate promise may
			|   be resolved from within the callback to short\-circuit the promise\.
			| \- rejected: \(callable\) Invoked when a promise is rejected\. The
			|   function is invoked with three arguments: the rejection reason, the
			|   index position from the iterable list of the promise, and the
			|   aggregate promise that manages all of the promises\. The aggregate
			|   promise may be resolved from within the callback to short\-circuit
			|   the promise\.
			| \- concurrency: \(integer\) Pass this configuration option to limit the
			|   allowed number of outstanding concurrently executing promises,
			|   creating a capped pool of promises\. There is no limit by default\.
			
		
		
		:Parameters:
			* **$iterable** (mixed)  promises or values to iterate
			* **$config** (array)  Configuration options

		
	
	

.. rst-class:: public

	.. php:method:: public promise()
	
		
		:Returns: :any:`\\Http\\Promise\\Promise <Http\\Promise\\Promise>` 
	
	

