==========
Quickstart
==========

This page provides a quick introduction to this library and a few examples.
If you do not have the library installed, head over to the :ref:`installation`
page.


Making a Request
================

You can send requests by creating the request objects and passing them to one of the functions in the main ``PostNL``
class.


Requesting a merged label
-------------------------

Here is how you can request two labels and have them merged into a single PDF automatically:

.. code-block:: php

    <?php
    use ThirtyBees\PostNL\Entity\Label;
    use ThirtyBees\PostNL\PostNL;
    use ThirtyBees\PostNL\Entity\Customer;
    use ThirtyBees\PostNL\Entity\Address;
    use ThirtyBees\PostNL\Entity\Shipment;
    use ThirtyBees\PostNL\Entity\Dimension;

    require_once __DIR__.'/vendor/autoload.php';

    // Your PostNL credentials
    $customer = Customer::create([
        'CollectionLocation' => '123456',
        'CustomerCode'       => 'DEVC',
        'CustomerNumber'     => '11223344',
        'ContactPerson'      => 'Lesley',
        'Address'            => Address::create([
            'AddressType' => '02',
            'City'        => 'Hoofddorp',
            'CompanyName' => 'PostNL',
            'Countrycode' => 'NL',
            'HouseNr'     => '42',
            'Street'      => 'Siriusdreef',
            'Zipcode'     => '2132WT',
        ]),
        'Email'              => 'michael@thirtybees.com',
        'Name'               => 'Michael',
    ]);

    $apikey = 'YOUR_API_KEY_HERE';
    $sandbox = true;

    $postnl = new PostNL($customer, $apikey, $sandbox, PostNL::MODE_REST);

    $barcodes = $postnl->generateBarcodesByCountryCodes(['NL' => 2]);

    $shipments = [
        Shipment::create([
            'Addresses'           => [
                Address::create([
                    'AddressType' => '01',
                    'City'        => 'Utrecht',
                    'Countrycode' => 'NL',
                    'FirstName'   => 'Peter',
                    'HouseNr'     => '9',
                    'HouseNrExt'  => 'a bis',
                    'Name'        => 'de Ruijter',
                    'Street'      => 'Bilderdijkstraat',
                    'Zipcode'     => '3521VA',
                ]),
            ],
            'Barcode'             => $barcodes['NL'][0],
            'Dimension'           => new Dimension('1000'),
            'ProductCodeDelivery' => '3085',
        ]),
        Shipment::create([
            'Addresses'           => [
                Address::create([
                    'AddressType' => '01',
                    'City'        => 'Utrecht',
                    'Countrycode' => 'NL',
                    'FirstName'   => 'Peter',
                    'HouseNr'     => '9',
                    'HouseNrExt'  => 'a bis',
                    'Name'        => 'de Ruijter',
                    'Street'      => 'Bilderdijkstraat',
                    'Zipcode'     => '3521VA',
                ]),
            ],
            'Barcode'             => $barcodes['NL'][1],
            'Dimension'           => new Dimension('1000'),
            'ProductCodeDelivery' => '3085',
        ]),
    ];

    $label = $postnl->generateLabels(
        $shipments,
        'GraphicFile|PDF', // Printertype (only PDFs can be merged -- no need to use the Merged types)
        true, // Confirm immediately
        true, // Merge
        Label::FORMAT_A4, // Format -- this merges multiple A6 labels onto an A4
        [
            1 => true,
            2 => true,
            3 => true,
            4 => true,
        ] // Positions
    );

    file_put_contents('labels.pdf', $label);

This will write a ``labels.pdf`` file that looks like this:

//.. image:: img/mergedlabels.png

The PostNL client constructor accepts a few options:

``customer``
    (Customer) The ``Customer`` object that is used to configure the client and let PostNL know
    who requests the data.

    .. code-block:: php

        <?php
        // Create a new customer
        $client = new Customer::create([
          'CollectionLocation' => '123456',                    // Your collection location
          'CustomerCode'       => 'DEVC',                      // Your Customer Code
          'CustomerNumber'     => '11223344',                  // Your Customer Number
          'GlobalPackBarcodeType('CX'),                        // Add your GlobalPack information if you need
          'GlobalPackCustomerCode('1234'),                     // to create international shipment labels
          'ContactPerson'      => 'Lesley',
          'Address'            => Address::create([
              'AddressType' => '02',                           // This address will be shown on the labels
              'City'        => 'Hoofddorp',
              'CompanyName' => 'PostNL',
              'Countrycode' => 'NL',
              'HouseNr'     => '42',
              'Street'      => 'Siriusdreef',
              'Zipcode'     => '2132WT',
          ]),
          'Email'              => 'michael@thirtybees.com',
          'Name'               => 'Michael',
      ]);

``apikey``
    (string|UsernameToken) The ``apikey`` to use for the API. Note that if you want to switch from the legacy API to
    the new SOAP and REST API you will have to request a new key. The username can be omitted.
    If you want to connect to the legacy API you should pass a ``UsernameToken`` with your username and token set:

    .. code-block:: php

        <?php
        $usernameToken = new UsernameToken('username', 'token');

    You can request an API key for the sandbox environment on this page: https://developer.postnl.nl/content/request-api-key
    For a live key you should contact your PostNL account manager.

``sandbox``
    (bool) Indicate whether you'd like to connect to the sandbox environment. When `false` the library uses the live endpoints.

``mode``
    (int) This library provides three ways to connect to the API:

    - 1: REST mode
    - 2: SOAP mode
    - 5: Legacy mode -- This is the previous SOAP API, which at the moment of writing is still in operation.


Building Requests
=================

In most cases you would want to create request objects and pass them to one of the methods of the main object (``PostNL``).
One exception is the Barcode Service. You can directly request multiple barcodes and for multiple countries at once. The library
will internally handle the concurrent requests to the API.

In the above-mentioned merged label example we are passing two ``Shipment`` objects, filled with the needed information to generate the labels.
To merge those labels manually, we have to set the merge option to ``false`` and can omit both the ``format`` and ``positions`` parameters.
This will in turn make the library return ``GenerateLabelResponse`` objects.

These are in line with the ``GenerateLabelResponse`` nodes generated by the SOAP API, even when using the REST API.
The main reason for this standardization is that the SOAP API has better documentation. If you need a quick reference of
the ``GenerateLabelResponse`` object, you can either look up the code of the ``GenerateLabelResponse`` class or
`navigate to the API documentation directly <https://developer.postnl.nl/apis/labelling-webservice/documentation#toc-9>`_.

Sending concurrent requests
---------------------------

There is no direct need to manually handle concurrent requests. This library handles most cases automatically
and even provides a special function to quickly grab timeframe and location data for frontend delivery options widgets.

In case you manually want to send a custom mix of requests, you can look up the corresponding functions in the
Service class of your choice and call the ```buildXXXXXXRequest()``` functions manually. Thanks to the PSR-7 standard
used by this library you can use the ``Request`` object that is returned to access the full request that would otherwise
be sent directly. To pick up where you left off you can then grab the response and pass it to one of the ``processXXXXXXXResponse()```
functions of the Service class. The easiest method is to grab the raw HTTP message and parse it with the included PSR-7 library.
An example can be found in the `cURL client <https://github.com/thirtybees/postnl-api-php/blob/b3837cec23e1b8e806c5ea29d79d0fae82a0e956/src/HttpClient/CurlClient.php#L258>`_.

Using Response objects
======================

.. note::

    This section refers to Response objects returned by the library, not the standardized PSR-7 messages.

As soon as you've done your first request with this library, you will find that it returns a Response object.
As mentioned in the `Building Requests` section, these Response objects are based on the SOAP API, regardless of the mode set.
The properties of a Response object can be looked up in the code, but it can be a bit confusing at times, since the
Response object will likely not contain all properties at once. It often depends on the context of the request. For this reason,
you're better off by having a look at the `SOAP API documentation <https://developer.postnl.nl>`_ directly or by checking out some of
the examples in this documentation.

HTTP Client
===========

By default the library will use cURL or Guzzle when available. You can always switch HTTP clients as follows:

.. code-block:: php

    <?php
    $postnl = new PostNL(...);
    $postnl->setHttpClient(\ThirtyBees\PostNL\HttpClient\CurlClient::getInstance());

An HTTP client will need to implement the ``\ThirtyBees\PostNL\HttpClient\ClientInterface`` interface.

Caching
=======

PSR-6 caching is supported, which means you can grab any caching library for PHP that you like and plug it right into this library.

Note that not all services can be cached. At the moment cacheable services are:

    - Labelling webservice
    - Timeframes webservice
    - Location webservice
    - Deliverydate webservice
    - Shippingstatus webservice

To enable caching for a certain service you can use the following:

.. code-block:: php

    <?php
    use Cache\Adapter\Filesystem\FilesystemCachePool;
    use League\Flysystem\Adapter\Local;
    use League\Flysystem\Filesystem;

    // Cache in the `/cache` folder relative to this directory
    $filesystemAdapter = new Local(__DIR__.'/');
    $filesystem = new Filesystem($filesystemAdapter);

    $postnl = new PostNL(...);

    $labellingService = $postnl->getLabellingService();
    $labellingService->cache = new FilesystemCachePool($filesystem);

    // Set a TTL of 600 seconds
    $labellingService->ttl = 600;

    // Using a DateInterval (600 seconds)
    $labellingServiceervice->ttl = new DateInterval('PT600S');

    // Setting a deadline instead, useful for the timeframe service, so you can cache until the cut-off-time or
    // until the next day
    $labellingServiceervice = $postnl->getTimeframeService();
    $labellingService->ttl = new DateTime('14:00:00');

.. note::

    This example used the Flysystem (filesystem) cache. An extensive list of supported caches can be found on `this page <https://www.php-cache.com/en/latest/>`_.

Logging
=======

Requests and responses can be logged for debugging purposes.
In order to enable logging you will need to pass a PSR-3 compatible logger.

.. code-block:: php

    <?php
    use League\Flysystem\Adapter\Local;
    use League\Flysystem\Filesystem;

    use Psr\Log\LogLevel;
    use wappr\Logger;

    // Initialize the file system adapter
    $logfs = new Filesystem($adapter);

    // Set the DEBUG log level
    $logger = new Logger($logfs, LogLevel::DEBUG);

    // Set the filename format, we're creating one file for every minute of request/responses
    $logger->setFilenameFormat('Y-m-d H:i');

    // Set this logger for all services at once
    $postnl->setLogger($logger);

    // Set the logger for just the Labelling service
    $postnl->getLabellingService()->setLogger($logger);

.. note::

     This example used the Wappr logger. You can use any logger you like, as long as it implements the PSR-3 standard.
     The log level needs to be set at ``DEBUG``.
