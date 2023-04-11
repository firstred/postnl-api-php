.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TimeframeServiceRestResponseProcessor
=====================================


.. php:namespace:: Firstred\PostNL\Service\ResponseProcessor\Rest

.. php:class:: TimeframeServiceRestResponseProcessor


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\ResponseProcessor\\Rest\\AbstractRestResponseProcessor`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\ResponseProcessor\\TimeframeServiceResponseProcessorInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public processGetTimeframesResponse\($response\)<Firstred\\PostNL\\Service\\ResponseProcessor\\Rest\\TimeframeServiceRestResponseProcessor::processGetTimeframesResponse\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public processGetTimeframesResponse( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process the \'get timeframes\' server response\.
			
		
		
		:Parameters:
			* **$response** (:any:`Psr\\Http\\Message\\ResponseInterface <Psr\\Http\\Message\\ResponseInterface>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes <Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Since: 2.0.0 
	
	

