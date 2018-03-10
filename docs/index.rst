Welcome to the thirty bees' PostNL PHP library documentation!
=============================================================

These API bindings make it easy to connect to PostNL's CIF API, used for retrieving delivery options, printing shipment labels and finding shipment statuses.

   - Simple interface for connecting with either the legacy, SOAP or REST API.
   - Can merge PDF labels (both A6 and A4) and automatically sends concurrent requests when necessary.
   - Uses the following standards, some of the are:
      - PSR-7 interfaces for requests and responses. Build and process functions are provided so you can create your own mix of batch requests.
      - PSR-6 caching, so you can use your favorite cache for caching API responses.
      - PSR-3 logging. You can log the requests and responses for debugging purposes.
   - Abstracts away the SOAP and REST API, allowing you to focus on the code. The request and response object structures are based on the SOAP API.
   - Framework agnostic. You can use this library with any framework.
   - A custom HTTP client interface so you can use the HTTP client of your choice. Using the Guzzle client is strongly recommended.

.. code-block:: php

   <?php
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
   quickstart.rst
   services.rst
   httpclient.rst
   caching.rst
   logging.rst
   authors.rst

