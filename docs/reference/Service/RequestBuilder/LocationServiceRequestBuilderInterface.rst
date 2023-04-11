.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LocationServiceRequestBuilderInterface
======================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder

.. php:interface:: LocationServiceRequestBuilderInterface




Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGetNearestLocationsRequest\($getNearestLocations\)<Firstred\\PostNL\\Service\\RequestBuilder\\LocationServiceRequestBuilderInterface::buildGetNearestLocationsRequest\(\)>`
* :php:meth:`public buildGetLocationsInAreaRequest\($getLocations\)<Firstred\\PostNL\\Service\\RequestBuilder\\LocationServiceRequestBuilderInterface::buildGetLocationsInAreaRequest\(\)>`
* :php:meth:`public buildGetLocationRequest\($getLocation\)<Firstred\\PostNL\\Service\\RequestBuilder\\LocationServiceRequestBuilderInterface::buildGetLocationRequest\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public buildGetNearestLocationsRequest( $getNearestLocations)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'get nearest locations\' HTTP request\.
			
		
		
		:Parameters:
			* **$getNearestLocations** (:any:`Firstred\\PostNL\\Entity\\Request\\GetNearestLocations <Firstred\\PostNL\\Entity\\Request\\GetNearestLocations>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public buildGetLocationsInAreaRequest( $getLocations)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'get locations in area\' HTTP\.
			
		
		
		:Parameters:
			* **$getLocations** (:any:`Firstred\\PostNL\\Entity\\Request\\GetLocationsInArea <Firstred\\PostNL\\Entity\\Request\\GetLocationsInArea>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Since: 2.0.0 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetLocationRequest( $getLocation)
	
		.. rst-class:: phpdoc-description
		
			| Build the \'get single location\' HTTP request\.
			
		
		
		:Parameters:
			* **$getLocation** (:any:`Firstred\\PostNL\\Entity\\Request\\GetLocation <Firstred\\PostNL\\Entity\\Request\\GetLocation>`)  

		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestInterface <Psr\\Http\\Message\\RequestInterface>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 2.0.0 
	
	

