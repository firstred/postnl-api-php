.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AggregateException
==================


.. php:namespace:: Firstred\PostNL\Exception\Promise

.. php:class:: AggregateException


	.. rst-class:: phpdoc-description
	
		| Exception thrown when too many errors occur in the some\(\) or any\(\) methods\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Exception\\Promise\\RejectionException`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($msg, $reasons\)<Firstred\\PostNL\\Exception\\Promise\\AggregateException::\_\_construct\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $msg, $reasons)
	
		.. rst-class:: phpdoc-description
		
			| AggregateException constructor\.
			
		
		
		:Parameters:
			* **$msg** (mixed)  
			* **$reasons** (array)  

		
	
	

