.. _caching:

=======
Caching
=======

PSR-6 caching is supported, which means you can grab any caching library for PHP that you like and plug it right into this library.
Make sure you install a PSR-20 clock implementation as well, e.g.:

.. code-block:: bash

    composer require symfony/cache symfony/clock


Note that not all services can be cached. At the moment cacheable services are:

    - Timeframes webservice
    - Location webservice
    - DeliveryDate webservice
    - ShippingStatus webservice

To enable caching for a certain service you can use the following:

.. code-block:: php

    <?php

    use Symfony\Component\Clock\NativeClock;
    use Symfony\Component\Cache\Adapter\FilesystemAdapter;

    $postnl = new PostNL(...);

    $deliveryDateService = $postnl->getDeliveryDateService();

    // Set a clock first or else it will be automatically set to :php:class:`Symfony\Component\Clock\NativeClock` when available.
    $clock = new NativeClock();
    $deliveryDateService->clock = $clock;

    // Cache in the `/cache` folder relative to this directory
    $cache = new FilesystemAdapter(directory: __DIR__.'/cache/');
    $deliveryDateService->cache = $cache;

    // Set a TTL of 600 seconds
    $deliveryDateService->ttl = 600;

    // Using a DateInterval (600 seconds)
    $deliveryDateService->ttl = new DateInterval('PT600S');

    // Setting a deadline instead, useful for the delivery date service, so you can cache until the cut-off-time
    $cutOffTime = '18:00:00';

    // You can also dynamically retrieve this from a request entity:
    // $cutOffTime = $getDeliveryDateRequest->getCutOffTimes()[1]; // Monday cut-off time

    $deliveryDateService->ttl = new DateTime('18:00:00');

Here's a full (recommended) example for all services:

.. code-block:: php

    <?php

    use Symfony\Component\Clock\NativeClock;
    use Symfony\Component\Cache\Adapter\FilesystemAdapter;

    $cutOffTimeToday = '18:00:00';

    $postnl = new PostNL(...);

    $deliveryDateService = $postnl->getDeliveryDateService();
    $timeframesService = $postnl->getTimeframesService();
    $locationService = $postnl->getLocationService();
    $shippingStatusService = $postnl->getDeliveryDateService();

    // Set a clock first or else it will be automatically set to :php:class:`Symfony\Component\Clock\NativeClock` when available.
    $clock = new NativeClock();

    // Cache in the `/cache` folder relative to this directory
    $cache = new FilesystemAdapter(directory: __DIR__.'/cache/');

    $deliveryDateService->clock = $clock;
    $deliveryDateService->cache = $cache;
    $deliveryDateService->ttl = new DateTime($cutOffTimeToday);

    $timeframesService->clock = $clock;
    $timeframesService->cache = $cache;
    $timeframesService->ttl = new DateTime($cutOffTimeToday);

    $locationService->clock = $clock;
    $locationService->cache = $cache;
    $locationService->ttl = new DateTime('23:59:59');

    $shippingStatusService->clock = $clock;
    $shippingStatusService->cache = $cache;
    $shippingStatusService->ttl = 5 * 60; // Prevent hitting the rate-limit by retrieving updates at most every 5 minutes

.. note::

    This example used the Symfony (filesystem) cache. An extensive list of supported caches can be found on `this page <https://www.php-cache.com/en/latest/>`_.
