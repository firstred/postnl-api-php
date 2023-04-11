> ⚠️ **This version is end-of-life**: maintenance ended on  Aug 9, 2020 ⚠️

# PostNL REST/SOAP API PHP Bindings

[![Build Status](https://travis-ci.org/firstred/postnl-api-php.svg?branch=master)](https://travis-ci.org/firstred/postnl-api-php)
[![Documentation Status](https://readthedocs.org/projects/postnl-php/badge/?version=latest)](https://postnl-php.readthedocs.io/en/latest/?badge=latest)
[![codecov](https://codecov.io/gh/firstred/postnl-api-php/branch/master/graph/badge.svg)](https://codecov.io/gh/firstred/postnl-api-php)
[![latest stable version](https://poser.pugx.org/firstred/postnl-api-php/v/stable.svg)](https://packagist.org/packages/thirtybees/postnl-api-php)
[![license mit](https://poser.pugx.org/thirtybees/postnl-api-php/license.svg)](https://packagist.org/packages/thirtybees/postnl-api-php)

## About

This PHP library for both PostNL's REST and SOAP API aims to provide a simple way to connect your 
application with PostNL. By abstracting away needless complexity when processing shipment 
information and increased fault-tolerance, you can get up and running with PostNL in minutes.  
At the lower level this library uses asynchronous communication and payload splitting for 
improved performance.

## Important notice

The PHP bindings can connect to both PostNL's SOAP and REST API.  

### Status

| Service                                     | Status REST               | Status SOAP               | Version |
| ------------------------------------------- | ------------------------- | ------------------------- | ------- |
| **Addresses**                               |                           |                           |         |
| Adrescheck Nationaal                        | N/A                       | N/A                       | N/A     |
| Adrescheck Basis Nationaal                  | N/A                       | N/A                       | N/A     |
| Adrescheck Internationaal                   | N/A                       | N/A                       | N/A     |
| Geo Adrescheck Nationaal                    | N/A                       | N/A                       | N/A     |
| **Creditworthiness & Business information** |                           |                           |         |
| Bedrijfscheck Nationaal                     | N/A                       | N/A                       | N/A     |
| Kredietcheck Zakelijk                       | N/A                       | N/A                       | N/A     |
| **Send & Track**                            |                           |                           |         |
| Barcode webservice                          | ✓                         | ✓                         | 1.1     |
| Labelling webservice                        | ✓                         | ✓                         | 2.1     |
| Confirming webservice                       | ✓                         | ✓                         | 1.10    |
| Shippingstatus webservice                   | ✓                         | ✓                         | 1.6     |
| **Delivery Options**                        |                           |                           |         |
| Deliverydate webservice                     | ✓                         | ✓                         | 2.2     |
| Location webservice                         | ✓                         | ✓                         | 2.1     |
| Timeframe webservice                        | ✓                         | ✓                         | 2.1     |
| **Mail**                                    |                           |                           |         |
| Bulkmail webservice                         | N/A                       | N/A                       | N/A     |

## Instructions

- Clone this repo
- Optionally run `composer require guzzlehttp/guzzle` to use Guzzle instead of cURL directly
- Run `composer install` (Don't have composer? Visit https://getcomposer.org/)
- You're good to go! A few small examples can be found in this README.

## Documentation

### Example

Creating a label using the default REST API

```php
<?php

use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Entity\Dimension;

require_once __DIR__.'/vendor/autoload.php';

$customer = Customer::create([
    'CollectionLocation' => '123456',
    'CustomerCode'       => 'DEVC',
    'CustomerNumber'     => '11223344',
    'ContactPerson'      => 'Lesley',
    'Address'            => Address::create([
        'AddressType' => '02',
        'City'        => 'Hoofddorp',
        'CompanyName' => 'PostNL',
        'Countrycode' => 'NL',
        'HouseNr'     => '42',
        'Street'      => 'Siriusdreef',
        'Zipcode'     => '2132WT',
    ]),
    'Email'              => 'michael@thirtybees.com',
    'Name'               => 'Michael',
]);

$apikey = 'YOUR_API_KEY_HERE';
$sandbox = true;

$postnl = new PostNL($customer, $apikey, $sandbox);

$barcode = $postnl->generateBarcodeByCountryCode('NL');

$shipment = Shipment::create([
    'Addresses'           => [
        Address::create([
            'AddressType' => '01',
            'City'        => 'Utrecht',
            'Countrycode' => 'NL',
            'FirstName'   => 'Peter',
            'HouseNr'     => '9',
            'HouseNrExt'  => 'a bis',
            'Name'        => 'de Ruijter',
            'Street'      => 'Bilderdijkstraat',
            'Zipcode'     => '3521VA',
        ]),
    ],
    'Barcode'             => $barcode,
    'Dimension'           => new Dimension('2000'),
    'ProductCodeDelivery' => '3085',
]);

$label = $postnl->generateLabel($shipment, 'GraphicFile|PDF', true);

die(var_dump($label));
```

### Full documentation

The full documentation can be found on this page: [https://postnl-php.readthedocs.io/](https://postnl-php.readthedocs.io/)

## License

This library has been licensed with the MIT license.

```
Copyright (c) 2017-2018 thirty bees <https://github.com/thirtybees>

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
```
