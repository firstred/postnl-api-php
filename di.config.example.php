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

use DI\ContainerBuilder;
use Firstred\PostNL\Factory\EntityFactory;
use Firstred\PostNL\Factory\EntityFactoryInterface;
use Firstred\PostNL\Factory\HttpClientFactory;
use Firstred\PostNL\Factory\HttpClientFactoryInterface;
use Firstred\PostNL\Method\AbstractMethod;
use function DI\autowire;
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
use Firstred\PostNL\Http\HttpClient;
use Firstred\PostNL\Method\Barcode\GenerateBarcodeMethod;
use Firstred\PostNL\Method\Barcode\GenerateBarcodeMethodInterface;
use Firstred\PostNL\Misc\DummyLogger;
use Firstred\PostNL\PostNL;
use Firstred\PostNL\Service\BarcodeService;
use Firstred\PostNL\Service\BarcodeServiceInterface;
use Firstred\PostNL\Validate\Validate;
use Firstred\PostNL\Validate\ValidateInterface;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttplugClient;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

return [
    // Configured PostNL customer
    'postnl.customer' => factory(function (ContainerInterface $c) {
        $address = $c->get(AddressInterface::class);
        if (getenv('POSTNL_CONTACT_NAME')) {
            $address->setName(getenv('POSTNL_CONTACT_NAME'));
        }
        if (getenv('POSTNL_CONTACT_COMPANY_NAME')) {
            $address->setCompanyName(getenv('POSTNL_CONTACT_COMPANY_NAME'));
        }
        $address->setAddressType(Address::TYPE_SENDER);
        $address->setStreet(getenv('POSTNL_CONTACT_STREET'));
        $address->setHouseNr(getenv('POSTNL_CONTACT_HOUSE_NR'));
        $address->setHouseNrExt(getenv('POSTNL_CONTACT_HOUSE_NR_EXT'));
        $address->setZipcode(getenv('POSTNL_CONTACT_ZIPCODE'));
        $address->setCountrycode(getenv('POSTNL_CONTACT_COUNTRY_CODE'));

        $customer = $c->get(CustomerInterface::class);
        $customer->setEmail(getenv('POSTNL_CONTACT_EMAIL'));
        $customer->setCustomerCode(getenv('POSTNL_CUSTOMER_CODE'));
        $customer->setCustomerNumber(getenv('POSTNL_CUSTOMER_NUMBER'));
        $customer->setCollectionLocation(getenv('POSTNL_CUSTOMER_NUMBER'));
        $customer->setGlobalPackBarcodeType(getenv('POSTNL_GLOBALPACK_BARCODE_TYPE'));
        $customer->setGlobalPackCustomerCode(getenv('POSTNL_GLOBALPACK_CUSTOMER_CODE'));

        return $customer;
    }),

    // Library configuration
    'postnl.logger'      => get(LoggerInterface::class),
    'postnl.max_retries' => 3,
    'postnl.concurrency' => 5,
    'postnl.http_client' => factory(function (ContainerInterface $c) {
        $httpClient = new HttpClient();
        $plugins = [new RetryPlugin(['retries' => $c->get('postnl.max_retries')])];
        $logger = $c->get('postnl.logger');
        if ($logger) {
            $plugins[] = new LoggerPlugin($logger);
        }

        // Temporary extra check, due to auto-discovery failing atm
        if (class_exists(HttplugClient::class)) {
            $pluginClient = new PluginClient($c->get(HttplugClient::class), $plugins);
        } else {
            $pluginClient = new PluginClient(Http\Discovery\HttpAsyncClientDiscovery::find(), $plugins);
        }
        $httpClient->setConcurrency((int) ($c->get('postnl.concurrency') ?: 5));
        $httpClient->setHttpAsyncClient($pluginClient);

        return $httpClient;
    }),
    'postnl.request_factory' => factory(function () {
        return Psr17FactoryDiscovery::findRequestFactory();
    }),
    'postnl.serializer' => factory(function () {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }),
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
    'postnl.format.barcode.types' => ['2S', '3S', 'CC', 'CP', 'CD', 'CF', 'LA', 'CX'],
    'postnl.format.barcode.serie' => '/^\d{0,3}\d{6}-\d{0,3}\d{6}$/',
    'postnl.format.barcode.range' => '/^[A-Z0-9]{1,4}$/',
    'postnl.format.hs_tariff'     => '/^\d{6}$/',
    'postnl.format.postcode'      => [
        '_default' => '/^.{0,17}$/',
        'NL'       => '/^\d{4}\[A-Za-z]{2}$/',
        'BE'       => '/^\d{4}$/',
        'LU'       => '/^\d{4}$/',
    ],

    // Factories
    EntityFactoryInterface::class     => autowire(EntityFactory::class),
    HttpClientFactoryInterface::class => autowire(HttpClientFactory::class),

    // Methods
    AbstractMethod::class => autowire()->constructor(
        get('postnl.request_factory'),
        get('postnl.serializer')
    ),
    GenerateBarcodeMethodInterface::class => autowire(GenerateBarcodeMethod::class)->constructor(
        get('postnl.request_factory'),
        get('postnl.serializer')
    ),

    // Services
    BarcodeServiceInterface::class => factory(function (ContainerInterface $c) {
        $service = new BarcodeService(
            $c->get('postnl.customer'),
            $c->get('postnl.api_key'),
            $c->get('postnl.sandbox'),
            $c->get('postnl.http_client')
        );
        $service->setGenerateBarcodeMethod($c->get(GenerateBarcodeMethodInterface::class));

        return $service;
    }),

    // Request entities
    CalculateDeliveryDateRequestInterface::class => autowire(CalculateDeliveryDateRequest::class),
    CalculateShippingDateRequestInterface::class => autowire(CalculateShippingDateRequest::class),
    CalculateTimeframesRequestInterface::class   => autowire(CalculateTimeframesRequest::class),
    ConfirmShipmentRequestInterface::class       => autowire(ConfirmShipmentRequest::class),
    FindDeliveryInfoRequestInterface::class      => autowire(FindDeliveryInfoRequest::class),
    GenerateBarcodeRequestEntityInterface::class => autowire(GenerateBarcodeRequestEntity::class),

    // Response entities

    // Entities
    AddressInterface::class            => autowire(Address::class),
    AmountInterface::class             => autowire(Amount::class),
    ContactInterface::class            => autowire(Contact::class),
    ContentInterface::class            => autowire(Content::class),
    CustomerInterface::class           => autowire(Customer::class),
    CustomsInterface::class            => autowire(Customs::class),
    CutOffTimeInterface::class         => autowire(CutOffTime::class),
    DimensionInterface::class          => autowire(Dimension::class),
    ErrorInterface::class              => autowire(\Firstred\PostNL\Entity\Error::class),
    EventInterface::class              => autowire(Event::class),
    ExpectationInterface::class        => autowire(Expectation::class),
    GeocodeInterface::class            => autowire(Geocode::class),
    GroupInterface::class              => autowire(Group::class),
    LabelInterface::class              => autowire(Label::class),
    LocationInterface::class           => autowire(Location::class),
    LocationsInterface::class          => autowire(Locations::class),
    MergedLabelInterface::class        => autowire(MergedLabel::class),
    OldStatusInterface::class          => autowire(OldStatus::class),
    OpeningHoursInterface::class       => autowire(OpeningHours::class),
    PickupOptionInterface::class       => autowire(PickupOption::class),
    ProductOptionInterface::class      => autowire(ProductOption::class),
    ReasonNoTimeframeInterface::class  => autowire(ReasonNoTimeframe::class),
    ReasonNoTimeframesInterface::class => autowire(ReasonNoTimeframes::class),
    ShipmentInterface::class           => autowire(Shipment::class),
    SignatureInterface::class          => autowire(Signature::class),
    StatusInterface::class             => autowire(Status::class),
    TimeframeInterface::class          => autowire(Timeframe::class),
    TimeframesInterface::class         => autowire(Timeframes::class),
    ValidatedAddressInterface::class   => autowire(ValidatedAddress::class),
    WarningInterface::class            => autowire(Warning::class),

    // Misc
    LoggerInterface::class   => autowire(DummyLogger::class),
    ValidateInterface::class => create(Validate::class)->constructor(
        get('postnl.format.postcode'),
        get('postnl.format.barcode.types'),
        get('postnl.format.barcode.full'),
        get('postnl.format.barcode.range'),
        get('postnl.format.barcode.serie')
    ),

    // Library main file
    PostNL::class => create()->constructor(
        get('postnl.customer'),
        get('postnl.api_key'),
        get('postnl.sandbox'),
        get(EntityFactoryInterface::class),
        get(BarcodeServiceInterface::class),
        get(LoggerInterface::class)
    ),
];
