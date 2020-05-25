<?php

declare(strict_types=1);

/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2020 Michael Dekker (https://github.com/firstred)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
 * is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author    Michael Dekker <git@michaeldekker.nl>
 * @copyright 2017-2020 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

use function DI\autowire;
use DI\Container;
use function Di\create;
use function DI\factory;
use function Di\get;
use Firstred\PostNL\Entity\Address;
use Firstred\PostNL\Entity\AddressInterface;
use Firstred\PostNL\Entity\Amount;
use Firstred\PostNL\Entity\AmountInterface;
use Firstred\PostNL\Entity\Contact;
use Firstred\PostNL\Entity\ContactInterface;
use Firstred\PostNL\Entity\Content;
use Firstred\PostNL\Entity\ContentInterface;
use Firstred\PostNL\Entity\Customer;
use Firstred\PostNL\Entity\CustomerInterface;
use Firstred\PostNL\Entity\Customs;
use Firstred\PostNL\Entity\CustomsInterface;
use Firstred\PostNL\Entity\CutOffTime;
use Firstred\PostNL\Entity\CutOffTimeInterface;
use Firstred\PostNL\Entity\Dimension;
use Firstred\PostNL\Entity\DimensionInterface;
use Firstred\PostNL\Entity\ErrorInterface;
use Firstred\PostNL\Entity\Event;
use Firstred\PostNL\Entity\EventInterface;
use Firstred\PostNL\Entity\Expectation;
use Firstred\PostNL\Entity\ExpectationInterface;
use Firstred\PostNL\Entity\Geocode;
use Firstred\PostNL\Entity\GeocodeInterface;
use Firstred\PostNL\Entity\Group;
use Firstred\PostNL\Entity\GroupInterface;
use Firstred\PostNL\Entity\Label;
use Firstred\PostNL\Entity\LabelInterface;
use Firstred\PostNL\Entity\Location;
use Firstred\PostNL\Entity\LocationInterface;
use Firstred\PostNL\Entity\Locations;
use Firstred\PostNL\Entity\LocationsInterface;
use Firstred\PostNL\Entity\MergedLabel;
use Firstred\PostNL\Entity\MergedLabelInterface;
use Firstred\PostNL\Entity\OldStatus;
use Firstred\PostNL\Entity\OldStatusInterface;
use Firstred\PostNL\Entity\OpeningHours;
use Firstred\PostNL\Entity\OpeningHoursInterface;
use Firstred\PostNL\Entity\PickupOption;
use Firstred\PostNL\Entity\PickupOptionInterface;
use Firstred\PostNL\Entity\ProductOption;
use Firstred\PostNL\Entity\ProductOptionInterface;
use Firstred\PostNL\Entity\ReasonNoTimeframe;
use Firstred\PostNL\Entity\ReasonNoTimeframeInterface;
use Firstred\PostNL\Entity\ReasonNoTimeframes;
use Firstred\PostNL\Entity\ReasonNoTimeframesInterface;
use Firstred\PostNL\Entity\Request\CalculateDeliveryDateRequest;
use Firstred\PostNL\Entity\Request\CalculateDeliveryDateRequestInterface;
use Firstred\PostNL\Entity\Request\CalculateShippingDateRequest;
use Firstred\PostNL\Entity\Request\CalculateShippingDateRequestInterface;
use Firstred\PostNL\Entity\Request\CalculateTimeframesRequest;
use Firstred\PostNL\Entity\Request\CalculateTimeframesRequestInterface;
use Firstred\PostNL\Entity\Request\ConfirmShipmentRequest;
use Firstred\PostNL\Entity\Request\ConfirmShipmentRequestInterface;
use Firstred\PostNL\Entity\Request\FindDeliveryInfoRequest;
use Firstred\PostNL\Entity\Request\FindDeliveryInfoRequestInterface;
use Firstred\PostNL\Entity\Request\GenerateBarcodeRequestEntity;
use Firstred\PostNL\Entity\Request\GenerateBarcodeRequestEntityInterface;
use Firstred\PostNL\Entity\Shipment;
use Firstred\PostNL\Entity\ShipmentInterface;
use Firstred\PostNL\Entity\Signature;
use Firstred\PostNL\Entity\SignatureInterface;
use Firstred\PostNL\Entity\Status;
use Firstred\PostNL\Entity\StatusInterface;
use Firstred\PostNL\Entity\Timeframe;
use Firstred\PostNL\Entity\TimeframeInterface;
use Firstred\PostNL\Entity\Timeframes;
use Firstred\PostNL\Entity\TimeframesInterface;
use Firstred\PostNL\Entity\ValidatedAddress;
use Firstred\PostNL\Entity\ValidatedAddressInterface;
use Firstred\PostNL\Entity\Warning;
use Firstred\PostNL\Entity\WarningInterface;
use Firstred\PostNL\Factory\BarcodeServiceFactory;
use Firstred\PostNL\Factory\BarcodeServiceFactoryInterface;
use Firstred\PostNL\Factory\CustomerFactory;
use Firstred\PostNL\Factory\CustomerFactoryInterface;
use Firstred\PostNL\Factory\EntityFactory;
use Firstred\PostNL\Factory\EntityFactoryInterface;
use Firstred\PostNL\Factory\HttpClientFactory;
use Firstred\PostNL\Factory\HttpClientFactoryInterface;
use Firstred\PostNL\Method\Barcode\GenerateBarcodeMethod;
use Firstred\PostNL\Method\Barcode\GenerateBarcodeMethodInterface;
use Firstred\PostNL\Misc\DummyLogger;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Validate\Validate;
use Firstred\PostNL\Validate\ValidateInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    // Library configuration
    'postnl.max_retries'     => 3,
    'postnl.concurrency'     => 5,
    'postnl.api_key'         => (string) getenv('POSTNL_API_KEY'),
    'postnl.sandbox'         => (bool) getenv('POSTNL_SANDBOX_MODE'),
    'postnl.3s_countries'    => ['AT', 'BE', 'BG', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GB', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'NL', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'EE', 'CN'],
    'postnl.label_positions' => [
        4 => [-276, 2],
        3 => [-132, 2],
        2 => [-276, 110],
        1 => [-132, 110],
    ],

    // Library validation formats
    'postnl.format.barcode.full'  => '/^[A-Z0-9]{11,15}$/',
    'postnl.format.barcode.types' => ['2S', '3S', 'CC', 'CD', 'CF', 'CG', 'CP', 'CX', 'LA'],
    'postnl.format.barcode.serie' => '/^\d{0,5}\d{4}-\d{0,5}\d{4}$/',
    'postnl.format.barcode.range' => '/^[A-Z0-9]{1,4}$/',
    'postnl.format.hs_tariff'     => '/^\d{6}$/',
    'postnl.format.postcode'      => [
        '_default' => '/^.{0,17}$/',
        'NL'       => '/^\d{4}\[A-Za-z]{2}$/',
        'BE'       => '/^\d{4}$/',
        'LU'       => '/^\d{4}$/',
    ],

    // Service aliases
    'postnl.logger'   => get(LoggerInterface::class),
    'postnl.customer' => function (ContainerInterface $c): CustomerInterface {
        /** @var CustomerFactoryInterface $factory */
        $factory = $c->get(CustomerFactoryInterface::class);

        return $factory->create();
    },
    'postnl.http_client' => factory(function (ContainerInterface $c) {
        $factory = $c->get(HttpClientFactoryInterface::class)
            ->setMaxRetries($c->get('postnl.max_retries'))
            ->setConcurrency($c->get('postnl.concurrency'));

        return $factory->create();
    }),
    'postnl.request_factory' => function () {
        return Psr17FactoryDiscovery::findRequestFactory();
    },
    //    'postnl.serializer' => factory(function () {
    //        $encoders = [new JsonEncoder()];
    //        $normalizers = [new ObjectNormalizer()];
    //
    //        return new Serializer($normalizers, $encoders);
    //    }),

    // Factories
    BarcodeServiceFactoryInterface::class => autowire(BarcodeServiceFactory::class)
        ->constructorParameter('apiKey', get('postnl.api_key'))
        ->constructorParameter('sandbox', get('postnl.sandbox'))
        ->constructorParameter('httpClient', get('postnl.http_client')),
    CustomerFactoryInterface::class   => autowire(CustomerFactory::class),
    EntityFactoryInterface::class     => autowire(EntityFactory::class),
    HttpClientFactoryInterface::class => autowire(HttpClientFactory::class),

    // Methods
    GenerateBarcodeMethodInterface::class => autowire(GenerateBarcodeMethod::class)->constructor(
        get('postnl.request_factory'),
        null
    ),

    // Services
    BarcodeServiceInterface::class => function (ContainerInterface $c) {
        $factory = $c->get(BarcodeServiceFactoryInterface::class);

        return $factory->create();
    },

    // Request entities
    CalculateDeliveryDateRequestInterface::class => function (Container $c) {
        return $c->make(CalculateDeliveryDateRequest::class);
    },
    CalculateShippingDateRequestInterface::class => function (Container $c) {
        return $c->make(CalculateShippingDateRequest::class);
    },
    CalculateTimeframesRequestInterface::class => function (Container $c) {
        return $c->make(CalculateTimeframesRequest::class);
    },
    ConfirmShipmentRequestInterface::class => function (Container $c) {
        return $c->make(ConfirmShipmentRequest::class);
    },
    FindDeliveryInfoRequestInterface::class => function (Container $c) {
        return $c->make(FindDeliveryInfoRequest::class);
    },
    GenerateBarcodeRequestEntityInterface::class => function (Container $c) {
        return $c->make(GenerateBarcodeRequestEntity::class);
    },

    // Response entities

    // Entities
    AddressInterface::class => function (Container $c) {
        return $c->make(Address::class);
    },
    AmountInterface::class => function (Container $c) {
        return $c->make(Amount::class);
    },
    ContactInterface::class => function (Container $c) {
        return $c->make(Contact::class);
    },
    ContentInterface::class => function (Container $c) {
        return $c->make(Content::class);
    },
    CustomerInterface::class => function (Container $c) {
        return $c->make(Customer::class);
    },
    CustomsInterface::class => function (Container $c) {
        return $c->make(Customs::class);
    },
    CutOffTimeInterface::class => function (Container $c) {
        return $c->make(CutOffTime::class);
    },
    DimensionInterface::class => function (Container $c) {
        return $c->make(Dimension::class);
    },
    ErrorInterface::class => function (Container $c) {
        return $c->make(\Firstred\PostNL\Entity\Error::class);
    },
    EventInterface::class => function (Container $c) {
        return $c->make(Event::class);
    },
    ExpectationInterface::class => function (Container $c) {
        return $c->make(Expectation::class);
    },
    GeocodeInterface::class => function (Container $c) {
        return $c->make(Geocode::class);
    },
    GroupInterface::class => function (Container $c) {
        return $c->make(Group::class);
    },
    LabelInterface::class => function (Container $c) {
        return $c->make(Label::class);
    },
    LocationInterface::class => function (Container $c) {
        return $c->make(Location::class);
    },
    LocationsInterface::class => function (Container $c) {
        return $c->make(Locations::class);
    },
    MergedLabelInterface::class => function (Container $c) {
        return $c->make(MergedLabel::class);
    },
    OldStatusInterface::class => function (Container $c) {
        return $c->make(OldStatus::class);
    },
    OpeningHoursInterface::class => function (Container $c) {
        return $c->make(OpeningHours::class);
    },
    PickupOptionInterface::class => function (Container $c) {
        return $c->make(PickupOption::class);
    },
    ProductOptionInterface::class => function (Container $c) {
        return $c->make(ProductOption::class);
    },
    ReasonNoTimeframeInterface::class => function (Container $c) {
        return $c->make(ReasonNoTimeframe::class);
    },
    ReasonNoTimeframesInterface::class => function (Container $c) {
        return $c->make(ReasonNoTimeframes::class);
    },
    ShipmentInterface::class => function (Container $c) {
        return $c->make(Shipment::class);
    },
    SignatureInterface::class => function (Container $c) {
        return $c->make(Signature::class);
    },
    StatusInterface::class => function (Container $c) {
        return $c->make(Status::class);
    },
    TimeframeInterface::class => function (Container $c) {
        return $c->make(Timeframe::class);
    },
    TimeframesInterface::class => function (Container $c) {
        return $c->make(Timeframes::class);
    },
    ValidatedAddressInterface::class => function (Container $c) {
        return $c->make(ValidatedAddress::class);
    },
    WarningInterface::class => function (Container $c) {
        return $c->make(Warning::class);
    },

    // Misc
    LoggerInterface::class   => autowire(DummyLogger::class),
    ValidateInterface::class => autowire(Validate::class)
        ->constructorParameter('postcodeFormats', get('postnl.format.postcode'))
        ->constructorParameter('barcodeTypes', get('postnl.format.barcode.types'))
        ->constructorParameter('barcodeFullFormat', get('postnl.format.barcode.full'))
        ->constructorParameter('barcodeRangeFormat', get('postnl.format.barcode.range'))
        ->constructorParameter('barcodeSerieFormat', get('postnl.format.barcode.serie')),

    // Library main file
    PostNL::class => autowire(PostNL::class)
        ->constructorParameter('customer', get('postnl.customer'))
        ->constructorParameter('apiKey', get('postnl.api_key'))
        ->constructorParameter('sandbox', get('postnl.sandbox'))
        ->constructorParameter('entityFactory', get(EntityFactoryInterface::class))
        ->constructorParameter('barcodeService', get(BarcodeServiceInterface::class))
        ->constructorParameter('threeSCountries', get('postnl.3s_countries'))
        ->constructorParameter('logger', get('postnl.logger')),
];
