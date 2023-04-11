.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


BarcodeServiceRestRequestBuilder
================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder\Rest

.. php:class:: BarcodeServiceRestRequestBuilder


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\AbstractRestRequestBuilder`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\RequestBuilder\\BarcodeServiceRequestBuilderInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGenerateBarcodeRequest\($generateBarcode\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\BarcodeServiceRestRequestBuilder::buildGenerateBarcodeRequest\(\)>`
* :php:meth:`public setService\($entity\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\BarcodeServiceRestRequestBuilder::setService\(\)>`


Constants
---------

.. php:const:: SANDBOX_ENDPOINT = \'https://api\-sandbox\.postnl\.nl/shipment/v1\_1/barcode\'



.. php:const:: LIVE_ENDPOINT = \'https://api\.postnl\.nl/shipment/v1\_1/barcode\'



Methods
-------

.. rst-class:: public

	.. php:method:: public buildGenerateBarcodeRequest( $generateBarcode)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'generate barcode\' HTTP request\.
			
		
		
		:Parameters:
			* **$generateBarcode** (:any:`Firstred\\PostNL\\Entity\\Request\\GenerateBarcode <Firstred\\PostNL\\Entity\\Request\\GenerateBarcode>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setService( $entity)
	
		.. rst-class:: phpdoc-description
		
			| Set this service on the given entity\.
			
			| This lets the entity know for which service it should serialize\.
			
		
		
		:Parameters:
			* **$entity** (:any:`Firstred\\PostNL\\Entity\\AbstractEntity <Firstred\\PostNL\\Entity\\AbstractEntity>`)  

		
		:Returns: void 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

