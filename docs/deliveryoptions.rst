Delivery options
========

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
