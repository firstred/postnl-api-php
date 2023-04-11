.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractRequestBuilder
======================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder

.. rst-class::  abstract

.. php:class:: AbstractRequestBuilder




Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($apiKey, $sandbox, $requestFactory, $streamFactory\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::\_\_construct\(\)>`
* :php:meth:`public setApiKey\($apiKey\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::setApiKey\(\)>`
* :php:meth:`public isSandbox\(\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::isSandbox\(\)>`
* :php:meth:`public setSandbox\($sandbox\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::setSandbox\(\)>`
* :php:meth:`public getRequestFactory\(\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::getRequestFactory\(\)>`
* :php:meth:`public setRequestFactory\($requestFactory\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::setRequestFactory\(\)>`
* :php:meth:`public getStreamFactory\(\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::getStreamFactory\(\)>`
* :php:meth:`public setStreamFactory\($streamFactory\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::setStreamFactory\(\)>`
* :php:meth:`protected setService\($entity\)<Firstred\\PostNL\\Service\\RequestBuilder\\AbstractRequestBuilder::setService\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $apiKey, $sandbox, $requestFactory, $streamFactory)
	
		
		:Parameters:
			* **$apiKey** (:any:`ParagonIE\\HiddenString\\HiddenString <ParagonIE\\HiddenString\\HiddenString>`)  
			* **$sandbox** (bool)  
			* **$requestFactory** (:any:`Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>`)  
			* **$streamFactory** (:any:`Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public setApiKey( $apiKey)
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public isSandbox()
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setSandbox( $sandbox)
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getRequestFactory()
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setRequestFactory( $requestFactory)
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getStreamFactory()
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setStreamFactory( $streamFactory)
	
		
		:Since: 2.0.0 
	
	

.. rst-class:: protected

	.. php:method:: protected setService( $entity)
	
		.. rst-class:: phpdoc-description
		
			| Set this service on given entity\.
			
			| This lets the entity know for which service it should serialize\.
			
		
		
		:Parameters:
			* **$entity** (:any:`Firstred\\PostNL\\Entity\\AbstractEntity <Firstred\\PostNL\\Entity\\AbstractEntity>`)  

		
		:Returns: void 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 2.0.0 
	
	

