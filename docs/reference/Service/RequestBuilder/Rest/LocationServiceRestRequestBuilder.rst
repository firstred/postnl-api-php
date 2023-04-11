.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LocationServiceRestRequestBuilder
=================================


.. php:namespace:: Firstred\PostNL\Service\RequestBuilder\Rest

.. php:class:: LocationServiceRestRequestBuilder


	:Parent:
		:php:class:`Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\AbstractRestRequestBuilder`
	
	:Implements:
		:php:interface:`Firstred\\PostNL\\Service\\RequestBuilder\\LocationServiceRequestBuilderInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public buildGetNearestLocationsRequest\($getNearestLocations\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\LocationServiceRestRequestBuilder::buildGetNearestLocationsRequest\(\)>`
* :php:meth:`public buildGetLocationsInAreaRequest\($getLocations\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\LocationServiceRestRequestBuilder::buildGetLocationsInAreaRequest\(\)>`
* :php:meth:`public buildGetLocationRequest\($getLocation\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\LocationServiceRestRequestBuilder::buildGetLocationRequest\(\)>`
* :php:meth:`protected setService\($entity\)<Firstred\\PostNL\\Service\\RequestBuilder\\Rest\\LocationServiceRestRequestBuilder::setService\(\)>`


Constants
---------

.. php:const:: LIVE_ENDPOINT = \'https://api\.postnl\.nl/shipment/v2\_1/locations\'



.. php:const:: SANDBOX_ENDPOINT = \'https://api\-sandbox\.postnl\.nl/shipment/v2\_1/locations\'



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
	
	

