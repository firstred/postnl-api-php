Track shipments
========

Shipping status service
-----------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/shippingstatus-webservice

.. code-block:: php

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

This service can be used to retrieve shipping statuses. For a short update use the `CurrentStatus` method, otherwise `CompleteStatus` will provide you with a long list containing the shipment's history.

Current Status by Barcode
~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the current status by Barcode

.. code-block:: php

     $postnl = new PostNL(...);
     $postnl->getCurrentStatus((new CurrentStatus())
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

     $postnl = new PostNL(...);
     $postnl->getCurrentStatusByReference((new CurrentStatusByReference())
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
.. warning::
    This is no longer supported by the PostNL API.

Current Status by Phase Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the current status by phase code. Note that the date range is required.

.. warning::
    This is no longer supported by the PostNL API

Complete Status by Barcode
~~~~~~~~~~~~~~~~~~~~~~~~~~

Gets the complete status by Barcode

.. code-block:: php

    $postnl = new PostNL(...);
    $postnl->getCompleteStatus((new CompleteStatus())
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

    $postnl = new PostNL(...);
    $postnl->getCompleteStatusByReference((new CompleteStatusByReference())
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

.. warning::
    This is no longer supported by the PostNL API.

Complete Status by Phase Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. warning::
    This is no longer supported by the PostNL API.


Get Signature
~~~~~~~~~~~~~

Gets the signature of the shipment when available. A signature can be accessed by barcode only.

.. code-block:: php

    $postnl = new PostNL(...);
    $postnl->getSignature(
        (new GetSignature())
            ->setShipment((new Shipment)
                ->setBarcode('3SDEVC23987423')
            )
    );

It accepts the following arguments

getsignature
    ``GetSignature`` - `required`

    The `GetSignature` object. It needs to have one `Shipment` set with a barcode.
