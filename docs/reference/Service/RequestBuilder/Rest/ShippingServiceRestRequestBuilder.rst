.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ShippingServiceRestRequestBuilder
=================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder\Rest

.. php:class:: ShippingServiceRestRequestBuilder


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\AbstractRestRequestBuilder`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\RequestBuilder\\ShippingServiceRequestBuilderInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildSendShipmentRequest\($sendShipment, $confirm\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\ShippingServiceRestRequestBuilder::buildSendShipmentRequest\(\)>`
* :php:meth:`protected setService\($entity\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\ShippingServiceRestRequestBuilder::setService\(\)>`


Constants
---------

.. php:const:: LIVE_ENDPOINT = \'https://api\.postnl\.nl/v1/shipment\'



.. php:const:: SANDBOX_ENDPOINT = \'https://api\-sandbox\.postnl\.nl/v1/shipment\'



Methods
-------

.. rst-class:: public

	.. php:method:: public buildSendShipmentRequest( $sendShipment, $confirm=true)
	
		
		:Parameters:
			* **$sendShipment** (:any:`Firstred\\PostNL\\Entity\\Request\\SendShipment <Firstred\\PostNL\\Entity\\Request\\SendShipment>`)  
			* **$confirm** (bool)  

		
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
	
	

