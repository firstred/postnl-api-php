.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ShippingServiceRequestBuilderInterface
======================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder

.. php:interface:: ShippingServiceRequestBuilderInterface




Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildSendShipmentRequest\($sendShipment, $confirm\)<Firstred\\PostNL\\Service\\RequestBuilder\\ShippingServiceRequestBuilderInterface::buildSendShipmentRequest\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public buildSendShipmentRequest( $sendShipment, $confirm=true)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'send shipment\' HTTP request\.
			
		
		
		:Parameters:
			* **$sendShipment** (:any:`Firstred\\PostNL\\Entity\\Request\\SendShipment <Firstred\\PostNL\\Entity\\Request\\SendShipment>`)  
			* **$confirm** (bool)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

