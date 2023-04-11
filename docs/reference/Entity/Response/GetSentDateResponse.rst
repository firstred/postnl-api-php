.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSentDateResponse
===================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetSentDateResponse


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GetSentDate, $Options\)<Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse::\_\_construct\(\)>`
* :php:meth:`public setSentDate\($SentDate\)<Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse::setSentDate\(\)>`
* :php:meth:`public getOptions\(\)<Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse::getOptions\(\)>`
* :php:meth:`public setOptions\($Options\)<Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse::setOptions\(\)>`
* :php:meth:`public getSentDate\(\)<Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse::getSentDate\(\)>`


Properties
----------

.. php:attr:: protected static SentDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $GetSentDate=null, $Options=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setSentDate(string|\\DateTimeInterface|null $SentDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getOptions()
	
		
		:Returns: string[] | null 
	
	

.. rst-class:: public

	.. php:method:: public setOptions( $Options)
	
		
		:Parameters:
			* **$Options** (string[] | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getSentDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

