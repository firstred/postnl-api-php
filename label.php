<?php

use ThirtyBees\PostNL\Entity\Barcode;
use ThirtyBees\PostNL\Entity\Dimension;
use ThirtyBees\PostNL\Entity\Request\GenerateBarcode;
use ThirtyBees\PostNL\Entity\Request\GenerateLabel;
use ThirtyBees\PostNL\Entity\Shipment;
use ThirtyBees\PostNL\Entity\SOAP\UsernameToken;
use ThirtyBees\PostNL\PostNL;
use ThirtyBees\PostNL\Entity\Address;
use ThirtyBees\PostNL\Entity\Customer;
use ThirtyBees\PostNL\Service\BarcodeService;
use ThirtyBees\PostNL\Service\LabellingService;

require_once __DIR__.'/vendor/autoload.php';

//PostNL::setRestApiKey('ORHn0Ah7Az4Qvk7otbbJIx5U5huHGpnf');
$postnl = new PostNL(
    Customer::create()
        ->setCollectionLocation('123456')
//        ->setCustomerCode('FGEP')
//        ->setCustomerNumber('10466153')
        ->setCustomerCode('DEVC')
        ->setCustomerNumber('11223344')
        ->setContactPerson('Michael')
        ->setAddress(Address::create([
            'AddressType' => '02',
            'City'        => 'Hoofddorp',
            'CompanyName' => 'PostNL',
            'Countrycode' => 'NL',
            'HouseNr'     => '42',
            'Street'      => 'Siriusdreef',
            'Zipcode'     => '2132WT',
        ]))
//        ->setGlobalPackBarcodeType('CX')
//        ->setGlobalPackCustomerCode('1889')
//    , new UsernameToken('mijnpresta153', 'Dd93Hft5YZ'),
    ,new UsernameToken(null, 'ORHn0Ah7Az4Qvk7otbbJIx5U5huHGpnf'),  // Michael
//    ,new UsernameToken(null, 'BGJNAMq1HUmBPklJBwgL9oT7SFi8f0Xy'),  // Luke
    true,
    PostNL::MODE_REST
);

$barcodes = $postnl->generateBarcodesByCountryCodes(['NL' => 1]);

$shipments = [];
foreach ($barcodes['NL'] as $barcode) {
    $shipments[$barcode] = Shipment::create()
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
            Address::create([
                'AddressType' => '02',
                'City'        => 'Hoofddorp',
                'CompanyName' => 'PostNL',
                'Countrycode' => 'NL',
                'HouseNr'     => '42',
                'Street'      => 'Siriusdreef',
                'Zipcode'     => '2132WT',
            ]),
        ])
        ->setBarcode($barcode)
        ->setDeliveryAddress('01')
        ->setDimension(new Dimension('2000'))
        ->setProductCodeDelivery('3085')
    ;
}
file_put_contents('response.json', var_export($postnl->generateLabel(array_values($shipments)[0], 'GraphicFile|PDF', false), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES));exit;

//$postnl->confirm(
//    Shipment::create()
//        ->setAddresses([
//            Address::create([
//                'AddressType' => '01',
//                'City'        => 'Utrecht',
//                'Countrycode' => 'NL',
//                'FirstName'   => 'Peter',
//                'HouseNr'     => '9',
//                'HouseNrExt'  => 'a bis',
//                'Name'        => 'de Ruijter',
//                'Street'      => 'Bilderdijkstraat',
//                'Zipcode'     => '3521VA',
//            ]),
//            Address::create([
//                'AddressType' => '02',
//                'City'        => 'Hoofddorp',
//                'CompanyName' => 'PostNL',
//                'Countrycode' => 'NL',
//                'HouseNr'     => '42',
//                'Street'      => 'Siriusdreef',
//                'Zipcode'     => '2132WT',
//            ]),
//        ])
//        ->setBarcode($barcode)
//        ->setDimension(new Dimension('2000'))
//        ->setProductCodeDelivery('3085')
//);

/** @var \ThirtyBees\PostNL\Entity\GenerateLabelResponse $label */
file_put_contents(__DIR__.'/label.gif', base64_decode($label->getResponseShipments()[0]->getLabels()[0]->getContent()));die();
