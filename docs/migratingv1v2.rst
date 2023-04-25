.. _migrating:

***********************
Migrating from v1 to v2
***********************

Version 2 of the library has largely stayed compatible with version 1 of the library. Notable changes are the
removal of support for the SOAP API and requiring PHP 8.1 as a minimum. It also reintroduces caching.

In order to upgrade, you can follow this guideline, with the help of an IDE:

- Upgrade to the latest version `v1.x.x` and check for deprecation notices. Avoid anything that is deprecated.

- HTTP clients have changed. If you relied on the HTTPlug client, you will have to either switch to the PSR-18 HTTP client or Async HTTP client. This is due to the deprecation of the synchronous part of the HTTPlug client.

- If you're using named arguments, check the differences between v1 and v2. There are small, but breaking changes due to different names and or parameter orders.

- Else, if you are not using named arguments, check the parameter orders. This is best done with an IDE with first-class support for PHP.

- If your code is interacting with the internal service classes directly, look for alternatives. You can now use request builders and response processors if you have to. Check the :ref:`advanced usage<advanced usage>` section for more details.
