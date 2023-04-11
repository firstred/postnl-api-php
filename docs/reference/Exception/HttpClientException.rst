.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HttpClientException
===================


.. php:namespace:: Firstred\PostNL\Exception

.. php:class:: HttpClientException


	.. rst-class:: phpdoc-description
	
		| Class HttpClientException\.
		
		| Thrown when the HTTP Client has an error\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Exception\\PostNLException`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($message, $code, $previous, $response\)<Firstred\\PostNL\\Exception\\HttpClientException::\_\_construct\(\)>`
* :php:meth:`public setResponse\($response\)<Firstred\\PostNL\\Exception\\HttpClientException::setResponse\(\)>`
* :php:meth:`public getResponse\(\)<Firstred\\PostNL\\Exception\\HttpClientException::getResponse\(\)>`


Properties
----------

.. php:attr:: private static response



Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $message=\'\', $code=0, $previous=null, $response=null)
	
		
	
	

.. rst-class:: public

	.. php:method:: public setResponse( $response)
	
		
	
	

.. rst-class:: public

	.. php:method:: public getResponse()
	
		
	
	

