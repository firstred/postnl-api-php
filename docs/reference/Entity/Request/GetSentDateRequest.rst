.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSentDateRequest
==================


.. php:namespace:: Firstred\PostNL\Entity\Request

.. php:class:: GetSentDateRequest


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Cache\\CacheableRequestEntityInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GetSentDate, $Message\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::\_\_construct\(\)>`
* :php:meth:`public getGetSentDate\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::getGetSentDate\(\)>`
* :php:meth:`public setGetSentDate\($GetSentDate\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::setGetSentDate\(\)>`
* :php:meth:`public getMessage\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::getMessage\(\)>`
* :php:meth:`public setMessage\($Message\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::setMessage\(\)>`
* :php:meth:`public getCacheKey\(\)<Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest::getCacheKey\(\)>`


Properties
----------

.. php:attr:: protected static GetSentDate

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Request\\GetSentDate <Firstred\\PostNL\\Entity\\Request\\GetSentDate>` | null 


.. php:attr:: protected static Message

	:Type: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $GetSentDate=null, $Message=null)
	
		
		:Parameters:
			* **$GetSentDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSentDate <Firstred\\PostNL\\Entity\\Request\\GetSentDate>` | null)  
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getGetSentDate()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Request\\GetSentDate <Firstred\\PostNL\\Entity\\Request\\GetSentDate>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setGetSentDate( $GetSentDate)
	
		
		:Parameters:
			* **$GetSentDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSentDate <Firstred\\PostNL\\Entity\\Request\\GetSentDate>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMessage()
	
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setMessage( $Message)
	
		
		:Parameters:
			* **$Message** (:any:`Firstred\\PostNL\\Entity\\Message\\Message <Firstred\\PostNL\\Entity\\Message\\Message>` | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getCacheKey()
	
		.. rst-class:: phpdoc-description
		
			| This method returns a unique cache key for every unique cacheable request as defined by PSR\-6\.
			
		
		
		:See: :any:`https://www\.php\-fig\.org/psr/psr\-6/\#definitions <https://www\.php\-fig\.org/psr/psr\-6/\#definitions>` 
		:Returns: string 
	
	

