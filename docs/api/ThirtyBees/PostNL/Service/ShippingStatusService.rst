.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ShippingStatusService
=====================


.. php:namespace:: ThirtyBees\PostNL\Service

.. php:class:: ShippingStatusService


	.. rst-class:: phpdoc-description
	
		| Class ShippingStatusService
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Service\\AbstractService`
	

Constants
---------

.. php:const:: VERSION = 1\.6



.. php:const:: LIVE_ENDPOINT = https://api\.postnl\.nl/shipment/v1\_6/status



.. php:const:: SANDBOX_ENDPOINT = https://api\-sandbox\.postnl\.nl/shipment/v1\_6/status



.. php:const:: LEGACY_SANDBOX_ENDPOINT = https://testservice\.postnl\.com/CIF\_SB/ShippingStatusWebService/1\_6/ShippingStatusWebService\.svc



.. php:const:: LEGACY_LIVE_ENDPOINT = https://service\.postnl\.com/CIF/ShippingStatusWebService/1\_6/ShippingStatusWebService\.svc



.. php:const:: SOAP_ACTION = http://postnl\.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CurrentStatus



.. php:const:: SOAP_ACTION_COMPLETE = http://postnl\.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/CompleteStatus



.. php:const:: SOAP_ACTION_SIGNATURE = http://postnl\.nl/cif/services/ShippingStatusWebService/IShippingStatusWebService/GetSignature



.. php:const:: SERVICES_NAMESPACE = http://postnl\.nl/cif/services/ShippingStatusWebService/



.. php:const:: DOMAIN_NAMESPACE = http://postnl\.nl/cif/domain/ShippingStatusWebService/



Properties
----------

.. php:attr:: public namespaces

	.. rst-class:: phpdoc-description
	
		| Namespaces uses for the SOAP version of this service
		
	
	:Type: array 


Methods
-------

.. rst-class:: public

	.. php:method:: public currentStatusREST( $currentStatus)
	
		.. rst-class:: phpdoc-description
		
			| Gets the current status
			
			| This is a combi\-function, supporting the following:
			| \- CurrentStatus \(by barcode\):
			|   \- Fill the Shipment\-\>Barcode property\. Leave the rest empty\.
			| \- CurrentStatusByReference:
			|   \- Fill the Shipment\-\>Reference property\. Leave the rest empty\.
			| \- CurrentStatusByPhase:
			|   \- Fill the Shipment\-\>PhaseCode property, do not pass Barcode or Reference\.
			|     Optionally add DateFrom and/or DateTo\.
			| \- CurrentStatusByStatus:
			|   \- Fill the Shipment\-\>StatuCode property\. Leave the rest empty\.
			
		
		
		:Parameters:
			* **$currentStatus** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus <ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse <ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse>` 
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

	.. php:method:: public currentStatusSOAP( $currentStatus)
	
		.. rst-class:: phpdoc-description
		
			| Gets the current status
			
			| This is a combi\-function, supporting the following:
			| \- CurrentStatus \(by barcode\):
			|   \- Fill the Shipment\-\>Barcode property\. Leave the rest empty\.
			| \- CurrentStatusByReference:
			|   \- Fill the Shipment\-\>Reference property\. Leave the rest empty\.
			| \- CurrentStatusByPhase:
			|   \- Fill the Shipment\-\>PhaseCode property, do not pass Barcode or Reference\.
			|     Optionally add DateFrom and/or DateTo\.
			| \- CurrentStatusByStatus:
			|   \- Fill the Shipment\-\>StatuCode property\. Leave the rest empty\.
			
		
		
		:Parameters:
			* **$currentStatus** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus <ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse <ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
	
	

.. rst-class:: public

	.. php:method:: public completeStatusREST( $completeStatus)
	
		.. rst-class:: phpdoc-description
		
			| Gets the complete status
			
			| This is a combi\-function, supporting the following:
			| \- CurrentStatus \(by barcode\):
			|   \- Fill the Shipment\-\>Barcode property\. Leave the rest empty\.
			| \- CurrentStatusByReference:
			|   \- Fill the Shipment\-\>Reference property\. Leave the rest empty\.
			| \- CurrentStatusByPhase:
			|   \- Fill the Shipment\-\>PhaseCode property, do not pass Barcode or Reference\.
			|     Optionally add DateFrom and/or DateTo\.
			| \- CurrentStatusByStatus:
			|   \- Fill the Shipment\-\>StatuCode property\. Leave the rest empty\.
			
		
		
		:Parameters:
			* **$completeStatus** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus <ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse <ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse>` 
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

	.. php:method:: public completeStatusSOAP( $completeStatus)
	
		.. rst-class:: phpdoc-description
		
			| Gets the complete status
			
			| This is a combi\-function, supporting the following:
			| \- CurrentStatus \(by barcode\):
			|   \- Fill the Shipment\-\>Barcode property\. Leave the rest empty\.
			| \- CurrentStatusByReference:
			|   \- Fill the Shipment\-\>Reference property\. Leave the rest empty\.
			| \- CurrentStatusByPhase:
			|   \- Fill the Shipment\-\>PhaseCode property, do not pass Barcode or Reference\.
			|     Optionally add DateFrom and/or DateTo\.
			| \- CurrentStatusByStatus:
			|   \- Fill the Shipment\-\>StatusCode property\. Leave the rest empty\.
			
		
		
		:Parameters:
			* **$completeStatus** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus <ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse <ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Sabre\\Xml\\LibXMLException <Sabre\\Xml\\LibXMLException>` 
	
	

.. rst-class:: public

	.. php:method:: public getSignatureREST( $getSignature)
	
		.. rst-class:: phpdoc-description
		
			| Gets the complete status
			
			| This is a combi\-function, supporting the following:
			| \- CurrentStatus \(by barcode\):
			|   \- Fill the Shipment\-\>Barcode property\. Leave the rest empty\.
			| \- CurrentStatusByReference:
			|   \- Fill the Shipment\-\>Reference property\. Leave the rest empty\.
			| \- CurrentStatusByPhase:
			|   \- Fill the Shipment\-\>PhaseCode property, do not pass Barcode or Reference\.
			|     Optionally add DateFrom and/or DateTo\.
			| \- CurrentStatusByStatus:
			|   \- Fill the Shipment\-\>StatuCode property\. Leave the rest empty\.
			
		
		
		:Parameters:
			* **$getSignature** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSignature <ThirtyBees\\PostNL\\Entity\\Request\\GetSignature>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature <ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature>` 
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

	.. php:method:: public getSignatureSOAP( $getSignature)
	
		.. rst-class:: phpdoc-description
		
			| Gets the complete status
			
			| This is a combi\-function, supporting the following:
			| \- CurrentStatus \(by barcode\):
			|   \- Fill the Shipment\-\>Barcode property\. Leave the rest empty\.
			| \- CurrentStatusByReference:
			|   \- Fill the Shipment\-\>Reference property\. Leave the rest empty\.
			| \- CurrentStatusByPhase:
			|   \- Fill the Shipment\-\>PhaseCode property, do not pass Barcode or Reference\.
			|     Optionally add DateFrom and/or DateTo\.
			| \- CurrentStatusByStatus:
			|   \- Fill the Shipment\-\>StatuCode property\. Leave the rest empty\.
			
		
		
		:Parameters:
			* **$getSignature** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSignature <ThirtyBees\\PostNL\\Entity\\Request\\GetSignature>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Request\\GetSignature <ThirtyBees\\PostNL\\Entity\\Request\\GetSignature>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildCurrentStatusRequestREST( $currentStatus)
	
		.. rst-class:: phpdoc-description
		
			| Build the CurrentStatus request for the REST API
			
			| This function auto\-detects and adjusts the following requests:
			| \- CurrentStatus
			| \- CurrentStatusByReference
			| \- CurrentStatusByPhase
			| \- CurrentStatusByStatus
			
		
		
		:Parameters:
			* **$currentStatus** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus <ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processCurrentStatusResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process CurrentStatus Response REST
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse <ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildCurrentStatusRequestSOAP( $currentStatus)
	
		.. rst-class:: phpdoc-description
		
			| Build the CurrentStatus request for the SOAP API
			
		
		
		:Parameters:
			* **$currentStatus** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus <ThirtyBees\\PostNL\\Entity\\Request\\CurrentStatus>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processCurrentStatusResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process CurrentStatus Response SOAP
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse <ThirtyBees\\PostNL\\Entity\\Response\\CurrentStatusResponse>` 
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

	.. php:method:: public buildCompleteStatusRequestREST( $completeStatus)
	
		.. rst-class:: phpdoc-description
		
			| Build the CompleteStatus request for the REST API
			
			| This function auto\-detects and adjusts the following requests:
			| \- CompleteStatus
			| \- CompleteStatusByReference
			| \- CompleteStatusByPhase
			| \- CompleteStatusByStatus
			
		
		
		:Parameters:
			* **$completeStatus** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus <ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processCompleteStatusResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process CompleteStatus Response REST
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse <ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildCompleteStatusRequestSOAP( $completeStatus)
	
		.. rst-class:: phpdoc-description
		
			| Build the CompleteStatus request for the SOAP API
			
			| This function handles following requests:
			| \- CompleteStatus
			| \- CompleteStatusByReference
			| \- CompleteStatusByPhase
			| \- CompleteStatusByStatus
			
		
		
		:Parameters:
			* **$completeStatus** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus <ThirtyBees\\PostNL\\Entity\\Request\\CompleteStatus>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processCompleteStatusResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process CompleteStatus Response SOAP
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse <ThirtyBees\\PostNL\\Entity\\Response\\CompleteStatusResponse>` 
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

	.. php:method:: public buildGetSignatureRequestREST( $getSignature)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetSignature request for the REST API
			
		
		
		:Parameters:
			* **$getSignature** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSignature <ThirtyBees\\PostNL\\Entity\\Request\\GetSignature>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetSignatureResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetSignature Response REST
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature <ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildGetSignatureRequestSOAP( $getSignature)
	
		.. rst-class:: phpdoc-description
		
			| Build the GetSignature request for the SOAP API
			
		
		
		:Parameters:
			* **$getSignature** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSignature <ThirtyBees\\PostNL\\Entity\\Request\\GetSignature>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGetSignatureResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GetSignature Response SOAP
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature <ThirtyBees\\PostNL\\Entity\\Response\\GetSignatureResponseSignature>` 
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
	
	

