.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractResponseProcessor
=========================


.. php:namespace:: Firstred\PostNL\Service\ResponseProcessor

.. rst-class::  abstract

.. php:class:: AbstractResponseProcessor




Summary
-------

Methods
~~~~~~~

* :php:meth:`protected static getResponseText\($response\)<Firstred\\PostNL\\Service\\ResponseProcessor\\AbstractResponseProcessor::getResponseText\(\)>`


Methods
-------

.. rst-class:: protected static

	.. php:method:: protected static getResponseText(array|\\Psr\\Http\\Message\\ResponseInterface|\\Firstred\\PostNL\\Exception\\HttpClientException $response)
	
		.. rst-class:: phpdoc-description
		
			| Get the response\.
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Since: 2.0.0 
	
	

