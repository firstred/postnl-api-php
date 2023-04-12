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
* :php:meth:`public getContenttype\(\)<Firstred\\PostNL\\Entity\\Label::getContenttype\(\)>`
* :php:meth:`public setContenttype\($Contenttype\)<Firstred\\PostNL\\Entity\\Label::setContenttype\(\)>`


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


.. php:attr:: protected static OutputType

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

		
	
	

.. rst-class:: public deprecated

	.. php:method:: public getContenttype()
	
		
		:Returns: string | null 
		:Deprecated: 1.4.2 Use \`getOutputType\` instead
	
	

.. rst-class:: public deprecated

	.. php:method:: public setContenttype( $Contenttype)
	
		
		:Parameters:
			* **$Contenttype** (string | null)  

		
		:Returns: static 
		:Deprecated: 1.4.2 Use \`getOutputType\` instead
	
	

