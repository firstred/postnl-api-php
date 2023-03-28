<?php
declare(strict_types=1);
/**
 * The MIT License (MIT).
 *
 * Copyright (c) 2017-2023 Michael Dekker (https://github.com/firstred)
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
 * @copyright 2017-2023 Michael Dekker
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Service\RequestBuilder\Rest;

use Firstred\PostNL\Entity\AbstractEntity;
use Firstred\PostNL\Entity\Request\GetTimeframes;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Firstred\PostNL\Service\RequestBuilder\TimeframeServiceRequestBuilderInterface;
use Firstred\PostNL\Service\TimeframeServiceInterface;
use Firstred\PostNL\Util\Util;
use Psr\Http\Message\RequestInterface;
use ReflectionException;
use const PHP_QUERY_RFC3986;

/**
 * @since 2.0.0
 * @internal
 */
class TimeframeServiceRestRequestBuilder extends AbstractRestRequestBuilder implements TimeframeServiceRequestBuilderInterface
{
    // Endpoints
    private const LIVE_ENDPOINT = 'https://api.postnl.nl/shipment/${VERSION}/calculate/timeframes';
    private const SANDBOX_ENDPOINT = 'https://api-sandbox.postnl.nl/shipment/${VERSION}/calculate/timeframes';

    /**
     * Build the GetTimeframes request for the REST API.
     *
     * @param GetTimeframes $getTimeframes
     *
     * @return RequestInterface
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @since 2.0.0
     */
    public function buildGetTimeframesRequest(GetTimeframes $getTimeframes): RequestInterface
    {
        $this->setService(entity: $getTimeframes);

        $timeframe = $getTimeframes->getTimeframe()[0];
        $query = [
            'AllowSundaySorting' => in_array(needle: $timeframe->getSundaySorting(), haystack: [true, 'true', 1], strict: true) ? 'true' : 'false',
            'StartDate'          => $timeframe->getStartDate()->format(format: 'd-m-Y'),
            'EndDate'            => $timeframe->getEndDate()->format(format: 'd-m-Y'),
            'PostalCode'         => $timeframe->getPostalCode(),
            'HouseNumber'        => $timeframe->getHouseNr(),
            'CountryCode'        => $timeframe->getCountryCode(),
            'Options'            => '',
        ];
        if ($interval = $timeframe->getInterval()) {
            $query['Interval'] = $interval;
        }
        if ($houseNrExt = $timeframe->getHouseNrExt()) {
            $query['HouseNrExt'] = $houseNrExt;
        }
        if ($timeframeRange = $timeframe->getTimeframeRange()) {
            $query['TimeframeRange'] = $timeframeRange;
        }
        if ($street = $timeframe->getStreet()) {
            $query['Street'] = $street;
        }
        if ($city = $timeframe->getCity()) {
            $query['City'] = $city;
        }
        foreach ($timeframe->getOptions() as $option) {
            $query['Options'] .= ",$option";
        }
        $query['Options'] = ltrim(string: $query['Options'], characters: ',');
        $query['Options'] = $query['Options'] ?: 'Daytime';

        $endpoint = '?'.http_build_query(data: $query, numeric_prefix: '', arg_separator: '&', encoding_type: PHP_QUERY_RFC3986);

        return $this->getRequestFactory()->createRequest(
            method: 'GET',
            uri: Util::versionStringToURLString(
                version: $this->getVersion(),
                url: (($this->isSandbox() ? static::SANDBOX_ENDPOINT : static::LIVE_ENDPOINT).$endpoint),
            ))
            ->withHeader('apikey', value: $this->getApiKey()->getString())
            ->withHeader('Accept', value: 'application/json');
    }

    /**
     * @param AbstractEntity $entity
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @since 2.0.0
     */
    protected function setService(AbstractEntity $entity): void
    {
        $entity->setCurrentService(currentService: TimeframeServiceInterface::class);

        parent::setService(entity: $entity);
    }
}
