# PostNL REST/SOAP API PHP Bindings

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
| Barcode webservice                          | alpha                     | alpha                     | 1.1     |
| Labelling webservice                        | alpha                     | alpha                     | 2.1     |
| Confirming webservice                       | alpha                     | alpha                     | 1.10    |
| Shippingstatus webservice                   | Expected: September, 2017 | Expected: September, 2017 | 1.6     |
| **Delivery Options**                        |                           |                           |         |
| Deliverydate webservice                     | Expected: September, 2017 | Expected: September, 2017 | 2.2     |
| Location webservice                         | Expected: September, 2017 | Expected: September, 2017 | 2.1     |
| Timeframe webservice                        | Expected: September, 2017 | Expected: September, 2017 | 2.1     |
| **Mail**                                    |                           |                           |         |
| Bulkmail webservice                         | N/A                       | N/A                       | N/A     |

## Instructions
- Clone this repo
- Optionally run `composer require guzzlehttp/guzzle` to use Guzzle instead of cURL directly
- Run `composer install` (Don't have composer? Visit https://getcomposer.org/)
- You're good to go! A few small examples can be found in this README.

## Example
Creating a label

> Outdated! Might no longer work...

```php
<?php

use ThirtyBees\PostNL\Entity\Dimension;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Request\LabelRequest;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\LabellingService;

require_once __DIR__.'/vendor/autoload.php';

PostNL::setApiKey('9s8adf7as8f6gasf6sdf6asfsfaw4f');
PostNL::setSandbox(true);
PostNL::setCustomer(
    Customer::create()
        ->setCollectionLocation('123456')
        ->setCustomerCode('DEVC')
        ->setCustomerNumber('11223344')
        ->setContactPerson('Lesley')
        ->setAddress(Address::create([
            'AddressType' => '02',
            'City'        => 'Hoofddorp',
            'CompanyName' => 'PostNL',
            'Countrycode' => 'NL',
            'HouseNr'     => '42',
            'Street'      => 'Siriusdreef',
            'Zipcode'     => '2132WT',
        ]))
        ->setEmail('michael@thirtybees.com')
        ->setName('Michael')
);

$labelRequest = new LabelRequest([
    Shipment::create()
        ->setAddresses([
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
        ])
        ->setBarcode(BarcodeService::generateBarcode())
        ->setDimension(new Dimension('2000'))
        ->setProductCodeDelivery('3085'),
]);

$label = LabellingService::generateLabel($labelRequest);

var_dump($label);die();
```
