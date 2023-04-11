.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LabellingMessage
================


.. php:namespace:: Firstred\PostNL\Entity\Message

.. php:class:: LabellingMessage


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\Message\\Message`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Printertype, $MessageID, $MessageTimeStamp\)<Firstred\\PostNL\\Entity\\Message\\LabellingMessage::\_\_construct\(\)>`
* :php:meth:`public getPrintertype\(\)<Firstred\\PostNL\\Entity\\Message\\LabellingMessage::getPrintertype\(\)>`
* :php:meth:`public setPrintertype\($Printertype\)<Firstred\\PostNL\\Entity\\Message\\LabellingMessage::setPrintertype\(\)>`


Properties
----------

.. php:attr:: protected static Printertype

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Printertype=\'GraphicFile\|PDF\', $MessageID=null, string|\\DateTimeInterface|null $MessageTimeStamp=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getPrintertype()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setPrintertype( $Printertype)
	
		
		:Parameters:
			* **$Printertype** (string | null)  

		
		:Returns: static 
	
	

