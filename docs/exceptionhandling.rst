.. _exception handling:

==================
Exception handling
==================

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

This library throws exceptions for errors that occur during a request.

- In the event of an API error a :php:class:`Firstred\\PostNL\\Exception\\ApiException` is thrown

  .. code-block:: php

      use Firstred\PostNL\Exception\ApiException;

      try {
          $postnl->getTimeframes(...);
      } catch (ApiException $e) {
          // ...
      }

- A :php:class:`Firstred\\PostNL\\Exception\\ResponseException` exception is thrown when a response could not be understood by the library.

- All exceptions that occur in underlying HTTP Clients are handled by :php:class:`Firstred\\PostNL\\Exception\\HttpClientException` s.

- Invalid inputs are handled by the :php:class:`Firstred\\PostNL\\Exception\\InvalidArgumentException` exceptions.

- In case of caching problems due to invalid keys, a :php:class:`Psr\\Cache\\InvalidArgumentException` is thrown.
  This could mean that the library is unable to utilize the configured caching library.

If you want to catch all exceptions thrown by this library be sure to catch both :php:class:`Firstred\\PostNL\\Exception\\PostNLException` s and :php:class:`Psr\\Cache\\InvalidArgumentException` s.

.. tabs::

    .. tab:: PHP 7.0 or lower

        .. code-block:: php

            use Firstred\PostNL\Exception\PostNLException;
            use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;

            try {
                $postnl->getTimeframes(...);
            } catch (PostNLException $e) {
                // ...
            } catch (PsrCacheInvalidArgumentException $e) {
                // ...
            }

    .. tab:: PHP 7.1 or higher

        .. code-block:: php

            use Firstred\PostNL\Exception\PostNLException;
            use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;

            try {
                $postnl->getTimeframes(...);
            } catch (PostNLException | PsrCacheInvalidArgumentException $e) {
                // ...
            }
