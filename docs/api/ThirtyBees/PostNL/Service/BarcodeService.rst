.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


BarcodeService
==============


.. php:namespace:: ThirtyBees\PostNL\Service

.. php:class:: BarcodeService


	.. rst-class:: phpdoc-description
	
		| Class BarcodeService
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Service\\AbstractService`
	

Constants
---------

.. php:const:: VERSION = 1\.1



.. php:const:: SANDBOX_ENDPOINT = https://api\-sandbox\.postnl\.nl/shipment/v1\_1/barcode



.. php:const:: LIVE_ENDPOINT = https://api\.postnl\.nl/shipment/v1\_1/barcode



.. php:const:: LEGACY_SANDBOX_ENDPOINT = https://testservice\.postnl\.com/CIF\_SB/BarcodeWebService/1\_1/BarcodeWebService\.svc



.. php:const:: LEGACY_LIVE_ENDPOINT = https://service\.postnl\.com/CIF/BarcodeWebService/1\_1/BarcodeWebService\.svc



.. php:const:: SOAP_ACTION = http://postnl\.nl/cif/services/BarcodeWebService/IBarcodeWebService/GenerateBarcode



.. php:const:: ENVELOPE_NAMESPACE = http://schemas\.xmlsoap\.org/soap/envelope/



.. php:const:: SERVICES_NAMESPACE = http://postnl\.nl/cif/services/BarcodeWebService/



.. php:const:: DOMAIN_NAMESPACE = http://postnl\.nl/cif/domain/BarcodeWebService/



Properties
----------

.. php:attr:: protected static postnl

	:Type: :any:`\\ThirtyBees\\PostNL\\PostNL <ThirtyBees\\PostNL\\PostNL>` 


.. php:attr:: public namespaces

	.. rst-class:: phpdoc-description
	
		| Namespaces uses for the SOAP version of this service
		
	
	:Type: array 


Methods
-------

.. rst-class:: public

	.. php:method:: public generateBarcodeREST( $generateBarcode)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode
			
		
		
		:Parameters:
			* **$generateBarcode** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode <ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode>`)  

		
		:Returns: string | null Barcode
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

	.. php:method:: public generateBarcodesREST( $generateBarcodes)
	
		.. rst-class:: phpdoc-description
		
			| Generate multiple barcodes at once
			
		
		
		:Parameters:
			* **$generateBarcodes** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode\[\] <ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode>`)  

		
		:Returns: string[] | :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException\[\] <ThirtyBees\\PostNL\\Exception\\ResponseException>` | :any:`\\ThirtyBees\\PostNL\\Exception\\ApiException\[\] <ThirtyBees\\PostNL\\Exception\\ApiException>` | :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException\[\] <ThirtyBees\\PostNL\\Exception\\CifDownException>` | :any:`\\ThirtyBees\\PostNL\\Exception\\CifException\[\] <ThirtyBees\\PostNL\\Exception\\CifException>` Barcodes
	
	

.. rst-class:: public

	.. php:method:: public generateBarcodeSOAP( $generateBarcode)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode
			
		
		
		:Parameters:
			* **$generateBarcode** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode <ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode>`)  

		
		:Returns: string Barcode
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
	
	

.. rst-class:: public

	.. php:method:: public generateBarcodesSOAP( $generateBarcodes)
	
		.. rst-class:: phpdoc-description
		
			| Generate multiple barcodes at once
			
		
		
		:Parameters:
			* **$generateBarcodes** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode\[\] <ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode>`)  

		
		:Returns: string[] Barcodes
	
	

.. rst-class:: public

	.. php:method:: public buildGenerateBarcodeRequestREST( $generateBarcode)
	
		.. rst-class:: phpdoc-description
		
			| Build the \`generateBarcode\` HTTP request for the REST API
			
		
		
		:Parameters:
			* **$generateBarcode** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode <ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGenerateBarcodeResponseREST( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GenerateBarcode REST response
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: array 
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

	.. php:method:: public buildGenerateBarcodeRequestSOAP( $generateBarcode)
	
		.. rst-class:: phpdoc-description
		
			| Build the \`generateBarcode\` HTTP request for the SOAP API
			
		
		
		:Parameters:
			* **$generateBarcode** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode <ThirtyBees\\PostNL\\Entity\\Request\\GenerateBarcode>`)  

		
		:Returns: :any:`\\GuzzleHttp\\Psr7\\Request <GuzzleHttp\\Psr7\\Request>` 
	
	

.. rst-class:: public

	.. php:method:: public processGenerateBarcodeResponseSOAP( $response)
	
		.. rst-class:: phpdoc-description
		
			| Process GenerateBarcode SOAP response
			
		
		
		:Parameters:
			* **$response** (mixed)  

		
		:Returns: string 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifDownException <ThirtyBees\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\CifException <ThirtyBees\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\ResponseException <ThirtyBees\\PostNL\\Exception\\ResponseException>` 
	
	

