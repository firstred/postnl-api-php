.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TimeframeServiceRequestBuilderInterface
=======================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder

.. php:interface:: TimeframeServiceRequestBuilderInterface




Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGetTimeframesRequest\($getTimeframes\)<Firstred\\PostNL\\Service\\RequestBuilder\\TimeframeServiceRequestBuilderInterface::buildGetTimeframesRequest\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public buildGetTimeframesRequest( $getTimeframes)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'get timeframes\' HTTP request\.
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`Firstred\\PostNL\\Entity\\Request\\GetTimeframes <Firstred\\PostNL\\Entity\\Request\\GetTimeframes>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

