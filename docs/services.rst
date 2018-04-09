Services
========

Barcode service
---------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/barcode-webservice/overview

The barcode service allows you to generate barcodes for your shipment labels.
Usually you would reserve an amount of barcodes, generate shipping labels and eventually confirm those labels.
According to PostNL, this flow is necessary for a higher delivery success rate.

Generate a single barcode
~~~~~~~~~~~~~~~~~~~~~~~~~

You can generate a single barcode for domestic shipments as follows:

.. code-block:: php

    <?php
    $postnl->generateBarcode();

This will generate a 3S barcode meant for domestic shipments only.

The function accepts the following arguments:

type
    ``string`` - `optional, defaults to 3S`

    The barcode type. This is 2S/3S for the Netherlands and EU Pack Special shipments.
    For other destinations this is your GlobalPack barcode type.
    For more info, check the `PostNL barcode service page <https://developer.postnl.nl/apis/barcode-webservice/how-use#toc-7>`_.

range
    ``string`` - `optional, can be found automatically`

     For domestic and EU shipments this is your customer code. Otherwise, your GlobalPack customer code.

serie
    ``string`` - `optional, can be found automatically`

    This is the barcode range for your shipment(s).
    Check the `PostNL barcode service page <https://developer.postnl.nl/apis/barcode-webservice/how-use#toc-7>`_
    for the ranges that are available.

eps
    ``bool`` - `optional, defaults to false`

    Indicates whether this is an EU Pack Special shipment.

Generate a barcode by country code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is possible to generate a barcode by country code. This will let the library figure out what
type, range, serie to use.

Example:

.. code-block:: php

    <?php
    $postnl->generateBarcodeByCountryCode('BE');

This will generate a 3S barcode meant for domestic shipments only.

The function accepts the following arguments:

iso
    ``string`` - `required`

    The two letter country ISO code. Make sure you use UPPERCASE.

Generate multiple barcodes by using country codes
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can generate a whole batch of barcodes at once by providing country codes and the
amounts you would like to generate.

Example:

.. code-block:: php

    <?php
    $postnl->generateBarcodeByCountryCode(['NL' => 2, 'DE' => 3]);

This will return a list of barcodes:

.. code-block:: php

    <?php
    [
        'NL' => [
            '3SDEVC11111111111',
            '3SDEVC22222222222',
        ],
        'DE' => [
            '3SDEVC111111111',
            '3SDEVC222222222',
            '3SDEVC333333333',
        ],
    ];

The function accepts the following argument:

type
    ``string`` - `required`

    An associative array with country codes as key and the amount of barcodes you'd like to generate
    per country as the value.

Labelling service
-----------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/labelling-webservice

The labelling service allows you to create shipment labels and optionally confirm the shipments.
The library has a built-in way to merge labels automatically, so you can request labels for multiple shipments at once.

Generate a single label
~~~~~~~~~~~~~~~~~~~~~~~

The following example generates a single shipment label for a domestic shipment:

.. code-block:: php

    <?php
    $postnl = new PostNL(...);
    $postnl->generateLabel(
        Shipment::create()
            ->setAddresses([
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
                Address::create([
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ]),
            ])
            ->setBarcode($barcode)
            ->setDeliveryAddress('01')
            ->setDimension(new Dimension('2000'))
            ->setProductCodeDelivery('3085'),
        'GraphicFile|PDF',
        false
    );

This will create a standard shipment (product code 3085). You can access the label (base64 encoded PDF) this way:

.. code-block:: php

    <?php
    $pdf = base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent());

This function accepts the following arguments:

shipment
    ``Shipment`` - `required`

    The Shipment object. Visit the PostNL API documentation to find out what a Shipment object consists of.

printertype
    ``string`` - `optional, defaults to GraphicFile|PDF`

    The list of supported printer types can be found on this page: https://developer.postnl.nl/browse-apis/send-and-track/labelling-webservice/documentation-soap/

confirm
    ``string`` - `optional, defaults to true`

    Indicates whether the shipment should immediately be confirmed.

Generate multiple shipment labels
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The following example shows how a label can be merged:

.. code-block:: php

    <?php
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

By setting the `merge` flag it will automatically merge the labels into a PDF string.

The function accepts the following arguments:

shipments
    ``Shipment[]`` - `required`

    The Shipment objects. Visit the PostNL API documentation to find out what a Shipment object consists of.

printertype
    ``string`` - `optional, defaults to GraphicFile|PDF`

    The list of supported printer types can be found on this page: https://developer.postnl.nl/browse-apis/send-and-track/labelling-webservice/documentation-soap/

confirm
    ``string`` - `optional, defaults to true`

    Indicates whether the shipment should immediately be confirmed.

merge
    ``bool`` - `optional, default to false`

    This will merge the labels and make the function return a pdf string of the merged label.

format
    ``int`` - `optional, defaults to 1 (FORMAT_A4)`

    This sets the paper format (can be A4 or A4).

positions
    ``bool[]`` - `optional, defaults to all positions`

    This will set the positions of the labels. The following image shows the available positions, use `true` or `false` to resp. enable or disable a position:

.. image:: img/positions.png

Confirming service
------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/confirming-webservice

You can confirm shipments that have previously not been confirmed. The available methods are `confirmShipment` and `confirmShipments`.
The first method accepts a single `Shipment` object whereas the latter accepts an array of `Shipment`s.
The output is a boolean, or an array with booleans in case you are confirming multiple shipments. The results will be tied to the keys of your request array.

Shipping status service
-----------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/shippingstatus-webservice

This service can be used to retrieve shipping statuses. For a short update use the `CurrentStatus` method, otherwise `CompleteStatus` will provide you with a long list containing the shipment's history.

Current Status by Barcode
~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the current status by Barcode

.. code-block:: php

    <?php
     $this->getClient()->getCurrentStatus((new CurrentStatus())
         ->setShipment(
             (new Shipment())
                 ->setBarcode('3SDEVC98237423')
         )
     );

statusrequest
    ``CurrentStatus`` - `required`

    The CurrentStatus object. Check the API documentation for all possibilities.


Current Status by Reference
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the current status by reference. Note that you must have set the reference on the shipment label first.

.. code-block:: php

    <?php
     $this->getClient()->getCurrentStatusByReference((new CurrentStatusByReference())
         ->setShipment(
             (new Shipment())
                 ->setReference('myref')
         )
     );

statusrequest
    ``CurrentStatusByReference`` - `required`

    The CurrentStatusByReference object. Check the API documentation for all possibilities.

Current Status by Status Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the current status by status.

.. code-block:: php

    <?php
     $this->getClient()->getCurrentStatusByStatus((new CurrentStatusByStatus())
         ->setShipment(
             (new Shipment())
                 ->setStatusCode('5')
         )
     );

statusrequest
    ``CurrentStatusByStatus`` - `required`

    The CurrentStatusByStatus object. Check the API documentation for all possibilities.

Current Status by Phase Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the current status by phase code. Note that the date range is required.

.. code-block:: php

    <?php
     $this->getClient()->getCurrentStatusByReference((new CurrentStatusByPhase())
         ->setShipment(
             (new Shipment())
                 ->setPhaseCode('5')
                 ->setDateFrom(date('d-m-Y H:i:s', strtotime('-7 days'))
                 ->setDateTo(date('d-m-Y H:i:s')
         )
     );

statusrequest
    ``CurrentStatusByPhase`` - `required`

    The CurrentStatusByPhase object. Check the API documentation for all possibilities.

Complete Status by Barcode
~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the complete status by Barcode

.. code-block:: php

    <?php
     $this->getClient()->getCompleteStatus((new CompleteStatus())
         ->setShipment(
             (new Shipment())
                 ->setBarcode('3SDEVC98237423')
         )
     );

statusrequest
    ``CompleteStatus`` - `required`

    The CompleteStatus object. Check the API documentation for all possibilities.

Complete Status by Reference
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the complete status by reference. Note that you must have set the reference on the shipment label first.

.. code-block:: php

    <?php
     $this->getClient()->getCompleteStatusByReference((new CompleteStatusByReference())
         ->setShipment(
             (new Shipment())
                 ->setReference('myref')
         )
     );

statusrequest
    ``CompleteStatusByReference`` - `required`

    The CompleteStatusByReference object. Check the API documentation for all possibilities.

Complete Status by Status Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the complete status by status.

.. code-block:: php

    <?php
     $this->getClient()->getCompleteStatusByStatus((new CompleteStatusByStatus())
         ->setShipment(
             (new Shipment())
                 ->setStatusCode('5')
         )
     );

statusrequest
    ``CompleteStatusByStatus`` - `required`

    The CompleteStatusByStatus object. Check the API documentation for all possibilities.

Complete Status by Phase Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the complete status by phase code. Note that the date range is required.

.. code-block:: php

    <?php
     $this->getClient()->getCompleteStatusByReference((new CompleteStatusByPhase())
         ->setShipment(
             (new Shipment())
                 ->setPhaseCode('5')
                 ->setDateFrom(date('d-m-Y H:i:s', strtotime('-7 days'))
                 ->setDateTo(date('d-m-Y H:i:s')
         )
     );

statusrequest
    ``CompleteStatusByPhase`` - `required`

    The CompleteStatusByPhase object. Check the API documentation for all possibilities.

Get Signature
~~~~~~~~~~~~~

Gets the signature of the shipment when available. A signature can be accessed by barcode only.

.. code-block:: php

    $this->getClient()->getSignature(
        (new GetSignature())
            ->setShipment((new Shipment)
                ->setBarcode('3SDEVC23987423')
            )
    );

It accepts the following arguments

getsignature
    ``GetSignature`` - `required`

    The `GetSignature` object. It needs to have one `Shipment` set with a barcode.

Delivery date service
---------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/deliverydate-webservice

Use the delivery date webservice to determine the delivery and shipping date.
You can use this service to calculate the dates 'live' and to make sure you do not promise your customers any timeframes that are no longer available.


Get the Delivery Date
~~~~~~~~~~~~~~~~~~~~~

Here's how you can retrieve the closest delivery date:

.. code-block:: php

    <?php

    $cutoffTime = '15:00:00';
    $dropoffDays = [1 => true, 2 => true, 3 => true, 4 => true, 5 => true, 6 => false, 7 => false];
    foreach (range(1, 7) as $day) {
        if (isset($dropoffDays[$day])) {
            $cutOffTimes[] = new CutOffTime(
                str_pad($day, 2, '0', STR_PAD_LEFT),
                date('H:i:00', strtotime($cutoffTime)),
                true
            );
        }
    }
    $deliveryDate = $postnl->getDeliveryDate(
        (new GetDeliveryDate())
            ->setGetDeliveryDate(
                (new GetDeliveryDate())
                    ->setAllowSundaySorting(false)
                    ->setCountryCode('NL')
                    ->setCutOffTimes($cutOffTimes)
                    ->setHouseNr('66')
                    ->setOptions(['Morning', 'Daytime'])
                    ->setPostalCode('2132WT')
                    ->setShippingDate(date('d-m-Y H:i:s'))
                    ->setShippingDuration('1')
            )
    );

The result will be a `GetDeliveryDateResponse`. Calling `getDeliveryDate` on this object will return the delivery date as a string in the `d-m-Y H:i:s` PHP date format.

The function accepts the following arguments

deliverydaterequest
    ``GetDeliveryDate`` - `required`

    The `GetDeliveryDate` request. See the API documentation for the possibilities.
    As shown in the example you will need to provide as many details as possible to get accurate availability information.

Get the Shipping Date
~~~~~~~~~~~~~~~~~~~~~

The Shipping Date service almost works in the same way as the Delivery Date service, except this time you provide the actual delivery date in order to calculate the closest shipping date.

.. code-block:: php

    <?php

    $cutoffTime = '15:00:00';
    $dropoffDays = [1 => true, 2 => true, 3 => true, 4 => true, 5 => true, 6 => false, 7 => false];
    foreach (range(1, 7) as $day) {
        if (isset($dropoffDays[$day])) {
            $cutOffTimes[] = new CutOffTime(
                str_pad($day, 2, '0', STR_PAD_LEFT),
                date('H:i:00', strtotime($cutoffTime)),
                true
            );
        }
    }
    $deliveryDate = $postnl->getDeliveryDate(
        (new GetDeliveryDate())
            ->setGetDeliveryDate(
                (new GetDeliveryDate())
                    ->setAllowSundaySorting(false)
                    ->setCountryCode('NL')
                    ->setCutOffTimes($cutOffTimes)
                    ->setHouseNr('66')
                    ->setOptions(['Morning', 'Daytime'])
                    ->setPostalCode('2132WT')
                    ->setShippingDate(date('d-m-Y H:i:s'))
                    ->setShippingDuration('1')
            )
    );

The function accepts the following arguments

shippingdaterequest
    ``GetSentDate`` - `required`

    The `GetSentDate` request. See the API documentation for the possibilities.
    As shown in the example you will need to provide as many details as possible to get accurate availability information.

Timeframe service
-----------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/timeframe-webservice

.. code-block::php

    <?php

    $deliveryDaysWindow = 7;
    $dropoffDelay = 0;

    $timeframes = $postnl->getTimeframes(new GetTimeframes())
        ->setTimeframe([
            (new Timeframe())
                ->setCountryCode('NL')
                ->setEndDate(date('d-m-Y', strtotime(" +{$deliveryDaysWindow} days +{$dropoffDelay} days")))
                ->setHouseNr('66')
                ->setOptions(['Daytime', 'Evening'])
                ->setPostalCode('2132WT')
                ->setStartDate(date('d-m-Y', strtotime(" +1 day +{$dropoffDelay} days")))
                ->setSundaySorting(false)
        ])
    );

timeframes
    ``GetTimeframes`` - `required`

    The `GetTimeframes` request object. See the API documentation for more details.

Location service
----------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/location-webservice

The location service allows you to retrieve a list of locations for the given postcode or coordinates.

Get Nearest Locations
~~~~~~~~~~~~~~~~~~~~~

Here's an example of how you can retrieve the nearest location by postcode:

.. code-block:: php

    <?php
    $postnl->getNearestLocations(
        (new GetNearestLocations())
            ->setCountrycode('NL')
            ->setLocation(
                (new Location())
                    ->setAllowSundaySorting(false)
                    ->setDeliveryOptions(['PG'])
                    ->setOptions(['Daytime'])
                    ->setHouseNr('66')
                    ->setPostalcode('2132WT')
            )
        );

nearestlocations
    ``GetNearestLocations`` - `required`

    The `GetNearestLocations` request object. See the API documentation for more details.

Get Nearest Locations by Coordinates
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can also get the locations by specifying a bounding box. One can be drawn by providing the North-West and South-East corner of the box:

.. code-block:: php

    <?php

     $postnl->getLocationsInArea(
         (new GetLocationsInArea())
             ->setCountrycode('NL')
             ->setLocation(
                 (new Location())
                     ->setAllowSundaySorting(false)
                     ->setDeliveryDate(date('d-m-Y', strtotime('+1 day')))
                     ->setDeliveryOptions([
                         'PG',
                     ])
                     ->setOptions([
                         'Daytime',
                     ])
                     ->setCoordinatesNorthWest(
                         (new CoordinatesNorthWest())
                             ->setLatitude((string) 52.156439)
                             ->setLongitude((string) 5.015643)
                     )
                     ->setCoordinatesSouthEast(
                         (new CoordinatesNorthWest())
                             ->setLatitude((string) 52.017473)
                             ->setLongitude((string) 5.065254)
                     )
             )
     );

This function accepts the arguments:

locationsinarea
    ``GetLocationsInArea`` - `required`

    The `GetLocationsInArea` request object. See the API documentation for more details.
