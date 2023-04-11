.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MergedLabel
===========


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: MergedLabel


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Barcodes, $Labels\)<Firstred\\PostNL\\Entity\\Response\\MergedLabel::\_\_construct\(\)>`
* :php:meth:`public getBarcodes\(\)<Firstred\\PostNL\\Entity\\Response\\MergedLabel::getBarcodes\(\)>`
* :php:meth:`public setBarcodes\($Barcodes\)<Firstred\\PostNL\\Entity\\Response\\MergedLabel::setBarcodes\(\)>`
* :php:meth:`public getLabels\(\)<Firstred\\PostNL\\Entity\\Response\\MergedLabel::getLabels\(\)>`
* :php:meth:`public setLabels\($Labels\)<Firstred\\PostNL\\Entity\\Response\\MergedLabel::setLabels\(\)>`


Properties
----------

.. php:attr:: protected static Barcodes

	:Type: string[] | null 


.. php:attr:: protected static Labels

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Label\[\] <Firstred\\PostNL\\Entity\\Label>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Barcodes=null, $Labels=null)
	
		
		:Parameters:
			* **$Barcodes** (array | null)  
			* **$Labels** (array | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getBarcodes()
	
		
		:Returns: string[] | null 
	
	

.. rst-class:: public

	.. php:method:: public setBarcodes( $Barcodes)
	
		
		:Parameters:
			* **$Barcodes** (string[] | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getLabels()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Label\[\] <Firstred\\PostNL\\Entity\\Label>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setLabels( $Labels)
	
		
		:Parameters:
			* **$Labels** (:any:`Firstred\\PostNL\\Entity\\Label\[\] <Firstred\\PostNL\\Entity\\Label>` | null)  

		
		:Returns: static 
	
	

