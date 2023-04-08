.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LabellingMessage
================


.. php:namespace:: Firstred\PostNL\Entity\Message

.. php:class:: LabellingMessage


	.. rst-class:: phpdoc-description
	
		| Class LabellingMessage\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\Message\\Message`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Printertype, $MessageID, $MessageTimeStamp\)<Firstred\\PostNL\\Entity\\Message\\LabellingMessage::\_\_construct\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static Printertype

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Printertype=\'GraphicFile\|PDF\', $MessageID=null, $MessageTimeStamp=null)
	
		.. rst-class:: phpdoc-description
		
			| LabellingMessage constructor\.
			
		
		
		:Parameters:
			* **$Printertype** (string | null)  
			* **$MessageID** (string | null)  
			* **$MessageTimeStamp** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidMessageTimeStampException <Firstred\\PostNL\\Exception\\InvalidMessageTimeStampException>` 
	
	

