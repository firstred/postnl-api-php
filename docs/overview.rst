========
Overview
========

Requirements
============

#. PHP 5.6 or higher (up to and including 8.0)
#. JSON extension
#. (optional) XML Support [SimpleXMLElement] if you'd like to use the SOAP API
#. By default this library utilizes cURL for communication.
#. To use the cURL client, you must have a recent version of cURL >= 7.19.4
   compiled with OpenSSL and zlib.
# You can install any HTTP Client that is supported by the `HTTPlug <https://httplug.io/>`_ project. See :ref:`HTTP Client` for more information.

.. note::

   If you use the Guzzle client, you do not need to have the cURL extension installed.
   As an alternative, you can enable ``allow_url_fopen`` in your system's php.ini. The included Guzzle version can
   work with the PHP stream wrapper to handle HTTP requests. For more information check out
   `Guzzle's documentation <http://guzzle.readthedocs.io/en/stable/overview.html>`_.

.. _installation:

Installation
============

The recommended way to install the PostNL library is with
`Composer <https://getcomposer.org>`_. Composer is a dependency management tool
for PHP that allows you to declare the dependencies your project needs and
installs them into your project.

Install composer with the instructions on this page: https://getcomposer.org/download/

Install the PostNL library:

.. code-block:: bash

    composer require firstred/postnl-api-php

You can optionally add Guzzle as a dependency using the composer.phar CLI:

.. code-block:: bash

    composer require guzzlehttp/guzzle

Alternatively, you can specify Guzzle as a dependency in your project's
existing composer.json file:

.. code-block:: js

    {
      "require": {
         "guzzlehttp/guzzle": "^7.0"
      }
   }

After installing, you need to require Composer's autoloader:

.. code-block:: php

    require 'vendor/autoload.php';

You can find out more on how to install Composer, configure autoloading, and
other best-practices for defining dependencies at `getcomposer.org <http://getcomposer.org>`_.


Bleeding edge
-------------

During your development, you can keep up with the latest changes on the master
branch by setting the version requirement for this library to ``~1.0@dev``.

.. code-block:: js

   {
      "require": {
         "firstred/postnl-api-php": "^1.2"
      }
   }


License
=======

Licensed using the `MIT license <http://opensource.org/licenses/MIT>`_.

    The MIT License (MIT).

    Copyright (c) 2017-2021 Michael Dekker (https://github.com/firstred)

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


Contributing
============


Guidelines
----------

1. This library utilizes PSR-1, PSR-2, PSR-3, PSR-4, PSR-6 and PSR-7.
2. The library is meant to be lean, fast and sticks to the standards of the SOAP API. This means
   that not every feature request will be accepted.
3. The PostNL library has a minimum PHP version requirement of PHP 5.6.1. Pull requests must
   not require a PHP version greater than PHP 5.6.1.
4. All pull requests must include unit tests to ensure the change works as
   expected and to prevent regressions.


Running the tests
-----------------

In order to contribute, you'll need to checkout the source from GitHub and
install the dependencies using Composer:

.. code-block:: bash

    git clone https://github.com/firstred/postnl-api-php.git
    cd postnl-api-php && curl -s http://getcomposer.org/installer | php && ./composer.phar install --dev

This library is unit tested with PHPUnit. Run the tests using the included PHPUnit version:

.. code-block:: bash

    cd tests/
    php ../vendor/bin/phpunit --testdox

.. note::

    You'll need to use PHP 7.3 or newer in order to perform
    the tests.
