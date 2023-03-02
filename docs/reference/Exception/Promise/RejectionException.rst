.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


RejectionException
==================


.. php:namespace:: Firstred\PostNL\Exception\Promise

.. php:class:: RejectionException


	.. rst-class:: phpdoc-description
	
		| A special exception that is thrown when waiting on a rejected promise\.
		
		| The reason value is available via the getReason\(\) method\.
		
	
	:Parent:
		:php:class:`RuntimeException`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($reason, $description\)<Firstred\\PostNL\\Exception\\Promise\\RejectionException::\_\_construct\(\)>`
* :php:meth:`public getReason\(\)<Firstred\\PostNL\\Exception\\Promise\\RejectionException::getReason\(\)>`


Properties
----------

.. php:attr:: private static reason

	:Type: mixed Rejection reason\.


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $reason, $description=null)
	
		
		:Parameters:
			* **$reason** (mixed)  rejection reason
			* **$description** (string)  Optional description

		
	
	

.. rst-class:: public

	.. php:method:: public getReason()
	
		.. rst-class:: phpdoc-description
		
			| Returns the rejection reason\.
			
		
		
		:Returns: mixed 
	
	

