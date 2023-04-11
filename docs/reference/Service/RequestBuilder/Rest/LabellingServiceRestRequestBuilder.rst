.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LabellingServiceRestRequestBuilder
==================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder\Rest

.. php:class:: LabellingServiceRestRequestBuilder


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\AbstractRestRequestBuilder`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\RequestBuilder\\LabellingServiceRequestBuilderInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGenerateLabelRequest\($generateLabel, $confirm\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\LabellingServiceRestRequestBuilder::buildGenerateLabelRequest\(\)>`
* :php:meth:`protected setService\($entity\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\LabellingServiceRestRequestBuilder::setService\(\)>`


Constants
---------

.. php:const:: LIVE_ENDPOINT = \'https://api\.postnl\.nl/shipment/v2\_2/label\'



.. php:const:: SANDBOX_ENDPOINT = \'https://api\-sandbox\.postnl\.nl/shipment/v2\_2/label\'



Properties
----------

.. php:attr:: private insuranceProductCodes

	:Type: int[] 


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
	
	

.. rst-class:: protected

	.. php:method:: protected setService( $entity)
	
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
	
	

