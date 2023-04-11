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
		
			| Build the GenerateLabel request for the REST API\.
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public buildGetLocationsInAreaRequest( $getLocations)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetLocationsInArea request for the REST API\.
			
		
		
		:Since: 2.0.0 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetLocationRequest( $getLocation)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetLocation request for the REST API\.
			
		
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
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
	
	

