.. _authentication:

==============
Authentication
==============

The PostNL API requires an API key to authenticate. You can request one via `MijnPostNL <https://mijn.postnl.nl/c/BP2_Mod_APIManagement.app>`_.

If you do not already have a PostNL account, check out this page: https://developer.postnl.nl/request-api-key/

The API key is automatically attached to the :php:class:`Firstred\\PostNL\\Entity\\SOAP\\UsernameToken` object (SOAP) or ``apikey`` HTTP header (REST).

-----------------------
Passing all credentials
-----------------------

Besides having to provide an API key, you will have to pass information about your business. These credentials will have to be passed with a :php:class:`Firstred\\PostNL\\Entity\\Customer` object when creating a new :php:class:`Firstred\\PostNL\\PostNL` instance.

.. note::

    The :php:class:`Firstred\\PostNL\\PostNL` class is the main class of this library. It handles all functionality you will need from a developer's perspective. After instantiating a new :php:class:`Firstred\\PostNL\\PostNL` object you will have everything you need to communicate with the PostNL API. Everything else (caching, HTTP Clients, logging, etc.) is optional.

In order to get started with the API, the following credentials are important:

Required credentials
====================

.. confval:: API key
    :required: true

    The API key

.. confval:: Customer code
    :required: true

    The customer code is a code that usually consists of 4 letters and appears in domestic 3S-codes.

.. confval:: Customer number
    :required: true

    The customer number is a number that usually consists of 8 digits.

.. confval:: Address

    A filled :php:class:`Firstred\\PostNL\\Entity\\Address` object with at least the following information:

    .. confval:: AddressType
        :required: true
        :default: ``02``

        The address type should be ``02``, which means the address belongs to the sender.

    .. confval:: City
        :required: true

        City

    .. confval:: CompanyName
        :required: true

        The company name

    .. confval:: HouseNr
        :required: true

        The house number

    .. confval:: Street
        :required: true

        Street name

    .. confval:: Zipcode
        :required: true

        The postcode. Be aware that the API might sometimes refer to a postcode as postcode, postal code or zipcode.

.. confval:: Collection location
    :required: true
    :default: ``123456``

    I must admit that to this day I still do not have a single clue what this value means.
    It could refer to your local drop-off location (if you use one). If your PostNL account manager can provide you with a collection location number please use that one.

    I usually fill out ``123456`` and it seems to work just fine.

.. confval:: Globalpack barcode type
    :required: false

    The barcode type to use for international shipments. This field is optional if you do not ship outside the EU.

    This field usually consists of 2 letters.

.. confval:: Globalpack customer code
    :required: false

    The barcode type to use for international shipments. This field is optional if you do not ship outside the EU.

    This field usually consists of 4 digits.


When you have all the required information, you are ready to configure the library. It can be configured as follows:

.. note::

    Example configuration. All the credential come together in the :php:class:`Firstred\\PostNL\\Entity\\Customer` and main :php:class:`Firstred\\PostNL\\PostNL` class.

    .. code-block:: php

        $apiKey = 'qjsdjufhjasudhfaSDFasdifh324';
        $customer = (new Customer())
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Test')
                ->setAddress(Address::create([
                    'AddressType' => '02',
                    'City'        => 'Hoofddorp',
                    'CompanyName' => 'PostNL',
                    'Countrycode' => 'NL',
                    'HouseNr'     => '42',
                    'Street'      => 'Siriusdreef',
                    'Zipcode'     => '2132WT',
                ]))
                ->setGlobalPackBarcodeType('AB')
                ->setGlobalPackCustomerCode('1234');

        $postnl = new PostNL(
            $customer,        // The filled Customer object
            $apiKey,          // The API key
            false,            // Sandbox = false, meaning we are now using the live environment
            PostNL::MODE_REST // We are going to use the REST API (default)
        );

    You might have noticed that several different ways have been used to instantiate an object. More information about this can be found in the :ref:`object instantiation` section.

The PostNL client constructor accepts a few options:

.. confval:: customer
    :required: true

    The :php:class:`Firstred\\PostNL\\Entity\\Customer` object that is used to configure the client and let PostNL know
    who is requesting the data.

    .. code-block:: php

        // Create a new customer
        $client = new Customer::create([
          'CollectionLocation' => '123456',                    // Your collection location
          'CustomerCode'       => 'DEVC',                      // Your Customer Code
          'CustomerNumber'     => '11223344',                  // Your Customer Number
          'GlobalPackBarcodeType('CX'),                        // Add your GlobalPack information if you need
          'GlobalPackCustomerCode('1234'),                     // to create international shipment labels
          'ContactPerson'      => 'Sander',
          'Address'            => Address::create([
              'AddressType' => '02',                           // This address will be shown on the labels
              'City'        => 'Hoofddorp',
              'CompanyName' => 'PostNL',
              'Countrycode' => 'NL',
              'HouseNr'     => '42',
              'Street'      => 'Siriusdreef',
              'Zipcode'     => '2132WT',
          ]),
          'Email'              => 'test@voorbeeld.nl',
          'Name'               => 'Michael',
      ]);

.. confval:: apiKey

    The API key to use. Note that if you want to switch from the legacy API to
    the new SOAP and REST API you will have to request a new key.

    If you want to connect to the legacy API, you should pass a :php:class:`Firstred\\PostNL\\Entity\\SOAP\\UsernameToken` with your username and token set:

    .. code-block:: php

        $usernameToken = new UsernameToken('username', 'token');

    You can request an API key for the sandbox environment on this page: https://developer.postnl.nl/content/request-api-key
    For a live key you should contact your PostNL account manager.



.. confval:: sandbox
    :required: true

    Indicate whether you'd like to connect to the sandbox environment. When `false` the library uses the live endpoints.

.. confval:: mode
    :required: true

    This library provides three ways to connect to the API:

    - :php:const:`Firstred\\PostNL::MODE_REST`: REST mode
    - :php:const:`Firstred\\PostNL::MODE_SOAP`: SOAP mode
    - :php:const:`Firstred\\PostNL::MODE_LEGACY`: Legacy mode -- This is the previous SOAP API, which, at the moment of writing, has been disabled.

-------------
Authorization
-------------

You may not be authorized to access all services. Contact your PostNL account manager to find out what's available to you.

