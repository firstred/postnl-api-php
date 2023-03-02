.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Message
=======


.. php:namespace:: Firstred\PostNL\Entity\Message

.. php:class:: Message


	.. rst-class:: phpdoc-description
	
		| Class Message\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($MessageID, $MessageTimeStamp\)<Firstred\\PostNL\\Entity\\Message\\Message::\_\_construct\(\)>`
* :php:meth:`public setMessageTimeStamp\($MessageTimeStamp\)<Firstred\\PostNL\\Entity\\Message\\Message::setMessageTimeStamp\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static MessageID

	:Type: string | null 


.. php:attr:: protected static MessageTimeStamp

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $MessageID=null, $MessageTimeStamp=null)
	
		
		:Parameters:
			* **$MessageID** (string | null)  
			* **$MessageTimeStamp** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setMessageTimeStamp( $MessageTimeStamp=null)
	
		
		:Parameters:
			* **$MessageTimeStamp** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

