.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


DeliveryDateServiceRequestBuilderInterface
==========================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder

.. php:interface:: DeliveryDateServiceRequestBuilderInterface




Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGetDeliveryDateRequest\($getDeliveryDate\)<Firstred\\PostNL\\Service\\RequestBuilder\\DeliveryDateServiceRequestBuilderInterface::buildGetDeliveryDateRequest\(\)>`
* :php:meth:`public buildGetSentDateRequest\($getSentDate\)<Firstred\\PostNL\\Service\\RequestBuilder\\DeliveryDateServiceRequestBuilderInterface::buildGetSentDateRequest\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public buildGetDeliveryDateRequest( $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'get delivery date\' HTTP request\.
			
		
		
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
		
			| Build the \'get sent date\' HTTP request\.
			
		
		
		:Parameters:
			* **$getSentDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest <Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

