.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


BarcodeServiceRequestBuilderInterface
=====================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder

.. php:interface:: BarcodeServiceRequestBuilderInterface




Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGenerateBarcodeRequest\($generateBarcode\)<Firstred\\PostNL\\Service\\RequestBuilder\\BarcodeServiceRequestBuilderInterface::buildGenerateBarcodeRequest\(\)>`


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
	
	

