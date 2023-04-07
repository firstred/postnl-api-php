.. _quickstart:

==========
Quickstart
==========

This page provides a quick introduction to this library and a few quick copy/paste examples which you can adjust to your likings.

This section assumes that you have installed the library and are fully authenticated.

If you do not have the library installed, head over to the :ref:`installation` page. If you do not know what to pass to the main :php:class:`Firstred\\PostNL\\PostNL` class, please refer to the chapter :ref:`authentication` first.

You can do requests over the API by creating the request objects and passing them to one of the functions in the main :php:class:`Firstred\\PostNL\\PostNL`
class.

Creating request objects may seem a bit counter-intuitive at first, but this makes it a lot easier to follow the request examples from the `official API documentation <https://developer.postnl.nl/>`_ and quickly figure out what each field does.

Using an IDE with code completion is **strongly recommended**.

.. _requesting timeframes location and delivery date at once:

--------------------------------------------------------------
Requesting timeframes, locations and the delivery date at once
--------------------------------------------------------------

You can request the timeframes, locations and delivery date at once to quickly retrieve all the available delivery options.

.. note::

    For more details on how to retrieve delivery options, consult the :ref:`delivery options` chapter.

Here's how it is done from scratch:

.. tabs::

    .. tab:: PHP 5/7

        .. code-block:: php

            <?php

            use Firstred\PostNL\Entity\CutOffTime;
            use Firstred\PostNL\Entity\Location;
            use Firstred\PostNL\Entity\Message\Message;
            use Firstred\PostNL\Entity\Request\GetDeliveryDate;
            use Firstred\PostNL\Entity\Request\GetNearestLocations;
            use Firstred\PostNL\Entity\Request\GetTimeframes;
            use Firstred\PostNL\Entity\Timeframe;
            use Firstred\PostNL\PostNL;
            use Firstred\PostNL\Entity\Customer;
            use Firstred\PostNL\Entity\Address;

            require_once __DIR__.'/vendor/autoload.php';

            // Your PostNL credentials
            $customer = (new Customer())
                ->setCollectionLocation('123456')
                ->setCustomerCode('DEVC')
                ->setCustomerNumber('11223344')
                ->setContactPerson('Sander')
                ->setAddress((new Address())
                    ->setAddressType('02')
                    ->setCity('Hoofddorp')
                    ->setCompanyName('PostNL')
                    ->setCountrycode('NL')
                    ->setHouseNr('42')
                    ->setStreet('Siriusdreef')
                    ->setZipcode('2132WT')
                )
                ->SetEmail('test@voorbeeld.nl')
                ->setName('Michael');

            $apikey = 'YOUR_API_KEY_HERE';
            $sandbox = true;

            $postnl = new PostNL($customer, $apikey, $sandbox, PostNL::MODE_REST);

            $mondayDelivery = true;
            $deliveryDaysWindow = 7; // Amount of days to show ahead
            $dropoffDelay = 0;       // Amount of days to delay delivery

            // Configure the cut-off window for every day, 1 = Monday, 7 = Sunday
            $cutoffTime = '15:00:00';
            $dropoffDays = [1 => true, 2 => true, 3 => true, 4 => true, 5 => true, 6 => false, 7 => false];
            foreach (range(1, 7) as $day) {
                if ($dropoffDays[$day]) {
                    $cutOffTimes[] = new CutOffTime(
                        str_pad($day, 2, '0', STR_PAD_LEFT),
                        date('H:i:00', strtotime($cutoffTime)),
                        true
                    );
                }
            }

            $response = $postnl->getTimeframesAndNearestLocations(
                (new GetTimeframes())
                    ->setTimeframe([
                        (new Timeframe())
                            ->setCountryCode('NL')
                            ->setEndDate(date('d-m-Y', strtotime(" +{$deliveryDaysWindow} days +{$dropoffDelay} days")))
                            ->setHouseNr('66')
                            ->setOptions(['Morning', 'Daytime'])
                            ->setPostalCode('2132WT')
                            ->setStartDate(date('d-m-Y', strtotime("+1 days")))
                            ->setSundaySorting(!empty($mondayDelivery) && date('w', strtotime("+{$dropoffDelay} days")))
                    ]),
                (new GetNearestLocations())
                    ->setCountrycode('NL')
                    ->setLocation(
                        (new Location())
                            ->setAllowSundaySorting(!empty($mondayDelivery))
                            ->setDeliveryOptions(['PG'])
                            ->setOptions(['Daytime'])
                            ->setHouseNr('66')
                            ->setPostalcode('2132WT')
                    ),
                (new GetDeliveryDate())
                    ->setGetDeliveryDate(
                        (new GetDeliveryDate())
                            ->setAllowSundaySorting(!empty($mondayDelivery))
                            ->setCountryCode('NL')
                            ->setCutOffTimes($cutOffTimes)
                            ->setHouseNr('12')
                            ->setOptions(['Daytime', 'Evening'])
                            ->setPostalCode('2132WT')
                            ->setShippingDate(date('d-m-Y H:i:s'))
                            ->setShippingDuration(strval(1 + (int) $dropoffDelay))
                    )
                    ->setMessage(new Message())
            );

    .. tab:: PHP 8

         .. code-block:: php

            <?php

            use Firstred\PostNL\Entity\Label;
            use Firstred\PostNL\PostNL;
            use Firstred\PostNL\Entity\Customer;
            use Firstred\PostNL\Entity\Address;
            use Firstred\PostNL\Entity\Shipment;
            use Firstred\PostNL\Entity\Dimension;

            require_once __DIR__.'/vendor/autoload.php';

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

            $apikey = 'YOUR_API_KEY_HERE';
            $sandbox = true;

            $postnl = new PostNL(
                customer: $customer,
                apiKey: $apikey,
                sandbox: $sandbox,
                mode: PostNL::MODE_REST,
            );

            $mondayDelivery = true;
            $deliveryDaysWindow = 7; // Amount of days to show ahead
            $dropoffDelay = 0;       // Amount of days to delay delivery

            // Configure the cut-off window for every day, 1 = Monday, 7 = Sunday
            $cutoffTime = '15:00:00';
            $dropoffDays = [1 => true, 2 => true, 3 => true, 4 => true, 5 => true, 6 => false, 7 => false];
            foreach (range(1, 7) as $day) {
                if ($dropoffDays[$day]) {
                    $cutOffTimes[] = new CutOffTime(
                        str_pad($day, 2, '0', STR_PAD_LEFT),
                        date('H:i:00', strtotime($cutoffTime)),
                        true
                    );
                }
            }

            $response = $postnl->getTimeframesAndNearestLocations(
                (new GetTimeframes())
                    ->setTimeframe([
                        (new Timeframe())
                            ->setCountryCode('NL')
                            ->setEndDate(date('d-m-Y', strtotime(" +{$deliveryDaysWindow} days +{$dropoffDelay} days")))
                            ->setHouseNr('66')
                            ->setOptions(['Morning', 'Daytime'])
                            ->setPostalCode('2132WT')
                            ->setStartDate(date('d-m-Y', strtotime("+1 days")))
                            ->setSundaySorting(!empty($mondayDelivery) && date('w', strtotime("+{$dropoffDelay} days")))
                    ]),
                (new GetNearestLocations())
                    ->setCountrycode('NL')
                    ->setLocation(
                        (new Location())
                            ->setAllowSundaySorting(!empty($mondayDelivery))
                            ->setDeliveryOptions(['PG'])
                            ->setOptions(['Daytime'])
                            ->setHouseNr('66')
                            ->setPostalcode('2132WT')
                    ),
                (new GetDeliveryDate())
                    ->setGetDeliveryDate(
                        (new GetDeliveryDate())
                            ->setAllowSundaySorting(!empty($mondayDelivery))
                            ->setCountryCode('NL')
                            ->setCutOffTimes($cutOffTimes)
                            ->setHouseNr('12')
                            ->setOptions(['Daytime', 'Evening'])
                            ->setPostalCode('2132WT')
                            ->setShippingDate(date('d-m-Y H:i:s'))
                            ->setShippingDuration(strval(1 + (int) $dropoffDelay))
                    )
                    ->setMessage(new Message())
            );


The response variable will be an associative array containing the timeframes, nearest locations and delivery date. It has the following keys:

.. confval:: timeframes

    This is a :php:class:`Firstred\\PostNL\\Entity\\Response\\ResponseTimeframes` object containing all the timeframes. You can iterate over all the available timeframes as follows.

    .. code-block:: php

        foreach ($response['timeframes'] as $timeframe) {
            $date = $timeframe->getDate()->format('Y-m-d');

            // Note that a timeframe object might have multiple embedded timeframes.
            // This might happen when you request both `Daytime` and `Evening` timeframes
            $from = $timeframe->getTimeframes()[0]->getFrom();
            $to = $timeframe->getTimeframes()[0]->getTo();

            echo "$date - from: $from, to: $to\n";
        }

        // Output: 2020-03-03 - from: 12:15:00, to: 14:00:00

    .. note::

        Note that the API usually groups timeframes by date, but is not guaranteed to do so, so do not rely on it!

 The embedded timeframes contain the actual timeframes on that particular day.

        The response format is the same for both the SOAP and REST API and is described on this page:
        https://developer.postnl.nl/browse-apis/delivery-options/timeframe-webservice/testtool-rest/#/Timeframe/get_calculate_timeframes

    .. note::

        Dates and times returned by the library always use the same format for consistency and therefore may differ from the API.
        Please refer to the :ref:`formats` chapter for more information.

.. confval:: locations

    The pickup locations can be found in the :php:class:`Firstred\\PostNL\\Entity\\Response\\GetNearestLocationsResponse` object.

    You can iterate over the found locations as follows:

    .. code-block:: php

        foreach ($response['locations']->getGetLocationsResult()->getResponseLocation() as $location) {
            var_dump($location);
        }

.. confval:: delivery_date

    The delivery date that was found, returned in a :php:class:`Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse` object.

    You can print the date as follows:

    .. code-block:: php

        echo $response['delivery_date']->getDeliveryDate()->format('d-m-Y');

----------------------------------
Creating a (merged) shipment label
----------------------------------

This section describes  how you can create two labels and have them merged into a single PDF automatically.

.. note::

    If you'd like to know more about all the methods you can use to create labels, see the :ref:`send and track shipments` chapter.

Example code:

.. code-block:: php

    use Firstred\PostNL\Entity\Label;
    use Firstred\PostNL\PostNL;
    use Firstred\PostNL\Entity\Customer;
    use Firstred\PostNL\Entity\Address;
    use Firstred\PostNL\Entity\Shipment;
    use Firstred\PostNL\Entity\Dimension;

    require_once __DIR__.'/vendor/autoload.php';

    // Your PostNL credentials
    $customer = (new Customer())
            ->setCollectionLocation('123456')
            ->setCustomerCode('DEVC')
            ->setCustomerNumber('11223344')
            ->setGlobalPackBarcodeType('CX')
            ->setGlobalPackCustomerCode('1234')
            ->setContactPerson('Sander')
            ->setAddress((new Address())
                ->setAddressType('02')
                ->setCity('Hoofddorp')
                ->setCompanyName('PostNL')
                ->setCountrycode('NL')
                ->setHouseNr('42')
                ->setStreet('Siriusdreef')
                ->setZipcode('2132WT')
            )
            ->setEmail('test@voorbeeld.nl')
            ->setName('Michael');

    $apikey = 'YOUR_API_KEY_HERE';
    $sandbox = true;

    $postnl = new PostNL($customer, $apikey, $sandbox, PostNL::MODE_SOAP);

    $barcodes = $postnl->generateBarcodesByCountryCodes(['NL' => 2]);

    $shipments = [
        (new Shipment())
            ->setAddresses([
                (new Address())
                    ->setAddressType('01')
                    ->setCity('Utrecht')
                    ->setCountrycode('NL')
                    ->setFirstName('Peter')
                    ->setHouseNr('9')
                    ->setHouseNrExt('a bis')
                    ->setName('de Ruijter')
                    ->setStreet('Bilderdijkstraat')
                    ->setZipcode('3521VA')
            ])
            ->setBarcode($barcodes['NL'][0])
            ->setDimension(new Dimension('1000'))
            ->setProductCodeDelivery('3085'),
        (new Shipment())
            ->setAddresses([
                (new Address())
                    ->setAddressType('01')
                    ->setCity('Utrecht')
                    ->setCountrycode('NL')
                    ->setFirstName('Peter')
                    ->setHouseNr('9')
                    ->setHouseNrExt('a bis')
                    ->setName('de Ruijter')
                    ->setStreet('Bilderdijkstraat')
                    ->setZipcode('3521VA')
            ])
            ->setBarcode($barcodes['NL'][1])
            ->setDimension(new Dimension('1000'))
            ->setProductCodeDelivery('3085')
    ];

    $label = $postnl->generateLabels(
        $shipments,
        'GraphicFile|PDF', // Printertype (only PDFs can be merged -- no need to use the Merged types)
        true, // Confirm immediately
        true, // Merge
        Label::FORMAT_A4, // Format -- this merges multiple A6 labels onto an A4
        [
            1 => true,
            2 => true,
            3 => true,
            4 => true,
        ] // Positions
    );

    file_put_contents('labels.pdf', $label);

This will write a ``labels.pdf`` file that looks like this:

.. image:: img/mergedlabels.png

If you'd rather have the user download a label, you can set the ``Content-Disposition`` header:

.. code-block:: php

    $label = ...;

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="label.pdf"');
    echo $label;
    exit;

.. note::

    Your framework might already provide a way to output files. Here are a few examples for several popular PHP frameworks:

    .. tabs::

        .. tab:: Symfony

            .. code-block:: php

                <?php

                use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
                use Symfony\Component\HttpFoundation\Response;
                use Symfony\Component\HttpFoundation\ResponseHeaderBag;

                class CreateShipmentController extends AbstractController
                {
                    public function downloadLabelAction()
                    {
                        // Provide a name for your file with extension
                        $filename = 'label.pdf';

                        // Create the label
                        $label = ...;

                        // Return a response with a specific content
                        $response = new Response($label);

                        // Create the disposition of the file
                        $disposition = $response->headers->makeDisposition(
                            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                            $filename
                        );

                        // Set the content type and disposition
                        $response->headers->set('Content-Type', 'application/pdf');
                        $response->headers->set('Content-Disposition', $disposition);

                        // Dispatch request
                        return $response;
                    }
                }

            Source: https://ourcodeworld.com/articles/read/329/how-to-send-a-file-as-response-from-a-controller-in-symfony-3


        .. tab:: Laravel

            .. code-block:: php

                <?php

                namespace App\Http\Controllers;

                use Illuminate\Http\Request;

                class DownloadLabelController extends Controller
                {
                     public function downloadLabelAction(Request $request) {
                        // Create the label
                        $label = ...;

                        return response()
                            ->header('Content-Type', 'application/pdf')
                            ->header('Content-Disposition', 'attachment; filename="label.pdf"');
                    }
                }

            | Source: https://laravel.com/docs/8.x/controllers
            | Source: https://gist.github.com/diegofelix/8863402

-------------------
Tracking a shipment
-------------------

You can track a single shipment by calling :php:meth:`Firstred\\PostNL\\PostNL::getShippingStatusByBarcode` with the barcode of the shipment.

It accepts the following parameters:

.. confval:: barcode

    The actual barcode, for example: ``3SABCD1837238723``.

.. confval:: complete

    Whether the method should return a complete status update. A complete status update contains the shipment history as well.

Code example:

.. tabs::

    .. tab:: PHP 5/7

        .. code-block:: php

            $postnl = new PostNL(...);

            $currentStatusResponse = $postnl->getShippingStatusByBarcode(
                '3SABCD1837238723', // Barcode
                false               // Return just the current status (complete = false)
            );

    .. tab:: PHP 8

        .. code-block:: php

            $postnl = new PostNL(...);

            $currentStatusResponse = $postnl->getShippingStatusByBarcode(
                barcode: '3SABCD1837238723',
                complete: false,
            );


