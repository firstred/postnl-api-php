.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ShippingStatusServiceRestRequestBuilder
=======================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder\Rest

.. php:class:: ShippingStatusServiceRestRequestBuilder


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\AbstractRestRequestBuilder`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\RequestBuilder\\ShippingStatusServiceRequestBuilderInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildCurrentStatusRequest\($currentStatus\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\ShippingStatusServiceRestRequestBuilder::buildCurrentStatusRequest\(\)>`
* :php:meth:`public buildCompleteStatusRequest\($completeStatus\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\ShippingStatusServiceRestRequestBuilder::buildCompleteStatusRequest\(\)>`
* :php:meth:`public buildGetSignatureRequest\($getSignature\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\ShippingStatusServiceRestRequestBuilder::buildGetSignatureRequest\(\)>`
* :php:meth:`public buildGetUpdatedShipmentsRequest\($customer, $dateTimeFrom, $dateTimeTo\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\ShippingStatusServiceRestRequestBuilder::buildGetUpdatedShipmentsRequest\(\)>`
* :php:meth:`protected setService\($entity\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\ShippingStatusServiceRestRequestBuilder::setService\(\)>`


Constants
---------

.. php:const:: LIVE_ENDPOINT = \'https://api\.postnl\.nl/shipment/v2/status\'



.. php:const:: SANDBOX_ENDPOINT = \'https://api\-sandbox\.postnl\.nl/shipment/v2/status\'



Methods
-------

.. rst-class:: public

	.. php:method:: public buildCurrentStatusRequest(\\Firstred\\PostNL\\Entity\\Request\\CurrentStatusByReference|\\Firstred\\PostNL\\Entity\\Request\\CurrentStatus $currentStatus)
	
		.. rst-class:: phpdoc-description
		
			| Build the CurrentStatus request for the REST API\.
			
			| This function auto\-detects and adjusts the following requests:
			| \- CurrentStatus
			| \- CurrentStatusByReference
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public buildCompleteStatusRequest( $completeStatus)
	
		.. rst-class:: phpdoc-description
		
			| Build the CompleteStatus request for the REST API\.
			
			| This function auto\-detects and adjusts the following requests:
			| \- CompleteStatus
			| \- CompleteStatusByReference
			| \- CompleteStatusByPhase
			| \- CompleteStatusByStatus
			
		
		
		:Parameters:
			* **$completeStatus** (:any:`Firstred\\PostNL\\Entity\\Request\\CompleteStatus <Firstred\\PostNL\\Entity\\Request\\CompleteStatus>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public buildGetSignatureRequest( $getSignature)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetSignature request for the REST API\.
			
		
		
		:Parameters:
			* **$getSignature** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSignature <Firstred\\PostNL\\Entity\\Request\\GetSignature>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public buildGetUpdatedShipmentsRequest( $customer, $dateTimeFrom=null, $dateTimeTo=null)
	
		.. rst-class:: phpdoc-description
		
			| Build get updated shipments request REST\.
			
		
		
		:Parameters:
			* **$customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>`)  
			* **$dateTimeFrom** (:any:`DateTimeInterface <DateTimeInterface>` | null)  
			* **$dateTimeTo** (:any:`DateTimeInterface <DateTimeInterface>` | null)  

		
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
	
	

