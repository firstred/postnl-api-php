.. _delivery options:

****************
Delivery options
****************

The PostNL API allows you to retrieve a list of predicted timeframes and a list of possible pickup locations. For timeframes you will have to use a certain date range and to get the nearest pickup locations you can use an address or geolocation.

There are two ways to gather timeframes and pickup locations. You can

#. combine the delivery date, timeframe and location webservices
#. or use the checkout service.

The checkout service is currently not supported, but this library contains an easy interface to combine the three separate services listed in this section and provides the same functionality, if not more.

This section lists all the ways in which you can retrieve delivery options, using three webservices. It is possible to request:

#. :ref:`delivery dates` (when a shipment could arrive, given the current shipping date)
#. :ref:`shipping dates` (when a shipment should be dispatched, given the predicted delivery date)
#. :ref:`timeframes`
#. :ref:`nearest locations`
#. :ref:`nearest locations by coordinates`

.. _checkout webservice:

Checkout
--------

On an e-commerce checkout page you will probably want to show timeframes and/or pickup locations based on the current day and cut-off window.
This library provides an interface to easily combine the three webservices required to show all the delivery options. It will simultaneously contact the three webservices and request a list of timeframes and pickup locations based on the given input.

An example of how the interface can be used can be found in the section :ref:`requesting timeframes location and delivery date at once`, part of the :ref:`quickstart` chapter.

.. _deliverydate webservice:

Deliverydate webservice
-----------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/deliverydate-webservice

Use the delivery date webservice to determine the delivery and shipping date.
You can use this service to calculate the dates 'live' and to make sure you do not promise your customers any timeframes that are no longer available.


.. _delivery dates:

Delivery dates
~~~~~~~~~~~~~~

Here's how you can retrieve the closest delivery date:

.. code-block:: php

    <?php

    use Firstred\PostNL\Entity\CutOffTime;
    use Firstred\PostNL\Entity\Request\GetDeliveryDate;

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

.. confval:: getDeliveryDate
    :required: true


    The :php:class:`Firstred\\PostNL\\Entity\\Request\\GetDeliveryDate` request object. See the API documentation for the possibilities.
    As shown in the example you will need to provide as many details as possible to get accurate availability information.


.. _shipping dates:

Shipping dates
~~~~~~~~~~~~~~

The Shipping Date service almost works in the same way as the Delivery Date service, except this time you provide the actual delivery date in order to calculate the closest shipping date.

.. code-block:: php

    <?php

    use Firstred\PostNL\Entity\Request\GetSentDate;
    use Firstred\PostNL\Entity\Request\GetSentDateRequest;

    $cutoffTime = '15:00:00';
    $deliveryDate = $postnl->getSentDate(
        (new GetSentDateRequest())
            ->setGetSentDate(
                (new GetSentDate())
                    ->setAllowSundaySorting(false)
                    ->setCountryCode('NL')
                    ->setHouseNr('66')
                    ->setOptions(['Morning', 'Daytime'])
                    ->setPostalCode('2132WT')
                    ->setDeliveryDate(date('d-m-Y H:i:s'))
                    ->setShippingDuration('1')
            )
    );

The function accepts the following arguments

.. confval:: getSentDate
    :required: true

    The :php:class:`Firstred\\PostNL\\Entity\\Request\\GetSentDate` request object. See the API documentation for the possibilities.
    As shown in the example you will need to provide as many details as possible to get accurate availability information.


.. _timeframe webservice:

Timeframe webservice
--------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/timeframe-webservice


.. _timeframes:

Timeframes
~~~~~~~~~~

.. code-block:: php

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

.. confval:: timeframes
    :required: true

    The :php:class:`Firstred\\PostNL\\Entity\\Request\\GetTimeframes` request object. See the API documentation for more details.


.. _location webservice:

Location webservice
-------------------

.. note::

    | PostNL API documentation for this service:
    | https://developer.postnl.nl/apis/location-webservice

The location service allows you to retrieve a list of locations for the given postcode or coordinates.


.. _nearest locations:

Nearest locations
~~~~~~~~~~~~~~~~~

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

.. confval:: getNearestLocations
    :required: true

    The :php:class:`Firstred\\PostNL\\Entity\\Request\\GetNearestLocations` request object. See the API documentation for more details.


.. _nearest locations by coordinates:

Nearest locations by coordinates
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

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

.. confval:: locationsInArea
    :required: true

    The :php:class:`Firstred\\PostNL\\Entity\\Request\\GetLocationsInArea` request object. See the API documentation for more details.
