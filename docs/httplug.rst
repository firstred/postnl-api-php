HTTPlug
=======

Requests and responses can be logged for debugging purposes.
In order to enable logging you will need to pass a PSR-3 compatible logger.

.. code-block:: php

    <?php
    use League\Flysystem\Adapter\Local;
    use League\Flysystem\Filesystem;

    use Psr\Log\LogLevel;
    use wappr\Logger;

    // Initialize the file system adapter
    $logfs = new Filesystem($adapter);

    // Set the DEBUG log level
    $logger = new Logger($logfs, LogLevel::DEBUG);

    // Set the filename format, we're creating one file for every minute of request/responses
    $logger->setFilenameFormat('Y-m-d H:i');

    // Set this logger for all services at once
    $postnl->setLogger($logger);

    // Set the logger for just the Labelling service
    $postnl->getLabellingService()->setLogger($logger);

.. note::

     This example used the Wappr logger. You can use any logger you like, as long as it implements the PSR-3 standard.
     The log level needs to be set at ``DEBUG``.
