.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


DeliveryDateService
===================


.. php:namespace:: ThirtyBees\PostNL\Service

.. php:class:: DeliveryDateService


	.. rst-class:: phpdoc-description
	
		| Class DeliveryDateService
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Service\\AbstractService`
	

Constants
---------

.. php:const:: VERSION = 2\.2



.. php:const:: LIVE_ENDPOINT = https://api\.postnl\.nl/shipment/v2\_2/calculate/date



.. php:const:: SANDBOX_ENDPOINT = https://api\-sandbox\.postnl\.nl/shipment/v2\_2/calculate/date



.. php:const:: LEGACY_SANDBOX_ENDPOINT = https://testservice\.postnl\.com/CIF\_SB/DeliveryDateWebService/2\_1/DeliveryDateWebService\.svc



.. php:const:: LEGACY_LIVE_ENDPOINT = https://service\.postnl\.com/CIF/DeliveryDateWebService/2\_1/DeliveryDateWebService\.svc



.. php:const:: SOAP_ACTION = http://postnl\.nl/cif/services/DeliveryDateWebService/IDeliveryDateWebService/GetDeliveryDate



.. php:const:: SOAP_ACTION_SENT = http://postnl\.nl/cif/services/DeliveryDateWebService/IDeliveryDateWebService/GetSentDate



.. php:const:: SERVICES_NAMESPACE = http://postnl\.nl/cif/services/DeliveryDateWebService/



.. php:const:: DOMAIN_NAMESPACE = http://postnl\.nl/cif/domain/DeliveryDateWebService/



Properties
----------

.. php:attr:: public namespaces

	.. rst-class:: phpdoc-description
	
		| Namespaces uses for the SOAP version of this service
		
	
	:Type: array 


Methods
-------

.. rst-class:: public

	.. php:method:: public getDeliveryDateREST( $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Get a delivery date via REST
			
		
		
		:Parameters:
			* **$getDeliveryDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate <ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse>` 
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

	.. php:method:: public getDeliveryDateSOAP( $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Get a delivery date via SOAP
			
		
		
		:Parameters:
			* **$getDeliveryDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate <ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse>` 
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
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
	
	

.. rst-class:: public

	.. php:method:: public getSentDateREST( $getSentDate)
	
		.. rst-class:: phpdoc-description
		
			| Get the sent date via REST
			
		
		
		:Parameters:
			* **$getSentDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest <ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse>` 
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

	.. php:method:: public getSentDateSOAP( $getSentDate)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single label via SOAP
			
		
		
		:Parameters:
			* **$getSentDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest <ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetDeliveryDateRequestREST( $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetDeliveryDate request for the REST API
			
		
		
		:Parameters:
			* **$getDeliveryDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate <ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetDeliveryDateResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetDeliveryDate REST Response
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetDeliveryDateRequestSOAP( $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetDeliveryDate request for the SOAP API
			
		
		
		:Parameters:
			* **$getDeliveryDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate <ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetDeliveryDateResponseSOAP( $response)
	
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetSentDateRequestREST( $getSentDate)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetSentDate request for the REST API
			
		
		
		:Parameters:
			* **$getSentDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest <ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetSentDateResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetSentDate REST Response
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetSentDateRequestSOAP( $getSentDate)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetSentDate request for the SOAP API
			
		
		
		:Parameters:
			* **$getSentDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest <ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetSentDateResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetSentDate SOAP Response
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
	
	

