.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Label
=====


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Label


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Content, $OutputType, $Labeltype\)<Firstred\\PostNL\\Entity\\Label::\_\_construct\(\)>`
* :php:meth:`public getContent\(\)<Firstred\\PostNL\\Entity\\Label::getContent\(\)>`
* :php:meth:`public setContent\($Content\)<Firstred\\PostNL\\Entity\\Label::setContent\(\)>`
* :php:meth:`public getOutputType\(\)<Firstred\\PostNL\\Entity\\Label::getOutputType\(\)>`
* :php:meth:`public setOutputType\($OutputType\)<Firstred\\PostNL\\Entity\\Label::setOutputType\(\)>`
* :php:meth:`public getContenttype\(\)<Firstred\\PostNL\\Entity\\Label::getContenttype\(\)>`
* :php:meth:`public setContenttype\($Contenttype\)<Firstred\\PostNL\\Entity\\Label::setContenttype\(\)>`
* :php:meth:`public getLabeltype\(\)<Firstred\\PostNL\\Entity\\Label::getLabeltype\(\)>`
* :php:meth:`public setLabeltype\($Labeltype\)<Firstred\\PostNL\\Entity\\Label::setLabeltype\(\)>`


Constants
---------

.. php:const:: FORMAT_A4 = 1



.. php:const:: FORMAT_A6 = 2



Properties
----------

.. php:attr:: protected static Content

	.. rst-class:: phpdoc-description
	
		| Base 64 encoded content\.
		
	
	:Type: string | null 


.. php:attr:: protected static OutputType

	:Type: string | null 


.. php:attr:: protected static Labeltype

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Content=null, $OutputType=null, $Labeltype=null)
	
		
		:Parameters:
			* **$Content** (string | null)  
			* **$OutputType** (string | null)  
			* **$Labeltype** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getContent()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setContent( $Content)
	
		
		:Parameters:
			* **$Content** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getOutputType()
	
		
		:Returns: string | null 
		:Since: 1.4.2 
	
	

.. rst-class:: public

	.. php:method:: public setOutputType( $OutputType)
	
		
		:Parameters:
			* **$OutputType** (string | null)  

		
		:Returns: static 
		:Since: 1.4.2 
	
	

.. rst-class:: public deprecated

	.. php:method:: public getContenttype()
	
		
		:Returns: string | null 
		:Deprecated: 1.4.2 
	
	

.. rst-class:: public deprecated

	.. php:method:: public setContenttype( $Contenttype)
	
		
		:Parameters:
			* **$Contenttype** (string | null)  

		
		:Returns: static 
		:Deprecated: 1.4.2 
	
	

.. rst-class:: public

	.. php:method:: public getLabeltype()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setLabeltype( $Labeltype)
	
		
		:Parameters:
			* **$Labeltype** (string | null)  

		
		:Returns: static 
	
	

