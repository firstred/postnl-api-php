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

Confirming service
------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/confirming-webservice

Shipping status service
-----------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/shippingstatus-webservice

Delivery date service
---------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/deliverydate-webservice

Timeframe service
-----------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/timeframe-webservice

Location service
----------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/location-webservice
