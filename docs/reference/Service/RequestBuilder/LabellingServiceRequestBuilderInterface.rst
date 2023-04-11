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
		
			| Build the GenerateLabel request for the REST API\.
			
		
		
		:Parameters:
			* **$generateLabel** (:any:`Firstred\\PostNL\\Entity\\Request\\GenerateLabel <Firstred\\PostNL\\Entity\\Request\\GenerateLabel>`)  
			* **$confirm** (bool)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Since: 1.0.0 
	
	

