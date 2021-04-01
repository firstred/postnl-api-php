Welcome to the unofficial PostNL PHP library documentation!
=============================================================

These API bindings make it easy to connect to PostNL's CIF API, used for retrieving delivery options, printing shipment labels and finding shipment statuses.

- It has a simple interface for connecting with either the SOAP or REST API.

- Abstracts away direct requests to the API, allowing you to focus on the code itself. The object structure is based on the SOAP API.

- Can merge PDF labels (both A6 and A4) and automatically sends concurrent requests when necessary, making batch processing a lot easier easier.

- Follows PHP standards, some of them are:

  - PSR-7 interfaces for requests and responses. Build and process functions are provided so you can create your own mix of batch requests.
    
  - PSR-6 caching, so you can use your favorite cache for caching API responses.
    
  - PSR-3 logging. You can log the requests and responses for debugging purposes.
    
- Framework agnostic. You can use this library with any framework.

- A custom HTTP client interface so you can use the HTTP client of your choice. Using the Guzzle or Symfony HTTP client is strongly recommended.

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
   quickstart.rst
   deliveryoptions.rst
   createshipments.rst
   trackshipments.rst
   httpclient.rst
   caching.rst
   logging.rst
   authors.rst

