# PostNL REST/SOAP API PHP Bindings
[![Build Status](https://travis-ci.org/thirtybees/postnl-api-php.svg?branch=master)](https://travis-ci.org/wappr/logger)
[![latest stable version](https://poser.pugx.org/thirtybees/postnl-api-php/v/stable.svg)](https://packagist.org/packages/thirtybees/postnl-api-php)
[![license mit](https://poser.pugx.org/thirtybees/postnl-api-php/license.svg)](https://packagist.org/packages/thirtybees/postnl-api-php)

## About
This PHP library for both PostNL's REST and SOAP API aims to provide a simple way to connect your 
application with PostNL. By abstracting away needless complexity when processing shipment 
information and increased fault-tolerance, you can get up and running with PostNL in minutes.  
At the lower level this library uses asynchronous communication and payload splitting for 
improved performance.

## Important notice
The PHP bindings can connect to both PostNL's SOAP and REST API.  
The library is still a work-in-progress, but the Barcode, Labelling and Confirming will 
hopefully be completed soon.

### Status
| Service                                     | Status REST               | Status SOAP               | Version |
| ------------------------------------------- | ------------------------- | ------------------------- | ------- |
| **Addresses**                               |                           |                           |         |
| Adrescheck Nationaal                        | N/A                       | N/A                       | N/A     |
| Adrescheck Basis Nationaal                  | N/A                       | N/A                       | N/A     |
| Adrescheck Internationaal                   | N/A                       | N/A                       | N/A     |
| Persoon op AdresCheck Basis                 | N/A                       | N/A                       | N/A     |
| Geo Adrescheck Nationaal                    | N/A                       | N/A                       | N/A     |
| **Creditworthiness & Business information** |                           |                           |         |
| Bedrijfscheck Nationaal                     | N/A                       | N/A                       | N/A     |
| IBANcheck Nationaal                         | N/A                       | N/A                       | N/A     |
| Kredietcheck Consument Basis                | N/A                       | N/A                       | N/A     |
| Kredietcheck Consument Premium              | N/A                       | N/A                       | N/A     |
| Fraudepreventie Check Basis                 | N/A                       | N/A                       | N/A     |
| Kredietcheck Zakelijk                       | N/A                       | N/A                       | N/A     |
| **Send & Track**                            |                           |                           |         |
| Barcode webservice                          | beta                      | beta                      | 1.1     |
| Labelling webservice                        | beta                      | beta                      | 2.1     |
| Confirming webservice                       | beta                      | beta                      | 1.10    |
| Shippingstatus webservice                   | alpha                     | alpha                     | 1.6     |
| **Delivery Options**                        |                           |                           |         |
| Deliverydate webservice                     | alpha                     | alpha                     | 2.2     |
| Location webservice                         | alpha                     | alpha                     | 2.1     |
| Timeframe webservice                        | alpha                     | alpha                     | 2.1     |
| **Mail**                                    |                           |                           |         |
| Bulkmail webservice                         | N/A                       | N/A                       | N/A     |

## Instructions
- Clone this repo
- Optionally run `composer require guzzlehttp/guzzle` to use Guzzle instead of cURL directly
- Run `composer install` (Don't have composer? Visit https://getcomposer.org/)
- You're good to go! A few small examples can be found in this README.

## Example
Creating a label using default REST API

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
    'CustomerCode' => 'DEVC',
    'CustomerNumber' => '11223344',
    'ContactPerson' => 'Lesley',
    'Address' => Address::create([
        'AddressType' => '02',
        'City'        => 'Hoofddorp',
        'CompanyName' => 'PostNL',
        'Countrycode' => 'NL',
        'HouseNr'     => '42',
        'Street'      => 'Siriusdreef',
        'Zipcode'     => '2132WT',
    ]),
    'Email' => 'michael@thirtybees.com',
    'Name' => 'Michael',
]);

$apikey = 'YOUR_API_KEY_HERE';
$sandbox = true;

$postnl = new PostNL($customer, $apikey, $sandbox);

$barcode = $postnl->generateBarcodeByCountryCode('NL');

$shipment = Shipment::create([
    'Addresses' => [
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
    'Barcode' => $barcode,
    'Dimension' => new Dimension('2000'),
    'ProductCodeDelivery' => '3085',
]);

$label = $postnl->generateLabel($shipment, 'GraphicFile|PDF', true);

var_dump($label);die();
```
