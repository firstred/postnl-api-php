.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ShippingStatusServiceRequestBuilderInterface
============================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder

.. php:interface:: ShippingStatusServiceRequestBuilderInterface




Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildCurrentStatusRequest\($currentStatus\)<Firstred\\PostNL\\Service\\RequestBuilder\\ShippingStatusServiceRequestBuilderInterface::buildCurrentStatusRequest\(\)>`
* :php:meth:`public buildCompleteStatusRequest\($completeStatus\)<Firstred\\PostNL\\Service\\RequestBuilder\\ShippingStatusServiceRequestBuilderInterface::buildCompleteStatusRequest\(\)>`
* :php:meth:`public buildGetSignatureRequest\($getSignature\)<Firstred\\PostNL\\Service\\RequestBuilder\\ShippingStatusServiceRequestBuilderInterface::buildGetSignatureRequest\(\)>`
* :php:meth:`public buildGetUpdatedShipmentsRequest\($getUpdatedShipments\)<Firstred\\PostNL\\Service\\RequestBuilder\\ShippingStatusServiceRequestBuilderInterface::buildGetUpdatedShipmentsRequest\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public buildCurrentStatusRequest(\\Firstred\\PostNL\\Entity\\Request\\CurrentStatusByReference|\\Firstred\\PostNL\\Entity\\Request\\CurrentStatus $currentStatus)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'get current status\' HTTP request\.
			
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
		
			| Build the \'get complete status\' HTTP request\.
			
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
		
			| Build the \'get signature\' HTTP request\.
			
		
		
		:Parameters:
			* **$getSignature** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSignature <Firstred\\PostNL\\Entity\\Request\\GetSignature>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public buildGetUpdatedShipmentsRequest( $getUpdatedShipments)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'get updated shipments\' HTTP request\.
			
		
		
		:Parameters:
			* **$getUpdatedShipments** (:any:`Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments <Firstred\\PostNL\\Entity\\Request\\GetUpdatedShipments>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

