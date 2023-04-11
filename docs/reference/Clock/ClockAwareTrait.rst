.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ClockAwareTrait
===============


.. php:namespace:: Firstred\PostNL\Clock

.. php:trait:: ClockAwareTrait



Properties
----------

.. php:attr:: private static clock



Methods
-------

.. rst-class:: public

	.. php:method:: public getClock()
	
		.. rst-class:: phpdoc-description
		
			| Get the current clock\.
			
		
		
		:Returns: :any:`\\Psr\\Clock\\ClockInterface <Psr\\Clock\\ClockInterface>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setClock( $clock)
	
		.. rst-class:: phpdoc-description
		
			| Set the current clock\.
			
		
		
		:Parameters:
			* **$clock** (:any:`Psr\\Clock\\ClockInterface <Psr\\Clock\\ClockInterface>`)  

		
		:Returns: void 
		:Since: 2.0.0 
	
	

