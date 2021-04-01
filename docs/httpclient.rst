***********
HTTP Client
***********

By default the library will use cURL or Guzzle when available. You can always switch HTTP clients as follows:

.. code-block:: php

    $postnl = new PostNL(...);
    $postnl->setHttpClient(\Firstred\PostNL\HttpClient\CurlClient::getInstance());

You can create a custom HTTP Client by implementing the ``\Firstred\PostNL\HttpClient\ClientInterface`` interface.
