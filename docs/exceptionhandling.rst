.. _exception handling:

==================
Exception handling
==================

The following tree view describes how the exceptions used in this library depend
on each other.

.. code-block:: none

    . Exception : Throwable
    └── Firstred\PostNL\Exception\PostNLException
        ├── Firstred\PostNL\Exception\ApiException
        │   ├── Firstred\PostNL\Exception\ApiConnectionException
        │   ├── Firstred\PostNL\Exception\CifDownException
        │   ├── Firstred\PostNL\Exception\CifException
        │   ├── Firstred\PostNL\Exception\NotFoundException
        │   ├── Firstred\PostNL\Exception\ResponseException
        │   └── Firstred\PostNL\Exception\ShipmentNotFoundException
        ├── Firstred\PostNL\Exception\HttpClientException
        └── Firstred\PostNL\Exception\InvalidArgumentException
            ├── Firstred\PostNL\Exception\InvalidBarcodeException
            ├── Firstred\PostNL\Exception\InvalidConfigurationException
            ├── Firstred\PostNL\Exception\InvalidMethodException
            ├── Firstred\PostNL\Exception\NotImplementedException
            └── Firstred\PostNL\Exception\NotSupportedException

---------------
Exception types
---------------

This library throws several exceptions for errors that can occur.
In order to provide harmonized error handling for different API modes, several implementation details are left out.
For example, errors related to XML or JSON parsing are wrapped in a :php:class:`Firstred\\PostNL\\Exception\\ResponseException` exception.

If you want to catch all exceptions thrown by this library be sure to catch :php:class:`Firstred\\PostNL\\Exception\\PostNLException` s.
Under normal conditions there is no need to catch all :php:class:`Throwable` s.
If any other :php:class:`Throwable` such as :php:class:`Error`, :php:class:`TypeError` or :php:class:`Psr\Cache\InvalidArgumentException` is uncaught, it means that there is a bug somewhere in the library.
Please file a new issue with all the details you can find (preferably with the original request/response [be sure to scrub personal data]): `https://github.com/firstred/postnl-api-php/issues/new <https://github.com/firstred/postnl-api-php/issues/new>`_.

.. code-block:: php

    use Firstred\PostNL\Exception\PostNLException;
    use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;

    try {
        $postnl->getTimeframes(...);
    } catch (PostNLException $e) {
        // ...
    }

:php:class:`Firstred\\PostNL\\Exception\\ApiException`
======================================================

This groups of exceptions occurs when there is something wrong with the way the API returns an object (likely an unsupported feature or structure), when the API has trouble processing data, is either down or the requested object could not be found.

``deprecated`` :php:class:`Firstred\\PostNL\\Exception\\ApiConnectionException`
-------------------------------------------------------------------------------

This happens when the HTTP client has a problem connecting with the API. This exception has been replaced by the :php:class:`Firstred\\PostNL\\Exception\\HttpClientException` exception, which allows you to gather more detailed information.

:php:class:`Firstred\\PostNL\\Exception\\CifDownException`
----------------------------------------------------------

This exception is thrown when the CIF API is down.

:php:class:`Firstred\\PostNL\\Exception\\CifException`
------------------------------------------------------

When the CIF API itself has a fatal error this exception is thrown.

:php:class:`Firstred\\PostNL\\Exception\\NotFoundException`
-----------------------------------------------------------

This exception is thrown when the requested object could not be found.

:php:class:`Firstred\\PostNL\\Exception\\ResponseException`
-----------------------------------------------------------

This exception is thrown when a response could not be understood by the library. If there was a problem parsing the response, the ``previous`` argument might point at the underlying error.

.. confval:: deprecated
    :required: false

``deprecated`` :php:class:`Firstred\\PostNL\\Exception\\ShipmentNotFoundException`
----------------------------------------------------------------------------------

Occurs when the requested :php:class:`Firstred\\PostNL\\Entity\\Shipment` or :php:class:`Firstred\\PostNL\\Entity\\Response\\ResponseShipment` object could not be found.
This exception is deprecated and being replaced by a :php:class:`Firstred\\PostNL\\Exception\\NotFoundException`.

:php:class:`Firstred\\PostNL\\Exception\\HttpClientException`
=============================================================

All exceptions that occur in underlying HTTP Clients are handled by :php:class:`Firstred\\PostNL\\Exception\\HttpClientException` s.

:php:class:`Firstred\\PostNL\\Exception\\InvalidArgumentException`
==================================================================

Invalid inputs are handled by the group of :php:class:`Firstred\\PostNL\\Exception\\InvalidArgumentException` exceptions.

``deprecated`` :php:class:`Firstred\\PostNL\\Exception\\InvalidApiModeException`
--------------------------------------------------------------------------------

When an invalid API mode is selected, this exception is thrown.
This exception is deprecated, because the ability to select an API mode will be removed in the future.

:php:class:`Firstred\\PostNL\\Exception\\InvalidBarcodeException`
-----------------------------------------------------------------

This exception is thrown when there is a problem with generating a barcode. Usually caused by invalid input.

:php:class:`Firstred\\PostNL\\Exception\\InvalidConfigurationException`
-----------------------------------------------------------------------

When a problem occurs due to configuration errors, this exception is thrown. For example, an invalid API key.

:php:class:`Firstred\\PostNL\\Exception\\InvalidMethodException`
----------------------------------------------------------------

This happens when an invalid method has been called.

:php:class:`Firstred\\PostNL\\Exception\\NotImplementedException`
-----------------------------------------------------------------

When a feature has not been implemented, yet, you will see this exception thrown.

:php:class:`Firstred\\PostNL\\Exception\\NotSupportedException`
---------------------------------------------------------------

This occurs when a feature is not supported.