HTTP Client
===========

By default the library will use cURL or Guzzle when available. You can always switch HTTP clients as follows:

.. code-block:: php

    <?php
    $postnl = new PostNL(...);
    $postnl->setHttpClient(\ThirtyBees\PostNL\HttpClient\CurlClient::getInstance());

An HTTP client will need to implement the ``\ThirtyBees\PostNL\HttpClient\ClientInterface`` interface.
