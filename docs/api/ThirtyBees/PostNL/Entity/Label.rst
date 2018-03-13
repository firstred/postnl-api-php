.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Label
=====


.. php:namespace:: ThirtyBees\PostNL\Entity

.. php:class:: Label


	.. rst-class:: phpdoc-description
	
		| Class Label
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

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

	.. php:method:: public __construct( $content=null, $contentType=null, $labelType=null)
	
		
		:Parameters:
			* **$content** (string | null)  
			* **$contentType** (string | null)  
			* **$labelType** (string | null)  

		
	
	

