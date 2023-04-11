.. _advanced usage:

==============
Advanced usage
==============

This section describes more advanced ways to use this library. The main class :php:class:`Firstred\\PostNL\\PostNL` and separate service classes (such as :php:class:`Firstred\\PostNL\\Service\\BarcodeService`) provide more ways to interact with the API.

.. _object instantiation:

--------------------
Object instantiation
--------------------

There are four ways in which entities can be instantiated. Either by

#. passing all arguments to the constructor in the right order
#. or using named parameters,
#. invoking the `create` method on an entity (deprecated
#. or by instantiating an empty entity and calling the setters one by one.

| Which method to use is entirely up to you. They are all supported by the library.
| However, if you use an IDE with code completion then the safest ways to use are (2) using named parameters (PHP 8) or by calling the setters (4), one by one.
| Even without using an editor with code completion you might benefit from using methods (2) and (4) since you will be able to detect errors earlier in the process.

.. tabs::

    .. tab:: 1 - Constructor

        .. code-block:: php

            // Your PostNL credentials
            $customer = new Customer(
                '11223344',
                'DEVC',
                '123456',
                'Sander',
                'test@voorbeeld.nl',
                'Michael',
                new Address(
                    '02',
                    'PostNL',
                    'Siriusdreef',
                    '42',
                    '2132WT',
                    'Hoofddorp',
                    'NL',
                ),
            );

    .. tab:: 2 - Constructor named args

        .. code-block:: php

            // Your PostNL credentials
            $customer = new Customer(
                CustomerNumber: '11223344',
                CustomerCode: 'DEVC',
                CollectionLocation: '123456',
                ContactPerson: 'Sander',
                Email: 'test@voorbeeld.nl',
                Name: 'Michael',
                Address: new Address(
                    AddressType: '02',
                    CompanyName: 'PostNL',
                    Street: 'Siriusdreef',
                    HouseNr: '42',
                    Zipcode: '2132WT',
                    City: 'Hoofddorp',
                    Countrycode: 'NL',
                ),
            );

    .. tab:: 3 - Create (deprecated)

        .. code-block:: php

            $customer = Customer::create([
                'CustomerNumber'     => '11223344',
                'CustomerCode'       => 'DEVC',
                'CollectionLocation' => '123456',
                'ContactPerson'      => 'Sander',
                'Email'              => 'test@voorbeeld.nl',
                'Name'               => 'Michael',
                'Address'            => Address::create([
                    'AddressType' => '02',
                    'CompanyName' => 'PostNL',
                    'Street'      => 'Siriusdreef',
                    'HouseNr'     => '42',
                    'Zipcode'     => '2132WT',
                    'City'        => 'Hoofddorp',
                    'Countrycode' => 'NL',
                ]),
            ]);

    .. tab:: 4 - Setters

        .. code-block:: php

            $customer = (new Customer())
                ->setCustomerNumber('11223344')
                ->setCustomerCode('DEVC')
                ->setCollectionLocation('123456')
                ->setContactPerson('Sander')
                ->setEmail('test@voorbeeld.nl')
                ->setName('Michael')
                ->setAddress((new Address())
                    ->setAddressType('02')
                    ->setCompanyName('PostNL')
                    ->setStreet('Siriusdreef')
                    ->setHouseNr('42')
                    ->setZipcode('2132WT')
                    ->setCity('Hoofddorp')
                    ->setCountrycode('NL')
                );


--------------------------
Building requests manually
--------------------------

For most cases using the API through the (:php:class:`Firstred\\PostNL\\PostNL`) object would be sufficient. There might be times, however, when the main class does not align with your use case. This section aims to describe the process that is involved in creating requests, sending them and processing the responses.

Interacting with the API through this library
=============================================

In the above-mentioned merged label example we are passing two :php:class:`Firstred\\PostNL\\Entity\\Shipment` objects, filled with the needed information to generate the labels.
To merge those labels manually, we have to set the merge option to ``false`` and can omit both the ``format`` and ``positions`` parameters.
This will in turn make the library return :php:class:`Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse` objects.

These are in line with the :php:class:`Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse` nodes generated by the SOAP API, even when using the REST API.
The main reason for this standardization is that the initial version of this library was built for the SOAP API. If you need a quick reference of
the :php:class:`Firstred\\PostNL\\Entity\\Response\\GenerateLabelResponse` object, you can either look up the code of the `GenerateLabelResponse <https://github.com/firstred/postnl-api-php/blob/v1.2.x/src/Entity/Response/GenerateLabelResponse.php>`_ class or
`navigate to the API documentation directly <https://developer.postnl.nl/apis/labelling-webservice/documentation#toc-9>`_.

Sending concurrent requests manually
====================================

There is no direct need to manually handle concurrent requests. This library handles most cases automatically
and even provides a special function to quickly grab timeframe and location data for frontend delivery options widgets.

In case you manually want to send a custom mix of requests, you can look up the corresponding functions in the
Service class of your choice and call the ```buildXXXXXXRequest()``` functions manually. Thanks to the PSR-7 standard
used by this library you can use the :php:interface:`Psr\Http\Message\RequestInterface` object that is returned to access the full request that would otherwise
be sent directly. To pick up where you left off you can then grab the response and pass it to one of the ``processXXXXXXXResponse()```
functions of the Service class. The easiest method is to grab the raw HTTP message and parse it with the included PSR-7 library.
An example can be found in the `cURL client <https://github.com/firstred/postnl-api-php/blob/b3837cec23e1b8e806c5ea29d79d0fae82a0e956/src/HttpClient/CurlClient.php#L258>`_.

Processing Response objects
======================

.. note::

    This section refers to Response objects returned by the library, not the standardized PSR-7 messages.

As soon as you've done your first request with this library, you will find that it returns a Response object.
As mentioned in the `Building Requests` section, these Response objects are based on the SOAP API, regardless of the mode set.
The properties of a Response object can be looked up in the code, but it can be a bit confusing at times, since the
Response object will likely not contain all properties at once. It often depends on the context of the request. For this reason,
you're better off by having a look at the `SOAP API documentation <https://developer.postnl.nl>`_ directly or by checking out some of
the examples in this documentation.

