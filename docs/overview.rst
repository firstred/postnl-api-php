.. _overview:

========
Overview
========

.. _requirements:

------------
Requirements
------------

Nowadays there are two APIs you can choose from: SOAP or REST. PostNL's REST API provides all of the functionality and is currently the recommended way to connect.

.. _rest api requirements:

REST API Requirements
=====================

#. PHP 5.6 or higher (up to and including 8.2)
#. `JSON extension <https://www.php.net/manual/en/book.json.php>`_
#. An HTTP Client such as `Symfony's HTTP Client <https://symfony.com/doc/current/http_client.html>`_ (PostNL lib v1.3.0 or higher) or `Guzzle <https://docs.guzzlephp.org/>`_ (or at least have the `PHP cURL extension <https://www.php.net/manual/en/book.curl.php>`_ installed)
#. ``opcache.save_comments`` set to ``1``

.. _soap api requirements:

SOAP API Requirements
=====================

#. PHP 5.6 or higher (up to and including 8.2)
#. `JSON extension <https://www.php.net/manual/en/book.json.php>`_ (both the Shipping webservice and Shipping Status webservice can only be handled by the REST API)
#. `XMLWriter extension <https://www.php.net/manual/en/book.xmlwriter.php>`_
#. `XMLReader extension <https://www.php.net/manual/en/book.xmlreader.php>`_
#. An HTTP Client such as `Symfony's HTTP Client <https://symfony.com/doc/current/http_client.html>`_ (PostNL lib v1.3.0 or higher) or `Guzzle <https://docs.guzzlephp.org/>`_ (or at least have the `PHP cURL extension <https://www.php.net/manual/en/book.curl.php>`_ installed)
#. ``opcache.save_comments`` set to ``1``

.. warning::

    Enabling the OPCache and setting ``opcache.save_comments`` to ``0`` will break this library since it depends on PHPDoc comments.

    You can quickly check your current settings with this snippet:

    .. code-block:: php

        echo "OPCache is ".opcache_enabled() ? "enabled\n" : "disabled\n";
        echo "opcache.save_comments is set to ".ini_get('opcache.save_comments') ? '1' : '0';

.. note::

    You can install any HTTP Client that is supported by the `HTTPlug <https://httplug.io/>`_ project. See chapter :ref:`http client` for more information.

.. note::

   If you use the Guzzle client, you do not need to have the cURL extension installed.
   As an alternative, you can enable ``allow_url_fopen`` in your system's php.ini. The included Guzzle version can
   work with the PHP stream wrapper to handle HTTP requests. For more information check out
   `Guzzle's documentation <http://guzzle.readthedocs.io/en/stable/overview.html>`_.

.. _license:

-------
License
-------

Licensed using the `MIT license <http://opensource.org/licenses/MIT>`_.

    The MIT License (MIT).

    Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
    associated documentation files (the "Software"), to deal in the Software without restriction,
    including without limitation the rights to use, copy, modify, merge, publish, distribute,
    sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
    is furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all copies or
    substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
    NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
    DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


.. _contributing:

------------
Contributing
------------

.. _contributing guidelines:

Guidelines
==========

1. This library supports PSR-1, PSR-2, PSR-3, PSR-4, PSR-6, PSR-7 and PSR-18.
2. The library is meant to be lean, fast and sticks to the standards of the SOAP API. This means
   that not every feature request can be accepted. When in doubt, please open an issue first.
3. The PostNL library has a minimum PHP version requirement of PHP 5.6. Pull requests must
   not require a PHP version greater than PHP 5.6.
4. All pull requests must include unit tests to ensure the change works as
   expected and to prevent regressions.


Running the tests
=================

In order to contribute, you'll need to checkout the source from GitHub and
install the dependencies using Composer:

.. code-block:: bash

    git clone https://github.com/firstred/postnl-api-php.git
    cd postnl-api-php && composer install

This library is unit tested with PHPUnit. Run the tests using the included PHPUnit version:

.. code-block:: bash

    composer test

.. note::

    You'll need to use PHP 7.3 or newer in order to perform
    the tests.


Building the documentation
==========================

The documentation is automatically built and hosted on readthedocs.io. You can build a local HTML copy by installing `Sphinx <https://www.sphinx-doc.org/>`_ and running

.. code-block:: bash

    pip install -r docs/requirements.txt

to install the requirements, followed by

.. code-block:: bash

    sphinx-build -b html docs builddir

to build the HTML output in the directory ``builddir``.
