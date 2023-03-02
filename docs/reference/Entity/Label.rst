.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Label
=====


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Label


	.. rst-class:: phpdoc-description
	
		| Class Label\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Content, $ContentType, $Labeltype\)<Firstred\\PostNL\\Entity\\Label::\_\_construct\(\)>`


Constants
---------

.. php:const:: FORMAT_A4 = 1



.. php:const:: FORMAT_A6 = 2



Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Content

	:Type: string | null Base 64 encoded content


.. php:attr:: protected static Contenttype

	:Type: string | null 


.. php:attr:: protected static Labeltype

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Content=null, $ContentType=null, $Labeltype=null)
	
		
		:Parameters:
			* **$Content** (string | null)  
			* **$ContentType** (string | null)  
			* **$Labeltype** (string | null)  

		
	
	

