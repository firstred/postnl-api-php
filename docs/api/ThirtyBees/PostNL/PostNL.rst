.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


PostNL
======


.. php:namespace:: ThirtyBees\PostNL

.. php:class:: PostNL


	.. rst-class:: phpdoc-description
	
		| Class PostNL
		
	
	:Implements:
		:php:interface:`Psr\\Log\\LoggerAwareInterface` 
	

Constants
---------

.. php:const:: MODE_REST = 1



.. php:const:: MODE_SOAP = 2



.. php:const:: MODE_LEGACY = 5



Properties
----------

.. php:attr:: public threeSCountries

	.. rst-class:: phpdoc-description
	
		| 3S \(or EU Pack Special\) countries
		
	
	:Type: array 


.. php:attr:: public a6positions

	.. rst-class:: phpdoc-description
	
		| A6 positions
		| \(index = amount of a6 left on the page\)
		
	
	:Type: array 


.. php:attr:: public static verifySslCerts

	.. rst-class:: phpdoc-description
	
		| Verify SSL certificate of the PostNL REST API
		
	
	:Type: bool 


.. php:attr:: protected static token

	.. rst-class:: phpdoc-description
	
		| The PostNL REST API key or SOAP username/password to be used for requests\.
		
		| In case of REST the API key is the \`Password\` property of the \`UsernameToken\`
		| In case of SOAP this has to be a \`UsernameToken\` object, with the following requirements:
		|   \- When using the legacy API, the username has to be given\.
		|     The password has to be plain text\.
		|   \- When using the newer API \(launched August 2017\), do not pass a username \(\`null\`\)
		|     And pass the plaintext password\.
		
	
	:Type: string 


.. php:attr:: protected static customer

	.. rst-class:: phpdoc-description
	
		| The PostNL Customer to be used for requests\.
		
	
	:Type: :any:`\\ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` 


.. php:attr:: protected static sandbox

	.. rst-class:: phpdoc-description
	
		| Sandbox mode
		
	
	:Type: bool 


.. php:attr:: protected static httpClient

	:Type: :any:`\\ThirtyBees\\PostNL\\HttpClient\\ClientInterface <ThirtyBees\\PostNL\\HttpClient\\ClientInterface>` 


.. php:attr:: protected static logger

	:Type: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 


.. php:attr:: protected static mode

	.. rst-class:: phpdoc-description
	
		| This is the current mode
		
	
	:Type: int 


.. php:attr:: protected static barcodeService

	:Type: :any:`\\ThirtyBees\\PostNL\\Service\\BarcodeService <ThirtyBees\\PostNL\\Service\\BarcodeService>` 


.. php:attr:: protected static labellingService

	:Type: :any:`\\ThirtyBees\\PostNL\\Service\\LabellingService <ThirtyBees\\PostNL\\Service\\LabellingService>` 


.. php:attr:: protected static confirmingService

	:Type: :any:`\\ThirtyBees\\PostNL\\Service\\ConfirmingService <ThirtyBees\\PostNL\\Service\\ConfirmingService>` 


.. php:attr:: protected static shippingStatusService

	:Type: :any:`\\ThirtyBees\\PostNL\\Service\\ShippingStatusService <ThirtyBees\\PostNL\\Service\\ShippingStatusService>` 


.. php:attr:: protected static deliveryDateService

	:Type: :any:`\\ThirtyBees\\PostNL\\Service\\DeliveryDateService <ThirtyBees\\PostNL\\Service\\DeliveryDateService>` 


.. php:attr:: protected static timeframeService

	:Type: :any:`\\ThirtyBees\\PostNL\\Service\\TimeframeService <ThirtyBees\\PostNL\\Service\\TimeframeService>` 


.. php:attr:: protected static locationService

	:Type: :any:`\\ThirtyBees\\PostNL\\Service\\LocationService <ThirtyBees\\PostNL\\Service\\LocationService>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $customer, $token, $sandbox, $mode=self::MODE\_REST)
	
		.. rst-class:: phpdoc-description
		
			| PostNL constructor\.
			
		
		
		:Parameters:
			* **$customer** (:any:`ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>`)  
			* **$token** (:any:`ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken <ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken>` | string)  
			* **$sandbox** (bool)  
			* **$mode** (int)  Set the preferred connection strategy.
			Valid options are:
			  - `MODE_REST`: New REST API
			  - `MODE_SOAP`: New SOAP API
			  - `MODE_LEGACY`: Use the legacy API (the plug can
			     be pulled at any time)

		
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setToken( $token)
	
		.. rst-class:: phpdoc-description
		
			| Set the token
			
		
		
		:Parameters:
			* **$token** (string | :any:`\\ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken <ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\PostNL <ThirtyBees\\PostNL\\PostNL>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getRestApiKey()
	
		.. rst-class:: phpdoc-description
		
			| Get REST API Key
			
		
		
		:Returns: bool | string 
	
	

.. rst-class:: public

	.. php:method:: public getToken()
	
		.. rst-class:: phpdoc-description
		
			| Get UsernameToken object \(for SOAP\)
			
		
		
		:Returns: bool | :any:`\\ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken <ThirtyBees\\PostNL\\Entity\\SOAP\\UsernameToken>` 
	
	

.. rst-class:: public

	.. php:method:: public getCustomer()
	
		.. rst-class:: phpdoc-description
		
			| Get PostNL Customer
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>` 
	
	

.. rst-class:: public

	.. php:method:: public setCustomer( $customer)
	
		.. rst-class:: phpdoc-description
		
			| Set PostNL Customer
			
		
		
		:Parameters:
			* **$customer** (:any:`ThirtyBees\\PostNL\\Entity\\Customer <ThirtyBees\\PostNL\\Entity\\Customer>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\PostNL <ThirtyBees\\PostNL\\PostNL>` 
	
	

.. rst-class:: public

	.. php:method:: public getSandbox()
	
		.. rst-class:: phpdoc-description
		
			| Get sandbox mode
			
		
		
		:Returns: bool 
	
	

.. rst-class:: public

	.. php:method:: public setSandbox( $sandbox)
	
		.. rst-class:: phpdoc-description
		
			| Set sandbox mode
			
		
		
		:Parameters:
			* **$sandbox** (bool)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\PostNL <ThirtyBees\\PostNL\\PostNL>` 
	
	

.. rst-class:: public

	.. php:method:: public getMode()
	
		.. rst-class:: phpdoc-description
		
			| Get the current mode
			
		
		
		:Returns: int 
	
	

.. rst-class:: public

	.. php:method:: public setMode( $mode)
	
		.. rst-class:: phpdoc-description
		
			| Set current mode
			
		
		
		:Parameters:
			* **$mode** (int)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\PostNL <ThirtyBees\\PostNL\\PostNL>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getHttpClient()
	
		.. rst-class:: phpdoc-description
		
			| HttpClient
			
			| Automatically load Guzzle when available
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\HttpClient\\ClientInterface <ThirtyBees\\PostNL\\HttpClient\\ClientInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public setHttpClient( $client)
	
		.. rst-class:: phpdoc-description
		
			| Set the HttpClient
			
		
		
		:Parameters:
			* **$client** (:any:`ThirtyBees\\PostNL\\HttpClient\\ClientInterface <ThirtyBees\\PostNL\\HttpClient\\ClientInterface>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getLogger()
	
		.. rst-class:: phpdoc-description
		
			| Get the logger
			
		
		
		:Returns: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger=null)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\PostNL <ThirtyBees\\PostNL\\PostNL>` 
	
	

.. rst-class:: public

	.. php:method:: public getBarcodeService()
	
		.. rst-class:: phpdoc-description
		
			| Barcode service
			
			| Automatically load the barcode service
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Service\\BarcodeService <ThirtyBees\\PostNL\\Service\\BarcodeService>` 
	
	

.. rst-class:: public

	.. php:method:: public setBarcodeService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the barcode service
			
		
		
		:Parameters:
			* **$service** (:any:`ThirtyBees\\PostNL\\Service\\BarcodeService <ThirtyBees\\PostNL\\Service\\BarcodeService>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getLabellingService()
	
		.. rst-class:: phpdoc-description
		
			| Labelling service
			
			| Automatically load the labelling service
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Service\\LabellingService <ThirtyBees\\PostNL\\Service\\LabellingService>` 
	
	

.. rst-class:: public

	.. php:method:: public setLabellingService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the labelling service
			
		
		
		:Parameters:
			* **$service** (:any:`ThirtyBees\\PostNL\\Service\\LabellingService <ThirtyBees\\PostNL\\Service\\LabellingService>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getConfirmingService()
	
		.. rst-class:: phpdoc-description
		
			| Confirming service
			
			| Automatically load the confirming service
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Service\\ConfirmingService <ThirtyBees\\PostNL\\Service\\ConfirmingService>` 
	
	

.. rst-class:: public

	.. php:method:: public setConfirmingService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the confirming service
			
		
		
		:Parameters:
			* **$service** (:any:`ThirtyBees\\PostNL\\Service\\ConfirmingService <ThirtyBees\\PostNL\\Service\\ConfirmingService>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getShippingStatusService()
	
		.. rst-class:: phpdoc-description
		
			| Shipping status service
			
			| Automatically load the shipping status service
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Service\\ShippingStatusService <ThirtyBees\\PostNL\\Service\\ShippingStatusService>` 
	
	

.. rst-class:: public

	.. php:method:: public setShippingStatusService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the shipping status service
			
		
		
		:Parameters:
			* **$service** (:any:`ThirtyBees\\PostNL\\Service\\ShippingStatusService <ThirtyBees\\PostNL\\Service\\ShippingStatusService>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getDeliveryDateService()
	
		.. rst-class:: phpdoc-description
		
			| Delivery date service
			
			| Automatically load the delivery date service
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Service\\DeliveryDateService <ThirtyBees\\PostNL\\Service\\DeliveryDateService>` 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDateService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the delivery date service
			
		
		
		:Parameters:
			* **$service** (:any:`ThirtyBees\\PostNL\\Service\\DeliveryDateService <ThirtyBees\\PostNL\\Service\\DeliveryDateService>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getTimeframeService()
	
		.. rst-class:: phpdoc-description
		
			| Timeframe service
			
			| Automatically load the timeframe service
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Service\\TimeframeService <ThirtyBees\\PostNL\\Service\\TimeframeService>` 
	
	

.. rst-class:: public

	.. php:method:: public setTimeframeService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the timeframe service
			
		
		
		:Parameters:
			* **$service** (:any:`ThirtyBees\\PostNL\\Service\\TimeframeService <ThirtyBees\\PostNL\\Service\\TimeframeService>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public getLocationService()
	
		.. rst-class:: phpdoc-description
		
			| Location service
			
			| Automatically load the location service
			
		
		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Service\\LocationService <ThirtyBees\\PostNL\\Service\\LocationService>` 
	
	

.. rst-class:: public

	.. php:method:: public setLocationService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the location service
			
		
		
		:Parameters:
			* **$service** (:any:`ThirtyBees\\PostNL\\Service\\LocationService <ThirtyBees\\PostNL\\Service\\LocationService>`)  

		
	
	

.. rst-class:: public

	.. php:method:: public generateBarcode( $type=3S, $range=null, $serie=null, $eps=false)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode
			
		
		
		:Parameters:
			* **$type** (string)  
			* **$range** (string)  
			* **$serie** (string)  
			* **$eps** (bool)  

		
		:Returns: string The barcode as a string
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException <ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException>` 
	
	

.. rst-class:: public

	.. php:method:: public generateBarcodeByCountryCode( $iso)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode by country code
			
		
		
		:Parameters:
			* **$iso** (string)  2-letter Country ISO Code

		
		:Returns: string The Barcode as a string
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException <ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException <ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException <ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException <ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException>` 
	
	

.. rst-class:: public

	.. php:method:: public generateBarcodesByCountryCodes( $isos)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode by country code
			
		
		
		:Parameters:
			* **$isos** (array)  key = iso code, value = amount of barcodes requested

		
		:Returns: array Country isos with the barcode as string
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException <ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException <ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException <ThirtyBees\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException <ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException>` 
	
	

.. rst-class:: public

	.. php:method:: public generateLabel( $shipment, $printertype=GraphicFile\|PDF, $confirm=true)
	
		
		:Parameters:
			* **$shipment** (:any:`ThirtyBees\\PostNL\\Entity\\Shipment <ThirtyBees\\PostNL\\Entity\\Shipment>`)  
			* **$printertype** (string)  
			* **$confirm** (bool)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse <ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse>` 
	
	

.. rst-class:: public

	.. php:method:: public generateLabels( $shipments, $printertype=GraphicFile\|PDF, $confirm=true, $merge=false, $format=\\ThirtyBees\\PostNL\\Entity\\Label::FORMAT\_A4, $positions=\[1 =\> true, 2 =\> true, 3 =\> true, 4 =\> true\])
	
		.. rst-class:: phpdoc-description
		
			| Generate or retrieve multiple labels
			
			| Note that instead of returning a GenerateLabelResponse this function can merge the labels and return a
			| string which contains the PDF with the merged pages as well\.
			
		
		
		:Parameters:
			* **$shipments** (:any:`ThirtyBees\\PostNL\\Entity\\Shipment\[\] <ThirtyBees\\PostNL\\Entity\\Shipment>`)  (key = ID) Shipments
			* **$printertype** (string)  Printer type, see PostNL dev docs for available types
			* **$confirm** (bool)  Immediately confirm the shipments
			* **$merge** (bool)  Merge the PDFs and return them in a MyParcel way
			* **$format** (int)  A4 or A6
			* **$positions** (array)  Set the positions of the A6s on the first A4
			The indices should be the position number, marked with `true` or `false`
			These are the position numbers:
			```
			+-+-+
			|2|4|
			+-+-+
			|1|3|
			+-+-+
			```
			So, for
			```
			+-+-+
			|x|✔|
			+-+-+
			|✔|x|
			+-+-+
			```
			you would have to pass:
			```php
			[
			  1 => true,
			  2 => false,
			  3 => false,
			  4 => true,
			]
			```

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse\[\] <ThirtyBees\\PostNL\\Entity\\Response\\GenerateLabelResponse>` | string 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Exception <Exception>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
	
	

.. rst-class:: public

	.. php:method:: public confirmShipment( $shipment)
	
		.. rst-class:: phpdoc-description
		
			| Confirm a single shipment
			
		
		
		:Parameters:
			* **$shipment** (:any:`ThirtyBees\\PostNL\\Entity\\Shipment <ThirtyBees\\PostNL\\Entity\\Shipment>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment <ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
	
	

.. rst-class:: public

	.. php:method:: public confirmShipments( $shipments)
	
		.. rst-class:: phpdoc-description
		
			| Confirm multiple shipments
			
		
		
		:Parameters:
			* **$shipments** (array)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment\[\] <ThirtyBees\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
	
	

.. rst-class:: public

	.. php:method:: public getCurrentStatus( $currentStatus)
	
		.. rst-class:: phpdoc-description
		
			| Get the current status of a shipment
			
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
	
	

.. rst-class:: public

	.. php:method:: public getCompleteStatus( $completeStatus)
	
		.. rst-class:: phpdoc-description
		
			| Get the complete status of a shipment
			
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
	
	

.. rst-class:: public

	.. php:method:: public getSignature( $signature)
	
		.. rst-class:: phpdoc-description
		
			| Get the signature of a shipment
			
		
		
		:Parameters:
			* **$signature** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSignature <ThirtyBees\\PostNL\\Entity\\Request\\GetSignature>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Request\\GetSignature <ThirtyBees\\PostNL\\Entity\\Request\\GetSignature>` 
	
	

.. rst-class:: public

	.. php:method:: public getDeliveryDate( $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Get a delivery date
			
		
		
		:Parameters:
			* **$getDeliveryDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate <ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetDeliveryDateResponse>` 
	
	

.. rst-class:: public

	.. php:method:: public getSentDate( $getSentDate)
	
		.. rst-class:: phpdoc-description
		
			| Get a shipping date
			
		
		
		:Parameters:
			* **$getSentDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest <ThirtyBees\\PostNL\\Entity\\Request\\GetSentDateRequest>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetSentDateResponse>` 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframes( $getTimeframes)
	
		.. rst-class:: phpdoc-description
		
			| Get timeframes
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes <ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes <ThirtyBees\\PostNL\\Entity\\Response\\ResponseTimeframes>` 
	
	

.. rst-class:: public

	.. php:method:: public getNearestLocations( $getNearestLocations)
	
		.. rst-class:: phpdoc-description
		
			| Get nearest locations
			
		
		
		:Parameters:
			* **$getNearestLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations <ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetNearestLocationsResponse>` 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframesAndNearestLocations( $getTimeframes, $getNearestLocations, $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| All\-in\-one function for checkout widgets\. It retrieves and returns the
			| \- timeframes
			| \- locations
			| \- delivery date
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes <ThirtyBees\\PostNL\\Entity\\Request\\GetTimeframes>`)  
			* **$getNearestLocations** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations <ThirtyBees\\PostNL\\Entity\\Request\\GetNearestLocations>`)  
			* **$getDeliveryDate** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate <ThirtyBees\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: array \[uuid =\> ResponseTimeframes, uuid =\> GetNearestLocationsResponse, uuid =\> GetDeliveryDateResponse\]
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\HttpClientException <ThirtyBees\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\HttpClientException <ThirtyBees\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getLocationsInArea( $getLocationsInArea)
	
		.. rst-class:: phpdoc-description
		
			| Get locations in area
			
		
		
		:Parameters:
			* **$getLocationsInArea** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea <ThirtyBees\\PostNL\\Entity\\Request\\GetLocationsInArea>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
	
	

.. rst-class:: public

	.. php:method:: public getLocation( $getLocation)
	
		.. rst-class:: phpdoc-description
		
			| Get locations in area
			
		
		
		:Parameters:
			* **$getLocation** (:any:`ThirtyBees\\PostNL\\Entity\\Request\\GetLocation <ThirtyBees\\PostNL\\Entity\\Request\\GetLocation>`)  

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <ThirtyBees\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
	
	

.. rst-class:: public

	.. php:method:: public findBarcodeSerie( $type, $range, $eps)
	
		.. rst-class:: phpdoc-description
		
			| Find a suitable serie for the barcode
			
		
		
		:Parameters:
			* **$type** (string)  
			* **$range** (string)  
			* **$eps** (bool)  Indicates whether it is an EPS Shipment

		
		:Returns: string 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException <ThirtyBees\\PostNL\\Exception\\InvalidBarcodeException>` 
	
	

