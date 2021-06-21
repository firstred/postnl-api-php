.. _formats:

=======
Formats
=======

The API can be very inconsistent when it comes to returning times and dates, for example.
To standardize how some fields are handled, the library uses different formats.

--------------------------
Dates, Times and DateTimes
--------------------------

This library makes a distinction between Dates, Times and DateTimes. To normalize moments in time, this package returns :php:class:`DateTimeImmutable` objects when referring to a single point in time and uses strings for times.

The following definitions and formats are used:

.. confval:: Dates

    Dates refer to a specific moment in time; not specifying the time. Can be formatted as ``2020-02-03``.
    Is always a :php:class:`DateTimeImmutable` object.

.. confval:: Times

    Times refer to a certain moment on any given day. Can be formatted as ``12:12:12``.
    Is always a ``string`` and should always be formatted using the following `PHP date format <https://www.php.net/manual/en/datetime.format.php#refsect1-datetime.format-parameters>`_: ``H:i:s`` (Hours, minutes and seconds with leading zeros).

.. confval:: DateTimes

    DateTimes are referring to a specific date and time. They can be formatted for example as ``2021-02-03 12:12:12``.
    Is always a :php:class:`DateTimeImmutable` object.

.. note::

    Every :php:class:`DateTimeImmutable` object and time string returned by the library is adjusted to the timezone of the PostNL API (``Europe/Amsterdam``).
    Make sure your timezone is aligned correctly, or otherwise convert dates and times manually by adding/subtracting the time difference.

    You can check your PHP's configured timezone by printing the ``date.timezone`` setting:

    .. code-block:: php

        die(ini_get('date.timezone'));

.. _soap object structure:

---------------------
SOAP object structure
---------------------

Sometimes you will notice that the REST API documentation might return property names in singular whereas the library returns the plural version of a property. This is caused by the fact that the SOAP API returns most properties in plural format. An example is the shipping status service when requesting the current status of a shipment. The SOAP API would return an ``addresses`` property whereas REST returns ``address``. This is automatically converted to the :php:attr:`Firstred\\PostNL\\Entity\\Shipment::$Addresses` property by this library. Therefore, when in doubt, you can safely assume that plural is used.
