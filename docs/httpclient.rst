.. _http client:

===========
HTTP Client
===========

This library supports almost all available HTTP clients. There are several ways to configure the HTTP client that should be used.

If not passed to the :php:class:`Firstred\\PostNL\\PostNL` constructor or set with the :php:class:`Firstred\\PostNL\\PostNL::setHttpClient` method, the library will automatically check if HTTP clients are available in the following order:

#. `Guzzle client <https://docs.guzzlephp.org/>`_
#. `HTTPlug client <https://docs.php-http.org/en/latest/clients.html>`_, an `Asynchronous HTTP client <https://docs.php-http.org/en/latest/httplug/tutorial.html#using-an-asynchronous-client>`_, PSR-18 HTTP clients
#. Built-in cURL client

--------------------------------
Setting the HTTP client manually
--------------------------------

By default the library will use cURL or Guzzle when available. You can always switch HTTP clients as follows:

.. code-block:: php

    $postnl = new PostNL(...);
    $postnl->setHttpClient(\Firstred\PostNL\HttpClient\CurlClient::getInstance());

You can create a custom HTTP Client by implementing the ``\Firstred\PostNL\HttpClient\ClientInterface`` interface.

------------------------------------
Setting the HTTP client with HTTPlug
------------------------------------

Using auto-discovery with HTTPlug.

The following packages are required if you want to use HTTPlug:

.. code-block:: bash

    composer require php-http/discovery php-http/httplug php-http/message-factory psr/http-factory

**HTTPlug + Symfony HTTP Client example**

This package already requires a Message factory and HTTP factory implementation (``guzzlehttp/psr7``), so all we need to do is to install the client and its requirements according to the `official Symfony documentation <https://symfony.com/doc/current/http_client.html#httplug>`_:

.. code-block:: bash

    composer require symfony/http-client

If you haven't installed Guzzle itself, this library should now auto-detect the Symfony HTTP Client and use it through the HTTPlug bridge.

If you have installed Guzzle already, then you can still configure the PostNL library to use the Symfony HTTP Client. To do this, pass the new client to the :php:class:`Firstred\\PostNL\\PostNL` constructor or :php:meth:`Firstred\\PostNL\\PostNL::setHttpClient` method. Example:

.. code-block:: php

    use Symfony\Component\HttpClient\HttplugClient;
    use Firstred\PostNL\HttpClient\HTTPlugClient;

    $symfonyClient = new HttplugClient();

    $httpPlugBridgeClient = new HTTPlugClient($symfonyClient);

    $postnl = new PostNL($customer, null, $httpClient);

.. note::

    | A list of HTTP Client supported by HTTPlug can be found on the following page:
    | https://docs.php-http.org/en/latest/clients.html
