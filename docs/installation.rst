.. _installation:

============
Installation
============

The recommended way to install the PostNL library is through
`Composer <https://getcomposer.org>`_. Composer is a dependency management tool
for PHP that allows you to declare the dependencies your project needs and
installs them into your project.

This chapter assumes that you meet all the requirements as described in the :ref:`overview` chapter.

Install composer with the instructions on this page: https://getcomposer.org/download/

Install the PostNL library:

.. code-block:: bash

    composer require firstred/postnl-api-php

You can optionally add the well-known `Guzzle <https://docs.guzzlephp.org/>`_ HTTP client as a dependency using composer:

.. code-block:: bash

    composer require guzzlehttp/guzzle

This library will prefer the `Guzzle client <https://docs.guzzlehttp.org/>`_ and automatically start using it instead of the built-in cURL-client.

.. note::

    After installing, you need to require Composer's autoloader somewhere in your project, which is not necessary if you are using a framework such as Laravel or Symfony, for example.

    You can require the autoloader as follows (assuming the ``vendor/`` dir is relative to your current directory):

    .. code-block:: php

        require_once 'vendor/autoload.php';

You can find out more on how to install Composer, configure autoloading, and
other best-practices for defining dependencies at `getcomposer.org <http://getcomposer.org>`_.

Bleeding edge
=============

During your development, you can keep up with the latest changes on the master
branch by setting the version requirement for this library to ``dev-1.2.x``.

.. code-block:: json

   {
      "require": {
         "firstred/postnl-api-php": "dev-1.2.x"
      }
   }

You will likely have to change you ``min-stability`` setting: https://getcomposer.org/doc/04-schema.md#minimum-stability
