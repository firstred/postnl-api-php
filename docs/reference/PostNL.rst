.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


PostNL
======


.. php:namespace:: Firstred\PostNL

.. php:class:: PostNL


	.. rst-class:: phpdoc-description
	
		| Class PostNL\.
		
	
	:Implements:
		:php:interface:`Psr\\Log\\LoggerAwareInterface` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($customer, $apiKey, $sandbox, $mode\)<Firstred\\PostNL\\PostNL::\_\_construct\(\)>`
* :php:meth:`public setToken\($apiKey\)<Firstred\\PostNL\\PostNL::setToken\(\)>`
* :php:meth:`public getRestApiKey\(\)<Firstred\\PostNL\\PostNL::getRestApiKey\(\)>`
* :php:meth:`public getToken\(\)<Firstred\\PostNL\\PostNL::getToken\(\)>`
* :php:meth:`public getCustomer\(\)<Firstred\\PostNL\\PostNL::getCustomer\(\)>`
* :php:meth:`public setCustomer\($customer\)<Firstred\\PostNL\\PostNL::setCustomer\(\)>`
* :php:meth:`public getSandbox\(\)<Firstred\\PostNL\\PostNL::getSandbox\(\)>`
* :php:meth:`public setSandbox\($sandbox\)<Firstred\\PostNL\\PostNL::setSandbox\(\)>`
* :php:meth:`public getMode\(\)<Firstred\\PostNL\\PostNL::getMode\(\)>`
* :php:meth:`public setMode\($mode\)<Firstred\\PostNL\\PostNL::setMode\(\)>`
* :php:meth:`public getHttpClient\(\)<Firstred\\PostNL\\PostNL::getHttpClient\(\)>`
* :php:meth:`public setHttpClient\($client\)<Firstred\\PostNL\\PostNL::setHttpClient\(\)>`
* :php:meth:`public getLogger\(\)<Firstred\\PostNL\\PostNL::getLogger\(\)>`
* :php:meth:`public setLogger\($logger\)<Firstred\\PostNL\\PostNL::setLogger\(\)>`
* :php:meth:`public resetLogger\(\)<Firstred\\PostNL\\PostNL::resetLogger\(\)>`
* :php:meth:`public getRequestFactory\(\)<Firstred\\PostNL\\PostNL::getRequestFactory\(\)>`
* :php:meth:`public setRequestFactory\($requestFactory\)<Firstred\\PostNL\\PostNL::setRequestFactory\(\)>`
* :php:meth:`public getResponseFactory\(\)<Firstred\\PostNL\\PostNL::getResponseFactory\(\)>`
* :php:meth:`public setResponseFactory\($responseFactory\)<Firstred\\PostNL\\PostNL::setResponseFactory\(\)>`
* :php:meth:`public getStreamFactory\(\)<Firstred\\PostNL\\PostNL::getStreamFactory\(\)>`
* :php:meth:`public setStreamFactory\($streamFactory\)<Firstred\\PostNL\\PostNL::setStreamFactory\(\)>`
* :php:meth:`public getBarcodeService\(\)<Firstred\\PostNL\\PostNL::getBarcodeService\(\)>`
* :php:meth:`public setBarcodeService\($service\)<Firstred\\PostNL\\PostNL::setBarcodeService\(\)>`
* :php:meth:`public getLabellingService\(\)<Firstred\\PostNL\\PostNL::getLabellingService\(\)>`
* :php:meth:`public setLabellingService\($service\)<Firstred\\PostNL\\PostNL::setLabellingService\(\)>`
* :php:meth:`public getConfirmingService\(\)<Firstred\\PostNL\\PostNL::getConfirmingService\(\)>`
* :php:meth:`public setConfirmingService\($service\)<Firstred\\PostNL\\PostNL::setConfirmingService\(\)>`
* :php:meth:`public getShippingStatusService\(\)<Firstred\\PostNL\\PostNL::getShippingStatusService\(\)>`
* :php:meth:`public setShippingStatusService\($service\)<Firstred\\PostNL\\PostNL::setShippingStatusService\(\)>`
* :php:meth:`public getDeliveryDateService\(\)<Firstred\\PostNL\\PostNL::getDeliveryDateService\(\)>`
* :php:meth:`public setDeliveryDateService\($service\)<Firstred\\PostNL\\PostNL::setDeliveryDateService\(\)>`
* :php:meth:`public getTimeframeService\(\)<Firstred\\PostNL\\PostNL::getTimeframeService\(\)>`
* :php:meth:`public setTimeframeService\($service\)<Firstred\\PostNL\\PostNL::setTimeframeService\(\)>`
* :php:meth:`public getLocationService\(\)<Firstred\\PostNL\\PostNL::getLocationService\(\)>`
* :php:meth:`public setLocationService\($service\)<Firstred\\PostNL\\PostNL::setLocationService\(\)>`
* :php:meth:`public getShippingService\(\)<Firstred\\PostNL\\PostNL::getShippingService\(\)>`
* :php:meth:`public setShippingService\($service\)<Firstred\\PostNL\\PostNL::setShippingService\(\)>`
* :php:meth:`public generateBarcode\($type, $range, $serie, $eps\)<Firstred\\PostNL\\PostNL::generateBarcode\(\)>`
* :php:meth:`public generateBarcodeByCountryCode\($iso\)<Firstred\\PostNL\\PostNL::generateBarcodeByCountryCode\(\)>`
* :php:meth:`public generateBarcodesByCountryCodes\($isos\)<Firstred\\PostNL\\PostNL::generateBarcodesByCountryCodes\(\)>`
* :php:meth:`public sendShipment\($shipment, $printertype, $confirm\)<Firstred\\PostNL\\PostNL::sendShipment\(\)>`
* :php:meth:`public sendShipments\($shipments, $printertype, $confirm, $merge, $format, $positions, $a6Orientation\)<Firstred\\PostNL\\PostNL::sendShipments\(\)>`
* :php:meth:`public generateLabel\($shipment, $printertype, $confirm\)<Firstred\\PostNL\\PostNL::generateLabel\(\)>`
* :php:meth:`public generateLabels\($shipments, $printertype, $confirm, $merge, $format, $positions, $a6Orientation\)<Firstred\\PostNL\\PostNL::generateLabels\(\)>`
* :php:meth:`public confirmShipment\($shipment\)<Firstred\\PostNL\\PostNL::confirmShipment\(\)>`
* :php:meth:`public confirmShipments\($shipments\)<Firstred\\PostNL\\PostNL::confirmShipments\(\)>`
* :php:meth:`public getCurrentStatus\($currentStatus\)<Firstred\\PostNL\\PostNL::getCurrentStatus\(\)>`
* :php:meth:`public getShippingStatusByBarcode\($barcode, $complete\)<Firstred\\PostNL\\PostNL::getShippingStatusByBarcode\(\)>`
* :php:meth:`public getShippingStatusesByBarcodes\($barcodes, $complete\)<Firstred\\PostNL\\PostNL::getShippingStatusesByBarcodes\(\)>`
* :php:meth:`public getShippingStatusByReference\($reference, $complete\)<Firstred\\PostNL\\PostNL::getShippingStatusByReference\(\)>`
* :php:meth:`public getShippingStatusesByReferences\($references, $complete\)<Firstred\\PostNL\\PostNL::getShippingStatusesByReferences\(\)>`
* :php:meth:`public getCompleteStatus\($completeStatus\)<Firstred\\PostNL\\PostNL::getCompleteStatus\(\)>`
* :php:meth:`public getUpdatedShipments\($dateTimeFrom, $dateTimeTo\)<Firstred\\PostNL\\PostNL::getUpdatedShipments\(\)>`
* :php:meth:`public getSignature\($signature\)<Firstred\\PostNL\\PostNL::getSignature\(\)>`
* :php:meth:`public getSignatureByBarcode\($barcode\)<Firstred\\PostNL\\PostNL::getSignatureByBarcode\(\)>`
* :php:meth:`public getSignaturesByBarcodes\($barcodes\)<Firstred\\PostNL\\PostNL::getSignaturesByBarcodes\(\)>`
* :php:meth:`public getDeliveryDate\($getDeliveryDate\)<Firstred\\PostNL\\PostNL::getDeliveryDate\(\)>`
* :php:meth:`public getSentDate\($getSentDate\)<Firstred\\PostNL\\PostNL::getSentDate\(\)>`
* :php:meth:`public getTimeframes\($getTimeframes\)<Firstred\\PostNL\\PostNL::getTimeframes\(\)>`
* :php:meth:`public getNearestLocations\($getNearestLocations\)<Firstred\\PostNL\\PostNL::getNearestLocations\(\)>`
* :php:meth:`public getTimeframesAndNearestLocations\($getTimeframes, $getNearestLocations, $getDeliveryDate\)<Firstred\\PostNL\\PostNL::getTimeframesAndNearestLocations\(\)>`
* :php:meth:`public getLocationsInArea\($getLocationsInArea\)<Firstred\\PostNL\\PostNL::getLocationsInArea\(\)>`
* :php:meth:`public getLocation\($getLocation\)<Firstred\\PostNL\\PostNL::getLocation\(\)>`
* :php:meth:`public findBarcodeSerie\($type, $range, $eps\)<Firstred\\PostNL\\PostNL::findBarcodeSerie\(\)>`
* :php:meth:`private checkEnvironment\(\)<Firstred\\PostNL\\PostNL::checkEnvironment\(\)>`


Constants
---------

.. php:const:: MODE_REST = 1



.. php:const:: MODE_SOAP = 2



.. php:const:: MODE_LEGACY = 2



Properties
----------

.. php:attr:: public threeSCountries

	.. rst-class:: phpdoc-description
	
		| 3S \(or EU Pack Special\) countries\.
		
	
	:Type: array 


.. php:attr:: public a6positions

	.. rst-class:: phpdoc-description
	
		| A6 positions
		| \(index = amount of a6 left on the page\)\.
		
	
	:Type: array 


.. php:attr:: public static verifySslCerts

	.. rst-class:: phpdoc-description
	
		| Verify SSL certificate of the PostNL REST API\.
		
	
	:Type: bool 
	:Deprecated:  


.. php:attr:: protected static apiKey

	.. rst-class:: phpdoc-description
	
		| The PostNL REST API key or SOAP username/password to be used for requests\.
		
		| In case of REST the API key is the \`Password\` property of the \`UsernameToken\`
		| In case of SOAP this has to be a \`UsernameToken\` object, with the following requirements:
		|   \- Do not pass a username \(\`null\`\)
		|     And pass the plaintext password\.
		
	
	:Type: string 


.. php:attr:: protected static customer

	.. rst-class:: phpdoc-description
	
		| The PostNL Customer to be used for requests\.
		
	
	:Type: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` 


.. php:attr:: protected static sandbox

	.. rst-class:: phpdoc-description
	
		| Sandbox mode\.
		
	
	:Type: bool 


.. php:attr:: protected static httpClient

	:Type: :any:`\\Firstred\\PostNL\\HttpClient\\ClientInterface <Firstred\\PostNL\\HttpClient\\ClientInterface>` 


.. php:attr:: protected static logger

	:Type: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 


.. php:attr:: protected static requestFactory

	:Type: :any:`\\Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\RequestFactoryInterface <Firstred\\PostNL\\Factory\\RequestFactoryInterface>` 


.. php:attr:: protected static responseFactory

	:Type: :any:`\\Psr\\Http\\Message\\ResponseFactoryInterface <Psr\\Http\\Message\\ResponseFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\ResponseFactoryInterface <Firstred\\PostNL\\Factory\\ResponseFactoryInterface>` 


.. php:attr:: protected static streamFactory

	:Type: :any:`\\Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\StreamFactoryInterface <Firstred\\PostNL\\Factory\\StreamFactoryInterface>` 


.. php:attr:: protected static mode

	.. rst-class:: phpdoc-description
	
		| This is the current mode\.
		
	
	:Type: int 


.. php:attr:: protected static barcodeService

	:Type: :any:`\\Firstred\\PostNL\\Service\\BarcodeServiceInterface <Firstred\\PostNL\\Service\\BarcodeServiceInterface>` 


.. php:attr:: protected static labellingService

	:Type: :any:`\\Firstred\\PostNL\\Service\\LabellingServiceInterface <Firstred\\PostNL\\Service\\LabellingServiceInterface>` 


.. php:attr:: protected static confirmingService

	:Type: :any:`\\Firstred\\PostNL\\Service\\ConfirmingServiceInterface <Firstred\\PostNL\\Service\\ConfirmingServiceInterface>` 


.. php:attr:: protected static shippingStatusService

	:Type: :any:`\\Firstred\\PostNL\\Service\\ShippingStatusServiceInterface <Firstred\\PostNL\\Service\\ShippingStatusServiceInterface>` 


.. php:attr:: protected static deliveryDateService

	:Type: :any:`\\Firstred\\PostNL\\Service\\DeliveryDateServiceInterface <Firstred\\PostNL\\Service\\DeliveryDateServiceInterface>` 


.. php:attr:: protected static timeframeService

	:Type: :any:`\\Firstred\\PostNL\\Service\\TimeframeServiceInterface <Firstred\\PostNL\\Service\\TimeframeServiceInterface>` 


.. php:attr:: protected static locationService

	:Type: :any:`\\Firstred\\PostNL\\Service\\LocationServiceInterface <Firstred\\PostNL\\Service\\LocationServiceInterface>` 


.. php:attr:: protected static shippingService

	:Type: :any:`\\Firstred\\PostNL\\Service\\ShippingServiceInterface <Firstred\\PostNL\\Service\\ShippingServiceInterface>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $customer, $apiKey, $sandbox, $mode=self::MODE\_REST)
	
		.. rst-class:: phpdoc-description
		
			| PostNL constructor\.
			
		
		
		:Parameters:
			* **$customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>`)  Customer object.
			* **$apiKey** (:any:`Firstred\\PostNL\\Entity\\SOAP\\UsernameToken <Firstred\\PostNL\\Entity\\SOAP\\UsernameToken>` | string)  API key or UsernameToken object.
			* **$sandbox** (bool)  Whether the testing environment should be used.
			* **$mode** (int)  Set the preferred connection strategy.
			Valid options are:
			- `MODE_REST`: New REST API
			- `MODE_SOAP`: New SOAP API
			- `MODE_LEGACY`: Not supported anymore, converts to `MODE_SOAP`

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setToken( $apiKey)
	
		.. rst-class:: phpdoc-description
		
			| Set the token\.
			
		
		
		:Parameters:
			* **$apiKey** (string | :any:`\\Firstred\\PostNL\\Entity\\SOAP\\UsernameToken <Firstred\\PostNL\\Entity\\SOAP\\UsernameToken>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\PostNL <Firstred\\PostNL\\PostNL>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getRestApiKey()
	
		.. rst-class:: phpdoc-description
		
			| Get REST API Key\.
			
		
		
		:Returns: bool | string 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getToken()
	
		.. rst-class:: phpdoc-description
		
			| Get UsernameToken object \(for SOAP\)\.
			
		
		
		:Returns: bool | :any:`\\Firstred\\PostNL\\Entity\\SOAP\\UsernameToken <Firstred\\PostNL\\Entity\\SOAP\\UsernameToken>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getCustomer()
	
		.. rst-class:: phpdoc-description
		
			| Get PostNL Customer\.
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setCustomer( $customer)
	
		.. rst-class:: phpdoc-description
		
			| Set PostNL Customer\.
			
		
		
		:Parameters:
			* **$customer** (:any:`Firstred\\PostNL\\Entity\\Customer <Firstred\\PostNL\\Entity\\Customer>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\PostNL <Firstred\\PostNL\\PostNL>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getSandbox()
	
		.. rst-class:: phpdoc-description
		
			| Get sandbox mode\.
			
		
		
		:Returns: bool 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setSandbox( $sandbox)
	
		.. rst-class:: phpdoc-description
		
			| Set sandbox mode\.
			
		
		
		:Parameters:
			* **$sandbox** (bool)  

		
		:Returns: :any:`\\Firstred\\PostNL\\PostNL <Firstred\\PostNL\\PostNL>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getMode()
	
		.. rst-class:: phpdoc-description
		
			| Get the current mode\.
			
		
		
		:Returns: int 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setMode( $mode)
	
		.. rst-class:: phpdoc-description
		
			| Set current mode\.
			
		
		
		:Parameters:
			* **$mode** (int)  

		
		:Returns: :any:`\\Firstred\\PostNL\\PostNL <Firstred\\PostNL\\PostNL>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getHttpClient()
	
		.. rst-class:: phpdoc-description
		
			| HttpClient\.
			
			| Automatically load Guzzle when available
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\HttpClient\\ClientInterface <Firstred\\PostNL\\HttpClient\\ClientInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setHttpClient( $client)
	
		.. rst-class:: phpdoc-description
		
			| Set the HttpClient\.
			
		
		
		:Parameters:
			* **$client** (:any:`Firstred\\PostNL\\HttpClient\\ClientInterface <Firstred\\PostNL\\HttpClient\\ClientInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getLogger()
	
		.. rst-class:: phpdoc-description
		
			| Get the logger\.
			
		
		
		:Returns: :any:`\\Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setLogger( $logger)
	
		.. rst-class:: phpdoc-description
		
			| Set the logger\.
			
		
		
		:Parameters:
			* **$logger** (:any:`Psr\\Log\\LoggerInterface <Psr\\Log\\LoggerInterface>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\PostNL <Firstred\\PostNL\\PostNL>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public resetLogger()
	
		.. rst-class:: phpdoc-description
		
			| Set a dummy logger
			
		
		
		:Returns: static 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getRequestFactory()
	
		.. rst-class:: phpdoc-description
		
			| Get PSR\-7 Request factory\.
			
		
		
		:Returns: :any:`\\Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\RequestFactoryInterface <Firstred\\PostNL\\Factory\\RequestFactoryInterface>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setRequestFactory( $requestFactory)
	
		.. rst-class:: phpdoc-description
		
			| Set PSR\-7 Request factory\.
			
		
		
		:Parameters:
			* **$requestFactory** (:any:`Psr\\Http\\Message\\RequestFactoryInterface <Psr\\Http\\Message\\RequestFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\RequestFactoryInterface <Firstred\\PostNL\\Factory\\RequestFactoryInterface>`)  

		
		:Returns: static 
		:Since: 1.2.0 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getResponseFactory()
	
		.. rst-class:: phpdoc-description
		
			| Get PSR\-7 Response factory\.
			
		
		
		:Returns: :any:`\\Psr\\Http\\Message\\ResponseFactoryInterface <Psr\\Http\\Message\\ResponseFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\ResponseFactoryInterface <Firstred\\PostNL\\Factory\\ResponseFactoryInterface>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setResponseFactory( $responseFactory)
	
		.. rst-class:: phpdoc-description
		
			| Set PSR\-7 Response factory\.
			
		
		
		:Parameters:
			* **$responseFactory** (:any:`Psr\\Http\\Message\\ResponseFactoryInterface <Psr\\Http\\Message\\ResponseFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\ResponseFactoryInterface <Firstred\\PostNL\\Factory\\ResponseFactoryInterface>`)  

		
		:Returns: static 
		:Since: 1.2.0 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getStreamFactory()
	
		.. rst-class:: phpdoc-description
		
			| Set PSR\-7 Stream factory\.
			
		
		
		:Returns: :any:`\\Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\StreamFactoryInterface <Firstred\\PostNL\\Factory\\StreamFactoryInterface>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setStreamFactory( $streamFactory)
	
		.. rst-class:: phpdoc-description
		
			| Set PSR\-7 Stream factory\.
			
		
		
		:Parameters:
			* **$streamFactory** (:any:`Psr\\Http\\Message\\StreamFactoryInterface <Psr\\Http\\Message\\StreamFactoryInterface>` | :any:`\\Firstred\\PostNL\\Factory\\StreamFactoryInterface <Firstred\\PostNL\\Factory\\StreamFactoryInterface>`)  

		
		:Returns: static 
		:Since: 1.2.0 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getBarcodeService()
	
		.. rst-class:: phpdoc-description
		
			| Barcode service\.
			
			| Automatically load the barcode service
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Service\\BarcodeServiceInterface <Firstred\\PostNL\\Service\\BarcodeServiceInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setBarcodeService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the barcode service\.
			
		
		
		:Parameters:
			* **$service** (:any:`Firstred\\PostNL\\Service\\BarcodeServiceInterface <Firstred\\PostNL\\Service\\BarcodeServiceInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getLabellingService()
	
		.. rst-class:: phpdoc-description
		
			| Labelling service\.
			
			| Automatically load the labelling service
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Service\\LabellingServiceInterface <Firstred\\PostNL\\Service\\LabellingServiceInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setLabellingService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the labelling service\.
			
		
		
		:Parameters:
			* **$service** (:any:`Firstred\\PostNL\\Service\\LabellingServiceInterface <Firstred\\PostNL\\Service\\LabellingServiceInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getConfirmingService()
	
		.. rst-class:: phpdoc-description
		
			| Confirming service\.
			
			| Automatically load the confirming service
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Service\\ConfirmingServiceInterface <Firstred\\PostNL\\Service\\ConfirmingServiceInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setConfirmingService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the confirming service\.
			
		
		
		:Parameters:
			* **$service** (:any:`Firstred\\PostNL\\Service\\ConfirmingServiceInterface <Firstred\\PostNL\\Service\\ConfirmingServiceInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getShippingStatusService()
	
		.. rst-class:: phpdoc-description
		
			| Shipping status service\.
			
			| Automatically load the shipping status service
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Service\\ShippingStatusServiceInterface <Firstred\\PostNL\\Service\\ShippingStatusServiceInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setShippingStatusService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the shipping status service\.
			
		
		
		:Parameters:
			* **$service** (:any:`Firstred\\PostNL\\Service\\ShippingStatusServiceInterface <Firstred\\PostNL\\Service\\ShippingStatusServiceInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getDeliveryDateService()
	
		.. rst-class:: phpdoc-description
		
			| Delivery date service\.
			
			| Automatically load the delivery date service
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Service\\DeliveryDateServiceInterface <Firstred\\PostNL\\Service\\DeliveryDateServiceInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDateService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the delivery date service\.
			
		
		
		:Parameters:
			* **$service** (:any:`Firstred\\PostNL\\Service\\DeliveryDateServiceInterface <Firstred\\PostNL\\Service\\DeliveryDateServiceInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframeService()
	
		.. rst-class:: phpdoc-description
		
			| Timeframe service\.
			
			| Automatically load the timeframe service
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Service\\TimeframeServiceInterface <Firstred\\PostNL\\Service\\TimeframeServiceInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setTimeframeService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the timeframe service\.
			
		
		
		:Parameters:
			* **$service** (:any:`Firstred\\PostNL\\Service\\TimeframeServiceInterface <Firstred\\PostNL\\Service\\TimeframeServiceInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getLocationService()
	
		.. rst-class:: phpdoc-description
		
			| Location service\.
			
			| Automatically load the location service
			
		
		
		:Returns: :any:`\\Firstred\\PostNL\\Service\\LocationServiceInterface <Firstred\\PostNL\\Service\\LocationServiceInterface>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public setLocationService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the location service\.
			
		
		
		:Parameters:
			* **$service** (:any:`Firstred\\PostNL\\Service\\LocationServiceInterface <Firstred\\PostNL\\Service\\LocationServiceInterface>`)  

		
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getShippingService()
	
		.. rst-class:: phpdoc-description
		
			| Shipping service\.
			
			| Automatically load the shipping service
			
		
		
		:Returns: mixed 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public setShippingService( $service)
	
		.. rst-class:: phpdoc-description
		
			| Set the shipping service\.
			
		
		
		:Parameters:
			* **$service** (:any:`Firstred\\PostNL\\Service\\ShippingServiceInterface <Firstred\\PostNL\\Service\\ShippingServiceInterface>`)  

		
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public generateBarcode( $type=\'3S\', $range=null, $serie=null, $eps=false)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode\.
			
		
		
		:Parameters:
			* **$type** (string)  
			* **$range** (string)  
			* **$serie** (string)  
			* **$eps** (bool)  

		
		:Returns: string The barcode as a string
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public generateBarcodeByCountryCode( $iso)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode by country code\.
			
		
		
		:Parameters:
			* **$iso** (string)  2-letter Country ISO Code

		
		:Returns: string The Barcode as a string
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public generateBarcodesByCountryCodes( $isos)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single barcode by country code\.
			
		
		
		:Parameters:
			* **$isos** (array)  key = iso code, value = amount of barcodes requested

		
		:Returns: array Country isos with the barcode as string
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public sendShipment( $shipment, $printertype=\'GraphicFile\|PDF\', $confirm=true)
	
		.. rst-class:: phpdoc-description
		
			| Send a single shipment\.
			
		
		
		:Parameters:
			* **$shipment** (:any:`Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>`)  
			* **$printertype** (string)  
			* **$confirm** (bool)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\SendShipmentResponse <Firstred\\PostNL\\Entity\\Response\\SendShipmentResponse>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public sendShipments( $shipments, $printertype=\'GraphicFile\|PDF\', $confirm=true, $merge=false, $format=Label::FORMAT\_A4, $positions=\[1 =\> true, 2 =\> true, 3 =\> true, 4 =\> true\], $a6Orientation=\'P\')
	
		.. rst-class:: phpdoc-description
		
			| Send multiple shipments\.
			
		
		
		:Parameters:
			* **$shipments** (:any:`Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>`)  Array of shipments
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
			* **$a6Orientation** (string)  A6 orientation (P or L)

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\SendShipmentResponse <Firstred\\PostNL\\Entity\\Response\\SendShipmentResponse>` | string 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public generateLabel( $shipment, $printertype=\'GraphicFile\|PDF\', $confirm=true)
	
		.. rst-class:: phpdoc-description
		
			| Generate a single label\.
			
		
		
		:Parameters:
			* **$shipment** (:any:`Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>`)  
			* **$printertype** (string)  
			* **$confirm** (bool)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse <Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public generateLabels( $shipments, $printertype=\'GraphicFile\|PDF\', $confirm=true, $merge=false, $format=Label::FORMAT\_A4, $positions=\[1 =\> true, 2 =\> true, 3 =\> true, 4 =\> true\], $a6Orientation=\'P\')
	
		.. rst-class:: phpdoc-description
		
			| Generate or retrieve multiple labels\.
			
			| Note that instead of returning a GenerateLabelResponse this function can merge the labels and return a
			| string which contains the PDF with the merged pages as well\.
			
		
		
		:Parameters:
			* **$shipments** (:any:`Firstred\\PostNL\\Entity\\Shipment\[\] <Firstred\\PostNL\\Entity\\Shipment>`)  (key = ID) Shipments
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
			* **$a6Orientation** (string)  A6 orientation (P or L)

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse\[\] <Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse>` | string 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\PostNLException <Firstred\\PostNL\\Exception\\PostNLException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException <setasign\\Fpdi\\PdfParser\\CrossReference\\CrossReferenceException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Filter\\FilterException <setasign\\Fpdi\\PdfParser\\Filter\\FilterException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\PdfParserException <setasign\\Fpdi\\PdfParser\\PdfParserException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException <setasign\\Fpdi\\PdfParser\\Type\\PdfTypeException>` 
		:Throws: :any:`\\setasign\\Fpdi\\PdfReader\\PdfReaderException <setasign\\Fpdi\\PdfReader\\PdfReaderException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public confirmShipment( $shipment)
	
		.. rst-class:: phpdoc-description
		
			| Confirm a single shipment\.
			
		
		
		:Parameters:
			* **$shipment** (:any:`Firstred\\PostNL\\Entity\\Shipment <Firstred\\PostNL\\Entity\\Shipment>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment <Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public confirmShipments( $shipments)
	
		.. rst-class:: phpdoc-description
		
			| Confirm multiple shipments\.
			
		
		
		:Parameters:
			* **$shipments** (array)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\ConfirmingResponseShipment>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCurrentStatus( $currentStatus)
	
		.. rst-class:: phpdoc-description
		
			| Get the current status of a shipment\.
			
			| This is a combi\-function, supporting the following:
			| \- CurrentStatus \(by barcode\):
			|   \- Fill the Shipment\-\>Barcode property\. Leave the rest empty\.
			| \- CurrentStatusByReference:
			|   \- Fill the Shipment\-\>Reference property\. Leave the rest empty\.
			
		
		
		:Parameters:
			* **$currentStatus** (:any:`Firstred\\PostNL\\Entity\\Request\\CurrentStatus <Firstred\\PostNL\\Entity\\Request\\CurrentStatus>` | :any:`\\Firstred\\PostNL\\Entity\\Request\\CurrentStatusByReference <Firstred\\PostNL\\Entity\\Request\\CurrentStatusByReference>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponse>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Since: 1.0.0 
		:Deprecated: 1.2.0 Use the dedicated methods \(get by phase and status are no longer working\)
	
	

.. rst-class:: public

	.. php:method:: public getShippingStatusByBarcode( $barcode, $complete=false)
	
		.. rst-class:: phpdoc-description
		
			| Get the current status of the given shipment by barcode\.
			
		
		
		:Parameters:
			* **$barcode** (string)  Pass a single barcode
			* **$complete** (bool)  Return the complete status (incl. shipment history)

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getShippingStatusesByBarcodes( $barcodes, $complete=false)
	
		.. rst-class:: phpdoc-description
		
			| Get the current statuses of the given shipments by barcodes\.
			
		
		
		:Parameters:
			* **$barcodes** (string[])  Pass multiple barcodes
			* **$complete** (bool)  Return the complete status (incl. shipment history)

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getShippingStatusByReference( $reference, $complete=false)
	
		.. rst-class:: phpdoc-description
		
			| Get the current status of the given shipment by reference\.
			
		
		
		:Parameters:
			* **$reference** (string)  Pass a single reference
			* **$complete** (bool)  Return the complete status (incl. shipment history)

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Http\\Discovery\\NotFoundException <Http\\Discovery\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ShipmentNotFoundException <Firstred\\PostNL\\Exception\\ShipmentNotFoundException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getShippingStatusesByReferences( $references, $complete=false)
	
		.. rst-class:: phpdoc-description
		
			| Get the current statuses of the given shipments by references\.
			
		
		
		:Parameters:
			* **$references** (string[])  Pass multiple references
			* **$complete** (bool)  Return the complete status (incl. shipment history)

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CurrentStatusResponseShipment>` | :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment\[\] <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponseShipment>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public deprecated

	.. php:method:: public getCompleteStatus( $completeStatus)
	
		.. rst-class:: phpdoc-description
		
			| Get the complete status of a shipment\.
			
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
			* **$completeStatus** (:any:`Firstred\\PostNL\\Entity\\Request\\CompleteStatus <Firstred\\PostNL\\Entity\\Request\\CompleteStatus>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse <Firstred\\PostNL\\Entity\\Response\\CompleteStatusResponse>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotFoundException <Firstred\\PostNL\\Exception\\NotFoundException>` 
		:Since: 1.0.0 
		:Deprecated: 1.2.0 Use the dedicated getShippingStatus\* methods \(get by phase and status are no longer working\)
	
	

.. rst-class:: public

	.. php:method:: public getUpdatedShipments( $dateTimeFrom=null, $dateTimeTo=null)
	
		.. rst-class:: phpdoc-description
		
			| Get updated shipments
			
		
		
		:Parameters:
			* **$dateTimeFrom** (:any:`DateTimeInterface <DateTimeInterface>` | null)  
			* **$dateTimeTo** (:any:`DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse\[\] <Firstred\\PostNL\\Entity\\Response\\UpdatedShipmentsResponse>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public deprecated

	.. php:method:: public getSignature( $signature)
	
		.. rst-class:: phpdoc-description
		
			| Get the signature of a shipment\.
			
		
		
		:Parameters:
			* **$signature** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSignature <Firstred\\PostNL\\Entity\\Request\\GetSignature>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature <Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature>` 
		:Since: 1.0.0 
		:Deprecated: 1.2.0 Use the getSignature\(s\)By\* alternatives
	
	

.. rst-class:: public

	.. php:method:: public getSignatureByBarcode( $barcode)
	
		.. rst-class:: phpdoc-description
		
			| Get the signature of a shipment\.
			
		
		
		:Parameters:
			* **$barcode** (string)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature <Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getSignaturesByBarcodes( $barcodes)
	
		.. rst-class:: phpdoc-description
		
			| Get the signature of a shipment\.
			
		
		
		:Parameters:
			* **$barcodes** (string[])  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature\[\] <Firstred\\PostNL\\Entity\\Response\\GetSignatureResponseSignature>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public getDeliveryDate( $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Get a delivery date\.
			
		
		
		:Parameters:
			* **$getDeliveryDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate <Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse <Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getSentDate( $getSentDate)
	
		.. rst-class:: phpdoc-description
		
			| Get a shipping date\.
			
		
		
		:Parameters:
			* **$getSentDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest <Firstred\\PostNL\\Entity\\Request\\GetSentDateRequest>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse <Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframes( $getTimeframes)
	
		.. rst-class:: phpdoc-description
		
			| Get timeframes\.
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`Firstred\\PostNL\\Entity\\Request\\GetTimeframes <Firstred\\PostNL\\Entity\\Request\\GetTimeframes>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes <Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getNearestLocations( $getNearestLocations)
	
		.. rst-class:: phpdoc-description
		
			| Get nearest locations\.
			
		
		
		:Parameters:
			* **$getNearestLocations** (:any:`Firstred\\PostNL\\Entity\\Request\\GetNearestLocations <Firstred\\PostNL\\Entity\\Request\\GetNearestLocations>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse <Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getTimeframesAndNearestLocations( $getTimeframes, $getNearestLocations, $getDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| All\-in\-one function for checkout widgets\. It retrieves and returns the
			| \- timeframes
			| \- locations
			| \- delivery date\.
			
		
		
		:Parameters:
			* **$getTimeframes** (:any:`Firstred\\PostNL\\Entity\\Request\\GetTimeframes <Firstred\\PostNL\\Entity\\Request\\GetTimeframes>`)  
			* **$getNearestLocations** (:any:`Firstred\\PostNL\\Entity\\Request\\GetNearestLocations <Firstred\\PostNL\\Entity\\Request\\GetNearestLocations>`)  
			* **$getDeliveryDate** (:any:`Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate <Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate>`)  

		
		:Returns: array \[
			    timeframes =\> ResponseTimeframes,
			    locations =\> GetNearestLocationsResponse,
			    delivery\_date =\> GetDeliveryDateResponse,
			\]
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifDownException <Firstred\\PostNL\\Exception\\CifDownException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\CifException <Firstred\\PostNL\\Exception\\CifException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\HttpClientException <Firstred\\PostNL\\Exception\\HttpClientException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Psr\\Cache\\InvalidArgumentException <Psr\\Cache\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ResponseException <Firstred\\PostNL\\Exception\\ResponseException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getLocationsInArea( $getLocationsInArea)
	
		.. rst-class:: phpdoc-description
		
			| Get locations in area\.
			
		
		
		:Parameters:
			* **$getLocationsInArea** (:any:`Firstred\\PostNL\\Entity\\Request\\GetLocationsInArea <Firstred\\PostNL\\Entity\\Request\\GetLocationsInArea>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <Firstred\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public getLocation( $getLocation)
	
		.. rst-class:: phpdoc-description
		
			| Get locations in area\.
			
		
		
		:Parameters:
			* **$getLocation** (:any:`Firstred\\PostNL\\Entity\\Request\\GetLocation <Firstred\\PostNL\\Entity\\Request\\GetLocation>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse <Firstred\\PostNL\\Entity\\Response\\GetLocationsInAreaResponse>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public findBarcodeSerie( $type, $range, $eps)
	
		.. rst-class:: phpdoc-description
		
			| Find a suitable serie for the barcode\.
			
		
		
		:Parameters:
			* **$type** (string)  
			* **$range** (string)  
			* **$eps** (bool)  Indicates whether it is an EPS Shipment

		
		:Returns: string 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidBarcodeException <Firstred\\PostNL\\Exception\\InvalidBarcodeException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: private

	.. php:method:: private checkEnvironment()
	
		.. rst-class:: phpdoc-description
		
			| Check whether this library will work in the current environment
			
		
		
		:Since: 1.2.0 
	
	

