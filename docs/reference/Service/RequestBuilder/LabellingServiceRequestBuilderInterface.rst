.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LabellingServiceRequestBuilderInterface
=======================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder

.. php:interface:: LabellingServiceRequestBuilderInterface




Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGenerateLabelRequest\($generateLabel, $confirm\)<Firstred\\PostNL\\Service\\RequestBuilder\\LabellingServiceRequestBuilderInterface::buildGenerateLabelRequest\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public buildGenerateLabelRequest( $generateLabel, $confirm=true)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'generate label\' HTTP request\.
			
		
		
		:Parameters:
			* **$generateLabel** (:any:`Firstred\\PostNL\\Entity\\Request\\GenerateLabel <Firstred\\PostNL\\Entity\\Request\\GenerateLabel>`)  
			* **$confirm** (bool)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

