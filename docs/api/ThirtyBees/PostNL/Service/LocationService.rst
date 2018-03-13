.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


LocationService
===============


.. php:namespace:: ThirtyBees\PostNL\Service

.. php:class:: LocationService


	.. rst-class:: phpdoc-description
	
		| Class LocationService
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Service\\AbstractService`
	

Constants
---------

.. php:const:: VERSION = 2\.1



.. php:const:: LIVE_ENDPOINT = https://api\.postnl\.nl/shipment/v2\_1/locations



.. php:const:: SANDBOX_ENDPOINT = https://api\-sandbox\.postnl\.nl/shipment/v2\_1/locations



.. php:const:: LEGACY_SANDBOX_ENDPOINT = https://testservice\.postnl\.com/CIF\_SB/LocationWebService/2\_1/LocationWebService\.svc



.. php:const:: LEGACY_LIVE_ENDPOINT = https://service\.postnl\.com/CIF/LocationWebService/2\_1/LocationWebService\.svc



.. php:const:: SOAP_ACTION = http://postnl\.nl/cif/services/LocationWebService/ILocationWebService/GetNearestLocations



.. php:const:: SOAP_ACTION_LOCATIONS_IN_AREA = http://postnl\.nl/cif/services/LocationWebService/ILocationWebService/GetNearestLocations



.. php:const:: SOAP_ACTION_LOCATION = http://postnl\.nl/cif/services/LocationWebService/ILocationWebService/GetLocation



.. php:const:: SERVICES_NAMESPACE = http://postnl\.nl/cif/services/LocationWebService/



.. php:const:: DOMAIN_NAMESPACE = http://postnl\.nl/cif/domain/LocationWebService/



Properties
----------

.. php:attr:: public namespaces

	.. rst-class:: phpdoc-description
	
		| Namespaces uses for the SOAP version of this service
		
	
	:Type: array 


Methods
-------

.. rst-class:: public

	.. php:method:: public getNearestLocationsREST( $getNearestLocations)
	
		.. rst-class:: phpdoc-description
		
			| Get the nearest locations via REST
			
		
		
		:Parameters:
			* **$getNearestLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations <ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public getNearestLocationsSOAP( $getNearestLocations)
	
		.. rst-class:: phpdoc-description
		
			| Get the nearest locations via SOAP
			
		
		
		:Parameters:
			* **$getNearestLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations <ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public getLocationsInAreaREST( $getLocations)
	
		.. rst-class:: phpdoc-description
		
			| Get the nearest locations via REST
			
		
		
		:Parameters:
			* **$getLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea <ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public getLocationsInAreaSOAP( $getNearestLocations)
	
		.. rst-class:: phpdoc-description
		
			| Get the nearest locations via SOAP
			
		
		
		:Parameters:
			* **$getNearestLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea <ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public getLocationREST( $getLocation)
	
		.. rst-class:: phpdoc-description
		
			| Get the location via REST
			
		
		
		:Parameters:
			* **$getLocation** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocation <ThirtyBees\\PostNL\\Entity\\Request\\GetLocation>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public getLocationSOAP( $getLocation)
	
		.. rst-class:: phpdoc-description
		
			| Get the nearest locations via SOAP
			
		
		
		:Parameters:
			* **$getLocation** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocation <ThirtyBees\\PostNL\\Entity\\Request\\GetLocation>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetNearestLocationsRequestREST( $getNearestLocations)
	
		.. rst-class:: phpdoc-description
		
			| Build the GenerateLabel request for the REST API
			
		
		
		:Parameters:
			* **$getNearestLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations <ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetNearestLocationsResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetNearestLocations Response REST
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetNearestLocationsRequestSOAP( $getLocations)
	
		.. rst-class:: phpdoc-description
		
			| Build the GenerateLabel request for the SOAP API
			
		
		
		:Parameters:
			* **$getLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations <ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetNearestLocationsResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetNearestLocations Response SOAP
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetLocationsInAreaRequestREST( $getLocations)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetLocationsInArea request for the REST API
			
		
		
		:Parameters:
			* **$getLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea <ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetLocationsInAreaResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Proess GetLocationsInArea Response REST
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetLocationsInAreaRequestSOAP( $getLocations)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetLocationsInArea request for the SOAP API
			
		
		
		:Parameters:
			* **$getLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea <ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetLocationsInAreaResponseSOAP( $response)
	
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetLocationRequestREST( $getLocation)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetLocation request for the REST API
			
		
		
		:Parameters:
			* **$getLocation** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocation <ThirtyBees\\PostNL\\Entity\\Request\\GetLocation>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetLocationResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetLocation Response REST
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetLocationRequestSOAP( $getLocations)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetLocation request for the SOAP API
			
		
		
		:Parameters:
			* **$getLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocation <ThirtyBees\\PostNL\\Entity\\Request\\GetLocation>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetLocationResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetLocation Response SOAP
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

