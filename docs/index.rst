.. _index:

Welcome to the unofficial PostNL PHP library documentation!
===========================================================

These API bindings make it easier to connect to PostNL's CIF API, used for retrieving delivery options, printing shipment labels and finding shipment statuses.

- It has a simple interface for connecting with either the SOAP or REST API.

- Abstracts away direct requests to the API, allowing you to focus on the code itself. The object structure is based on the SOAP API.

- Can merge PDF labels (both A6 and A4) and automatically sends concurrent requests when necessary, making batch processing a lot easier easier.

- Follows PHP standards, some of them are:

  - PSR-7 interfaces for requests and responses. Build and process functions are provided for every service so you can create your own mix of batch requests. See the `Firstred\\PostNL\\PostNL::getTimeframesAndNearestLocations <https://github.com/firstred/postnl-api-php/blob/b3f5c6e5a92edabb759ba32720b3fcb5a49635c0/src/PostNL.php#L2076-L2158>`_ method for an example.
    
  - PSR-6 caching, so you can use your favorite cache for caching API responses. Chapter :ref:`caching`.
    
  - PSR-3 logging. You can log the requests and responses for debugging purposes. More info on the page :ref:`logging`.

- Framework agnostic. You can use this library with any framework.

- A custom HTTP client interface so you can use the HTTP client of your choice. Using the `Guzzle <https://docs.guzzlehttp.org/>`_ or `Symfony HTTP client <https://symfony.com/doc/current/http_client.html>`_ is strongly recommended. Any HTTPlug client can be used by installing the related packages. See the :ref:`http client` chapter for more information.

.. code-block:: php

   $postnl = new PostNL(...);
   $timeframes = $postnl->getTimeframes(
       (new GetTimeframes())
           ->setTimeframe([Timeframe::create([
               'CountryCode'   => 'NL',
               'StartDate'     => date('d-m-Y', strtotime('+1 day')),
               'EndDate'       => date('d-m-Y', strtotime('+14 days')),
               'HouseNr'       => 42,
               'PostalCode'    => '2132WT',
               'SundaySorting' => true,
               'Options'       => ['Daytime', 'Evening'],
           ])])
   );
   var_dump($timeframes);

Developer Guide
---------------

.. toctree::
    :maxdepth: 3
    :glob:

    overview.rst
    installation.rst
    authentication.rst
    quickstart.rst
    deliveryoptions.rst
    sendandtrackshipments.rst
    exceptionhandling.rst
    formats.rst
    httpclient.rst
    caching.rst
    logging.rst
    advancedusage.rst
    reference/index.rst
    authors.rst

