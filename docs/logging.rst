.. _logging:

*******
Logging
*******

Requests and responses can be logged for debugging purposes.
In order to enable logging you will need to pass a PSR-3 compatible logger.

.. code-block:: php

    <?php

    use Monolog\Handler\StreamHandler;
    use Monolog\Level;
    use Monolog\Logger;

    $logger = new Logger(name: 'postnl_client');
    // Set the filename format, we're creating one file for every minute of request/responses
    $debugHandler = new StreamHandler(stream: __DIR__.'/logs/'.date(format: 'Y-m-d H:i').'.log', level: Level::Debug);
    $formatter = new Monolog\Formatter\LineFormatter(
        format: null,                     // Format of message in log, default [%datetime%] %channel%.%level_name%: %message% %context% %extra%\n
        dateFormat: null,                 // Datetime format
        allowInlineLineBreaks: true,      // allowInlineLineBreaks option, default false
        ignoreEmptyContextAndExtra: true  // ignoreEmptyContextAndExtra option, default false
    );
    $debugHandler->setFormatter(formatter: $formatter);
    $logger->pushHandler(handler: $debugHandler);

    // Set this logger for all services at once
    $postnl->setLogger($logger);

    // Set the logger for just the Labelling service
    $postnl->getLabellingService()->setLogger($logger);

.. note::

     This example used the Monolog logger. You can use any logger you like, as long as it implements the PSR-3 standard.
     To log all responses the level needs to be set at ``Debug``.
     For error responses you can set the debug level to ``Error``.
