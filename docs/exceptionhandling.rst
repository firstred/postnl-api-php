.. _exception handling:

==================
Exception handling
==================

**Tree View**

The following tree view describes how the exceptions used in this library depend
on each other.

.. code-block:: none

    . \Exception
    ├── Firstred\PostNL\Exception\PostNLException
    │   ├── Firstred\PostNL\Exception\ApiException
    │   │   ├── Firstred\PostNL\Exception\ApiConnectionException
    │   │   ├── Firstred\PostNL\Exception\CifDownException
    │   │   ├── Firstred\PostNL\Exception\CifException
    │   │   ├── Firstred\PostNL\Exception\NotFoundException
    │   │   ├── Firstred\PostNL\Exception\ResponseException
    │   │   └── Firstred\PostNL\Exception\ShipmentNotFoundException
    │   ├── Firstred\PostNL\Exception\HttpClientException
    │   └── Firstred\PostNL\Exception\InvalidArgumentException
    │       ├── Firstred\PostNL\Exception\InvalidBarcodeException
    │       ├── Firstred\PostNL\Exception\InvalidConfigurationException
    │       ├── Firstred\PostNL\Exception\InvalidMethodException
    │       ├── Firstred\PostNL\Exception\NotImplementedException
    │       └── Firstred\PostNL\Exception\NotSupportedException
    └── Psr\Cache\InvalidArgumentException

Guzzle throws exceptions for errors that occur during a transfer.

- In the event of a networking error (connection timeout, DNS errors, etc.),
  a ``GuzzleHttp\Exception\RequestException`` is thrown. This exception
  extends from ``GuzzleHttp\Exception\TransferException``. Catching this
  exception will catch any exception that can be thrown while transferring
  requests.

  .. code-block:: php

      use GuzzleHttp\Psr7;
      use GuzzleHttp\Exception\RequestException;

      try {
          $client->request('GET', 'https://github.com/_abc_123_404');
      } catch (RequestException $e) {
          echo Psr7\Message::toString($e->getRequest());
          if ($e->hasResponse()) {
              echo Psr7\Message::toString($e->getResponse());
          }
      }

- A ``GuzzleHttp\Exception\ConnectException`` exception is thrown in the
  event of a networking error. This exception extends from
  ``GuzzleHttp\Exception\TransferException``.
