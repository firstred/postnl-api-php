.. _caching:

=======
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
