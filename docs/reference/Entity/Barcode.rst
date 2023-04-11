.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Barcode
=======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Barcode


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Type, $Range, $Serie\)<Firstred\\PostNL\\Entity\\Barcode::\_\_construct\(\)>`
* :php:meth:`public getType\(\)<Firstred\\PostNL\\Entity\\Barcode::getType\(\)>`
* :php:meth:`public setType\($Type\)<Firstred\\PostNL\\Entity\\Barcode::setType\(\)>`
* :php:meth:`public getRange\(\)<Firstred\\PostNL\\Entity\\Barcode::getRange\(\)>`
* :php:meth:`public setRange\($Range\)<Firstred\\PostNL\\Entity\\Barcode::setRange\(\)>`
* :php:meth:`public getSerie\(\)<Firstred\\PostNL\\Entity\\Barcode::getSerie\(\)>`
* :php:meth:`public setSerie\($Serie\)<Firstred\\PostNL\\Entity\\Barcode::setSerie\(\)>`


Properties
----------

.. php:attr:: protected static Type

	:Type: string | null 


.. php:attr:: protected static Range

	:Type: string | null 


.. php:attr:: protected static Serie

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Type=null, $Range=null, $Serie=\'000000000\-999999999\')
	
		
		:Parameters:
			* **$Type** (string | null)  
			* **$Range** (string | null)  
			* **$Serie** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getType()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setType( $Type)
	
		
		:Parameters:
			* **$Type** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getRange()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setRange( $Range)
	
		
		:Parameters:
			* **$Range** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getSerie()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setSerie( $Serie)
	
		
		:Parameters:
			* **$Serie** (string | null)  

		
		:Returns: static 
	
	

