.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Message
=======


.. php:namespace:: Firstred\PostNL\Entity\Message

.. php:class:: Message


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($MessageID, $MessageTimeStamp\)<Firstred\\PostNL\\Entity\\Message\\Message::\_\_construct\(\)>`
* :php:meth:`public getMessageID\(\)<Firstred\\PostNL\\Entity\\Message\\Message::getMessageID\(\)>`
* :php:meth:`public setMessageID\($MessageID\)<Firstred\\PostNL\\Entity\\Message\\Message::setMessageID\(\)>`
* :php:meth:`public getMessageTimeStamp\(\)<Firstred\\PostNL\\Entity\\Message\\Message::getMessageTimeStamp\(\)>`
* :php:meth:`public setMessageTimeStamp\($MessageTimeStamp\)<Firstred\\PostNL\\Entity\\Message\\Message::setMessageTimeStamp\(\)>`


Properties
----------

.. php:attr:: protected static MessageID

	:Type: string | null 


.. php:attr:: protected static MessageTimeStamp

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $MessageID=null, string|\\DateTimeInterface|null $MessageTimeStamp=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getMessageID()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessageID( $MessageID)
	
		
		:Parameters:
			* **$MessageID** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMessageTimeStamp()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessageTimeStamp(string|\\DateTimeInterface|null $MessageTimeStamp=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

