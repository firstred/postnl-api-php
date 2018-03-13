.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TimeframeService
================


.. php:namespace:: ThirtyBees\PostNL\Service

.. php:class:: TimeframeService


	.. rst-class:: phpdoc-description
	
		| Class TimeframeService
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Service\\AbstractService`
	

Constants
---------

.. php:const:: VERSION = 2\.1



.. php:const:: LIVE_ENDPOINT = https://api\.postnl\.nl/shipment/v2\_1/calculate/timeframes



.. php:const:: SANDBOX_ENDPOINT = https://api\-sandbox\.postnl\.nl/shipment/v2\_1/calculate/timeframes



.. php:const:: LEGACY_SANDBOX_ENDPOINT = https://testservice\.postnl\.com/CIF\_SB/TimeframeWebService/2\_0/TimeframeWebService\.svc



.. php:const:: LEGACY_LIVE_ENDPOINT = https://service\.postnl\.com/CIF/TimeframeWebService/2\_0/TimeframeWebService\.svc



.. php:const:: SOAP_ACTION = http://postnl\.nl/cif/services/TimeframeWebService/ITimeframeWebService/GetTimeframes



.. php:const:: SERVICES_NAMESPACE = http://postnl\.nl/cif/services/TimeframeWebService/



.. php:const:: DOMAIN_NAMESPACE = http://postnl\.nl/cif/domain/TimeframeWebService/



Properties
----------

.. php:attr:: public namespaces

	.. rst-class:: phpdoc-description
	
		| Namespaces uses for the SOAP version of this service
		
	
	:Type: array 


Methods
-------

.. rst-class:: public

	.. php:method:: public getTimeframesREST( $getTimeframes)
	
		.. rst-class:: phpdoc-description
		
			| Get timeframes via REST
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes <ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes <ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes>` 
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

	.. php:method:: public getTimeframesSOAP( $getTimeframes)
	
		.. rst-class:: phpdoc-description
		
			| Get timeframes via SOAP
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes <ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes <ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes>` 
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

	.. php:method:: public buildGetTimeframesRequestREST( $getTimeframes)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetTimeframes request for the REST API
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes <ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetTimeframesResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetTimeframes Response REST
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes <ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetTimeframesRequestSOAP( $getTimeframes)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetTimeframes request for the SOAP API
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes <ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetTimeframesResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetTimeframes Response SOAP
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes <ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes>` 
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
	
	

