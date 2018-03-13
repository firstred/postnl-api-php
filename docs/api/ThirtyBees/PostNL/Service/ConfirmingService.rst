.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ConfirmingService
=================


.. php:namespace:: ThirtyBees\PostNL\Service

.. php:class:: ConfirmingService


	.. rst-class:: phpdoc-description
	
		| Class ConfirmingService
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Service\\AbstractService`
	

Constants
---------

.. php:const:: VERSION = 2\.1



.. php:const:: LIVE_ENDPOINT = https://api\.postnl\.nl/shipment/v1\_10/confirm



.. php:const:: SANDBOX_ENDPOINT = https://api\-sandbox\.postnl\.nl/shipment/v1\_10/confirm



.. php:const:: LEGACY_SANDBOX_ENDPOINT = https://testservice\.postnl\.com/CIF\_SB/ConfirmingWebService/1\_10/ConfirmingWebService\.svc



.. php:const:: LEGACY_LIVE_ENDPOINT = https://service\.postnl\.com/CIF/ConfirmingWebService/1\_9/ConfirmingWebService\.svc



.. php:const:: SOAP_ACTION = http://postnl\.nl/cif/services/ConfirmingWebService/IConfirmingWebService/Confirming



.. php:const:: ENVELOPE_NAMESPACE = http://schemas\.xmlsoap\.org/soap/envelope/



.. php:const:: SERVICES_NAMESPACE = http://postnl\.nl/cif/services/ConfirmingWebService/



.. php:const:: DOMAIN_NAMESPACE = http://postnl\.nl/cif/domain/ConfirmingWebService/



Properties
----------

.. php:attr:: public namespaces

	.. rst-class:: phpdoc-description
	
		| Namespaces uses for the SOAP version of this service
		
	
	:Type: array 


Methods
-------

.. rst-class:: public

	.. php:method:: public confirmShipmentREST( $confirming)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode via REST
			
		
		
		:Parameters:
			* **$confirming** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\Confirming <ThirtyBees\\PostNL\\Entity\\Request\\Confirming>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment <ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
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

	.. php:method:: public confirmShipmentsREST( $confirms)
	
		.. rst-class:: phpdoc-description
		
			| Confirm multiple shipments
			
		
		
		:Parameters:
			* **$confirms** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\Confirming\[\] <ThirtyBees\\PostNL\\Entity\\Request\\Confirming>`)  ['uuid' => Confirming, ...]

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment\[\] <ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
	
	

.. rst-class:: public

	.. php:method:: public confirmShipmentSOAP( $confirming)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single label via SOAP
			
		
		
		:Parameters:
			* **$confirming** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\Confirming <ThirtyBees\\PostNL\\Entity\\Request\\Confirming>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment <ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
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
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

.. rst-class:: public

	.. php:method:: public confirmShipmentsSOAP( $confirmings)
	
		.. rst-class:: phpdoc-description
		
			| Generate multiple labels at once
			
		
		
		:Parameters:
			* **$confirmings** (array)  ['uuid' => Confirming, ...]

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment\[\] <ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
	
	

.. rst-class:: public

	.. php:method:: public buildConfirmRequestREST( $confirming)
	
		
		:Parameters:
			* **$confirming** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\Confirming <ThirtyBees\\PostNL\\Entity\\Request\\Confirming>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processConfirmResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Proces Confirm REST Response
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: null | :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment <ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException <ThirtyBees\\PostNL\\Exception\\ApiException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
	
	

.. rst-class:: public

	.. php:method:: public buildConfirmRequestSOAP( $confirming)
	
		
		:Parameters:
			* **$confirming** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\Confirming <ThirtyBees\\PostNL\\Entity\\Request\\Confirming>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processConfirmResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process Confirm SOAP response
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment <ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
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
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
	
	

