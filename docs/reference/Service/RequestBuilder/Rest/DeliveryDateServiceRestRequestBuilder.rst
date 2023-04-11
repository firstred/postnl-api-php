.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


DeliveryDateServiceRestRequestBuilder
=====================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder\Rest

.. php:class:: DeliveryDateServiceRestRequestBuilder


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\AbstractRestRequestBuilder`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\RequestBuilder\\DeliveryDateServiceRequestBuilderInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGetDeliveryDateRequest\($getDeliveryDate\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\DeliveryDateServiceRestRequestBuilder::buildGetDeliveryDateRequest\(\)>`
* :php:meth:`public buildGetSentDateRequest\($getSentDate\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\DeliveryDateServiceRestRequestBuilder::buildGetSentDateRequest\(\)>`
* :php:meth:`protected setService\($entity\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\DeliveryDateServiceRestRequestBuilder::setService\(\)>`


Constants
---------

.. php:const:: LIVE_ENDPOINT = \'https://api\.postnl\.nl/shipment/v2\_2/calculate/date\'



.. php:const:: SANDBOX_ENDPOINT = \'https://api\-sandbox\.postnl\.nl/shipment/v2\_2/calculate/date\'



Methods
-------

.. rst-class:: public

	.. php:method:: public buildGetDeliveryDateRequest( $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetDeliveryDate request for the REST API\.
			
		
		
		:Parameters:
			* **$getDeliveryDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate <Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public buildGetSentDateRequest( $getSentDate)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetSentDate request for the REST API\.
			
		
		
		:Parameters:
			* **$getSentDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest <Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: protected

	.. php:method:: protected setService( $entity)
	
		
		:Parameters:
			* **$entity** (:any:`Firstred\\PostNL\\Entity\\AbstractEntity <Firstred\\PostNL\\Entity\\AbstractEntity>`)  

		
		:Returns: void 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

