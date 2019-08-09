<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
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
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

/**
 * Class NationalBusinessCheckResult
 */
class NationalBusinessCheckResult extends AbstractEntity
{

    /**
     * @var string|null $branchNumber
     *
     * @since 2.0.0
     */
    protected $branchNumber;

    /**
     * @var string|null $companyPhoneNumber
     *
     * @since 2.0.0
     */
    protected $companyPhoneNumber;

    /**
     * @var string|null $companyMobilePhoneNumber
     *
     * @since 2.0.0
     */
    protected $companyMobilePhoneNumber;

    /**
     * @var string|null $branchStreetName
     *
     * @since 2.0.0
     */
    protected $branchStreetName;

    /**
     * @var string|null $branchHouseNumber
     *
     * @since 2.0.0
     */
    protected $branchHouseNumber;

    /**
     * @var string|null $branchHouseNumberAddition
     *
     * @since 2.0.0
     */
    protected $branchHouseNumberAddition;

    /**
     * @var string|null $branchPostalCode
     *
     * @since 2.0.0
     */
    protected $branchPostalCode;

    /**
     * @var string|null $branchCity
     *
     * @since 2.0.0
     */
    protected $branchCity;

    /**
     * @var string|null $mailingStreetName
     *
     * @since 2.0.0
     */
    protected $mailingStreetName;

    /**
     * @var string|null $mailingHouseNumber
     *
     * @since 2.0.0
     */
    protected $mailingHouseNumber;

    /**
     * @var string|null $mailingHouseNumberAddition
     *
     * @since 2.0.0
     */
    protected $mailingHouseNumberAddition;

    /**
     * @var string|null $mailingPostalCode
     *
     * @since 2.0.0
     */
    protected $mailingPostalCode;

    /**
     * @var string|null $mailingCity
     *
     * @since 2.0.0
     */
    protected $mailingCity;

    /**
     * @var string|null $legalName
     *
     * @since 2.0.0
     */
    protected $legalName;

    /**
     * @var string|null $tradeNames
     *
     * @since 2.0.0
     */
    protected $tradeNames;

    /**
     * @var string|null $rsin
     *
     * @since 2.0.0
     */
    protected $rsin;

    /**
     * @var string|null $legalTypeCd
     *
     * @since 2.0.0
     */
    protected $legalTypeCd;

    /**
     * @var string|null $commercialInd
     *
     * @since 2.0.0
     */
    protected $commercialInd;

    /**
     * @var string|null $headOfficeInd
     *
     * @since 2.0.0
     */
    protected $headOfficeInd;

    /**
     * @var string|null $allowDmInd
     *
     * @since 2.0.0
     */
    protected $allowDmInd;

    /**
     * @var string|null $url
     *
     * @since 2.0.0
     */
    protected $url;

    /**
     * @var string|null $postnlKey
     *
     * @since 2.0.0
     */
    protected $postnlKey;

    /**
     * @var string|null $registrationDate
     *
     * @since 2.0.0
     */
    protected $registrationDate;

    /**
     * @var string|null $registrationReasonCd
     *
     * @since 2.0.0
     */
    protected $registrationReasonCd;

    /**
     * @var string|null $registrationReasonDesc
     *
     * @since 2.0.0
     */
    protected $registrationReasonDesc;

    /**
     * @var string|null $bankruptInd
     *
     * @since 2.0.0
     */
    protected $bankruptInd;

    /**
     * @var string|null $surceanceInd
     *
     * @since 2.0.0
     */
    protected $surceanceInd;

    /**
     * @var string|null $xCoordinate
     *
     * @since 2.0.0
     */
    protected $xCoordinate;

    /**
     * @var string|null $yCoordinate
     *
     * @since 2.0.0
     */
    protected $yCoordinate;

    /**
     * @var string|null $longitude
     *
     * @since 2.0.0
     */
    protected $longitude;

    /**
     * @var string|null $latitude
     *
     * @since 2.0.0
     */
    protected $latitude;

    /**
     * @var string|null $cbiCds
     *
     * @since 2.0.0
     */
    protected $cbiCds;

    /**
     * @var string|null $cbiDescription
     *
     * @since 2.0.0
     */
    protected $cbiDescription;

    /**
     * @var string|null $numberOfEmployees
     *
     * @since 2.0.0
     */
    protected $numberOfEmployees;

    /**
     * @var string|null $numberOfAGWP
     *
     * @since 2.0.0
     */
    protected $numberOfAGWP;

    /**
     * @var string|null $kvkPerson
     *
     * @since 2.0.0
     */
    protected $kvkPerson;

    /**
     * @var string|null $functionCd
     *
     * @since 2.0.0
     */
    protected $functionCd;

    /**
     * @var string|null $functionDesc
     *
     * @since 2.0.0
     */
    protected $functionDesc;

    /**
     * @var string|null $initials
     *
     * @since 2.0.0
     */
    protected $initials;

    /**
     * @var string|null $prefix
     *
     * @since 2.0.0
     */
    protected $prefix;

    /**
     * @var string|null $lastname
     *
     * @since 2.0.0
     */
    protected $lastname;

    /**
     * @var string|null $gender
     *
     * @since 2.0.0
     */
    protected $gender;

    /**
     * @var string|null $dmuPersons
     *
     * @since 2.0.0
     */
    protected $dmuPersons;

    /**
     * @var string|null $mhicCompanyName
     *
     * @since 2.0.0
     */
    protected $mhicCompanyName;

    /**
     * @var string|null $mhicPostnlKey
     *
     * @since 2.0.0
     */
    protected $mhicPostnlKey;

    // @codingStandardsIgnoreStart
    /**
     * @var string|null $m1CompanyName
     *
     * @since 2.0.0
     */
    protected $m1CompanyName;

    /**
     * @var string|null $m1PostnlKey
     *
     * @since 2.0.0
     */
    protected $m1PostnlKey;
    // @codingStandardsIgnoreEnd

    /**
     * @var string|null $authorizedPersons
     *
     * @since 2.0.0
     */
    protected $authorizedPersons;

    /**
     * @var string|null $apFunction
     *
     * @since 2.0.0
     */
    protected $apFunction;

    /**
     * @var string|null $apType
     *
     * @since 2.0.0
     */
    protected $apType;

    /**
     * @var string|null $apInitials
     *
     * @since 2.0.0
     */
    protected $apInitials;

    /**
     * @var string|null $apPrefix
     *
     * @since 2.0.0
     */
    protected $apPrefix;

    /**
     * @var string|null $apLastName
     *
     * @since 2.0.0
     */
    protected $apLastName;

    /**
     * @var string|null $apGender
     *
     * @since 2.0.0
     */
    protected $apGender;

    /**
     * @var string|null $authorizedCompanies
     *
     * @since 2.0.0
     */
    protected $authorizedCompanies;

    /**
     * @var string|null $acKvkNumber
     *
     * @since 2.0.0
     */
    protected $acKvkNumber;

    /**
     * @var string|null $acName
     *
     * @since 2.0.0
     */
    protected $acName;

    /**
     * @var string|null $acFunction
     *
     * @since 2.0.0
     */
    protected $acFunction;

    /**
     * @var string|null $acStartDate
     *
     * @since 2.0.0
     */
    protected $acStartDate;

    /**
     * @var string|null $acPersonFunction
     *
     * @since 2.0.0
     */
    protected $acPersonFunction;

    /**
     * @var string|null $acPersonType
     *
     * @since 2.0.0
     */
    protected $acPersonType;

    /**
     * @var string|null $acPersonInitials
     *
     * @since 2.0.0
     */
    protected $acPersonInitials;

    /**
     * @var string|null $acPersonPrefix
     *
     * @since 2.0.0
     */
    protected $acPersonPrefix;

    /**
     * @var string|null $acPersonLastName
     *
     * @since 2.0.0
     */
    protected $acPersonLastName;

    /**
     * @var string|null $acPersonGender
     *
     * @since 2.0.0
     */
    protected $acPersonGender;

    /**
     * NationalBusinessCheckResult constructor.
     *
     * @since 2.0.0
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getBranchNumber(): ?string
    {
        return $this->branchNumber;
    }

    /**
     * @param string|null $branchNumber
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setBranchNumber(?string $branchNumber): NationalBusinessCheckResult
    {
        $this->branchNumber = $branchNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getCompanyPhoneNumber(): ?string
    {
        return $this->companyPhoneNumber;
    }

    /**
     * @param string|null $companyPhoneNumber
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setCompanyPhoneNumber(?string $companyPhoneNumber): NationalBusinessCheckResult
    {
        $this->companyPhoneNumber = $companyPhoneNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getCompanyMobilePhoneNumber(): ?string
    {
        return $this->companyMobilePhoneNumber;
    }

    /**
     * @param string|null $companyMobilePhoneNumber
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setCompanyMobilePhoneNumber(?string $companyMobilePhoneNumber): NationalBusinessCheckResult
    {
        $this->companyMobilePhoneNumber = $companyMobilePhoneNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getBranchStreetName(): ?string
    {
        return $this->branchStreetName;
    }

    /**
     * @param string|null $branchStreetName
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setBranchStreetName(?string $branchStreetName): NationalBusinessCheckResult
    {
        $this->branchStreetName = $branchStreetName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getBranchHouseNumber(): ?string
    {
        return $this->branchHouseNumber;
    }

    /**
     * @param string|null $branchHouseNumber
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setBranchHouseNumber(?string $branchHouseNumber): NationalBusinessCheckResult
    {
        $this->branchHouseNumber = $branchHouseNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getBranchHouseNumberAddition(): ?string
    {
        return $this->branchHouseNumberAddition;
    }

    /**
     * @param string|null $branchHouseNumberAddition
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setBranchHouseNumberAddition(?string $branchHouseNumberAddition): NationalBusinessCheckResult
    {
        $this->branchHouseNumberAddition = $branchHouseNumberAddition;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getBranchPostalCode(): ?string
    {
        return $this->branchPostalCode;
    }

    /**
     * @param string|null $branchPostalCode
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setBranchPostalCode(?string $branchPostalCode): NationalBusinessCheckResult
    {
        $this->branchPostalCode = $branchPostalCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getBranchCity(): ?string
    {
        return $this->branchCity;
    }

    /**
     * @param string|null $branchCity
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setBranchCity(?string $branchCity): NationalBusinessCheckResult
    {
        $this->branchCity = $branchCity;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getMailingStreetName(): ?string
    {
        return $this->mailingStreetName;
    }

    /**
     * @param string|null $mailingStreetName
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setMailingStreetName(?string $mailingStreetName): NationalBusinessCheckResult
    {
        $this->mailingStreetName = $mailingStreetName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getMailingHouseNumber(): ?string
    {
        return $this->mailingHouseNumber;
    }

    /**
     * @param string|null $mailingHouseNumber
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setMailingHouseNumber(?string $mailingHouseNumber): NationalBusinessCheckResult
    {
        $this->mailingHouseNumber = $mailingHouseNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getMailingHouseNumberAddition(): ?string
    {
        return $this->mailingHouseNumberAddition;
    }

    /**
     * @param string|null $mailingHouseNumberAddition
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setMailingHouseNumberAddition(?string $mailingHouseNumberAddition): NationalBusinessCheckResult
    {
        $this->mailingHouseNumberAddition = $mailingHouseNumberAddition;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getMailingPostalCode(): ?string
    {
        return $this->mailingPostalCode;
    }

    /**
     * @param string|null $mailingPostalCode
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setMailingPostalCode(?string $mailingPostalCode): NationalBusinessCheckResult
    {
        $this->mailingPostalCode = $mailingPostalCode;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getMailingCity(): ?string
    {
        return $this->mailingCity;
    }

    /**
     * @param string|null $mailingCity
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setMailingCity(?string $mailingCity): NationalBusinessCheckResult
    {
        $this->mailingCity = $mailingCity;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    /**
     * @param string|null $legalName
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setLegalName(?string $legalName): NationalBusinessCheckResult
    {
        $this->legalName = $legalName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getTradeNames(): ?string
    {
        return $this->tradeNames;
    }

    /**
     * @param string|null $tradeNames
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setTradeNames(?string $tradeNames): NationalBusinessCheckResult
    {
        $this->tradeNames = $tradeNames;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getRsin(): ?string
    {
        return $this->rsin;
    }

    /**
     * @param string|null $rsin
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setRsin(?string $rsin): NationalBusinessCheckResult
    {
        $this->rsin = $rsin;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getLegalTypeCd(): ?string
    {
        return $this->legalTypeCd;
    }

    /**
     * @param string|null $legalTypeCd
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setLegalTypeCd(?string $legalTypeCd): NationalBusinessCheckResult
    {
        $this->legalTypeCd = $legalTypeCd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getCommercialInd(): ?string
    {
        return $this->commercialInd;
    }

    /**
     * @param string|null $commercialInd
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setCommercialInd(?string $commercialInd): NationalBusinessCheckResult
    {
        $this->commercialInd = $commercialInd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getHeadOfficeInd(): ?string
    {
        return $this->headOfficeInd;
    }

    /**
     * @param string|null $headOfficeInd
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setHeadOfficeInd(?string $headOfficeInd): NationalBusinessCheckResult
    {
        $this->headOfficeInd = $headOfficeInd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getAllowDmInd(): ?string
    {
        return $this->allowDmInd;
    }

    /**
     * @param string|null $allowDmInd
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setAllowDmInd(?string $allowDmInd): NationalBusinessCheckResult
    {
        $this->allowDmInd = $allowDmInd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setUrl(?string $url): NationalBusinessCheckResult
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPostnlKey(): ?string
    {
        return $this->postnlKey;
    }

    /**
     * @param string|null $postnlKey
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setPostnlKey(?string $postnlKey): NationalBusinessCheckResult
    {
        $this->postnlKey = $postnlKey;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRegistrationDate(): ?string
    {
        return $this->registrationDate;
    }

    /**
     * @param string|null $registrationDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRegistrationDate(?string $registrationDate): NationalBusinessCheckResult
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRegistrationReasonCd(): ?string
    {
        return $this->registrationReasonCd;
    }

    /**
     * @param string|null $registrationReasonCd
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRegistrationReasonCd(?string $registrationReasonCd): NationalBusinessCheckResult
    {
        $this->registrationReasonCd = $registrationReasonCd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getRegistrationReasonDesc(): ?string
    {
        return $this->registrationReasonDesc;
    }

    /**
     * @param string|null $registrationReasonDesc
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setRegistrationReasonDesc(?string $registrationReasonDesc): NationalBusinessCheckResult
    {
        $this->registrationReasonDesc = $registrationReasonDesc;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getBankruptInd(): ?string
    {
        return $this->bankruptInd;
    }

    /**
     * @param string|null $bankruptInd
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setBankruptInd(?string $bankruptInd): NationalBusinessCheckResult
    {
        $this->bankruptInd = $bankruptInd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getSurceanceInd(): ?string
    {
        return $this->surceanceInd;
    }

    /**
     * @param string|null $surceanceInd
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setSurceanceInd(?string $surceanceInd): NationalBusinessCheckResult
    {
        $this->surceanceInd = $surceanceInd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getXCoordinate(): ?string
    {
        return $this->xCoordinate;
    }

    /**
     * @param string|null $xCoordinate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setXCoordinate(?string $xCoordinate): NationalBusinessCheckResult
    {
        $this->xCoordinate = $xCoordinate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getYCoordinate(): ?string
    {
        return $this->yCoordinate;
    }

    /**
     * @param string|null $yCoordinate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setYCoordinate(?string $yCoordinate): NationalBusinessCheckResult
    {
        $this->yCoordinate = $yCoordinate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string|null $longitude
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLongitude(?string $longitude): NationalBusinessCheckResult
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string|null $latitude
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLatitude(?string $latitude): NationalBusinessCheckResult
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCbiCds(): ?string
    {
        return $this->cbiCds;
    }

    /**
     * @param string|null $cbiCds
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCbiCds(?string $cbiCds): NationalBusinessCheckResult
    {
        $this->cbiCds = $cbiCds;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getCbiDescription(): ?string
    {
        return $this->cbiDescription;
    }

    /**
     * @param string|null $cbiDescription
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setCbiDescription(?string $cbiDescription): NationalBusinessCheckResult
    {
        $this->cbiDescription = $cbiDescription;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getNumberOfEmployees(): ?string
    {
        return $this->numberOfEmployees;
    }

    /**
     * @param string|null $numberOfEmployees
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setNumberOfEmployees(?string $numberOfEmployees): NationalBusinessCheckResult
    {
        $this->numberOfEmployees = $numberOfEmployees;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getNumberOfAGWP(): ?string
    {
        return $this->numberOfAGWP;
    }

    /**
     * @param string|null $numberOfAGWP
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setNumberOfAGWP(?string $numberOfAGWP): NationalBusinessCheckResult
    {
        $this->numberOfAGWP = $numberOfAGWP;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getKvkPerson(): ?string
    {
        return $this->kvkPerson;
    }

    /**
     * @param string|null $kvkPerson
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setKvkPerson(?string $kvkPerson): NationalBusinessCheckResult
    {
        $this->kvkPerson = $kvkPerson;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getFunctionCd(): ?string
    {
        return $this->functionCd;
    }

    /**
     * @param string|null $functionCd
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setFunctionCd(?string $functionCd): NationalBusinessCheckResult
    {
        $this->functionCd = $functionCd;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getFunctionDesc(): ?string
    {
        return $this->functionDesc;
    }

    /**
     * @param string|null $functionDesc
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setFunctionDesc(?string $functionDesc): NationalBusinessCheckResult
    {
        $this->functionDesc = $functionDesc;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getInitials(): ?string
    {
        return $this->initials;
    }

    /**
     * @param string|null $initials
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setInitials(?string $initials): NationalBusinessCheckResult
    {
        $this->initials = $initials;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * @param string|null $prefix
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setPrefix(?string $prefix): NationalBusinessCheckResult
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setLastname(?string $lastname): NationalBusinessCheckResult
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setGender(?string $gender): NationalBusinessCheckResult
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getDmuPersons(): ?string
    {
        return $this->dmuPersons;
    }

    /**
     * @param string|null $dmuPersons
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setDmuPersons(?string $dmuPersons): NationalBusinessCheckResult
    {
        $this->dmuPersons = $dmuPersons;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getMhicCompanyName(): ?string
    {
        return $this->mhicCompanyName;
    }

    /**
     * @param string|null $mhicCompanyName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMhicCompanyName(?string $mhicCompanyName): NationalBusinessCheckResult
    {
        $this->mhicCompanyName = $mhicCompanyName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getMhicPostnlKey(): ?string
    {
        return $this->mhicPostnlKey;
    }

    /**
     * @param string|null $mhicPostnlKey
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setMhicPostnlKey(?string $mhicPostnlKey): NationalBusinessCheckResult
    {
        $this->mhicPostnlKey = $mhicPostnlKey;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getM1CompanyName(): ?string
    {
        return $this->m1CompanyName;
    }

    /**
     * @param string|null $m1CompanyName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setM1CompanyName(?string $m1CompanyName): NationalBusinessCheckResult
    {
        $this->m1CompanyName = $m1CompanyName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getM1PostnlKey(): ?string
    {
        return $this->m1PostnlKey;
    }

    /**
     * @param string|null $m1PostnlKey
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setM1PostnlKey(?string $m1PostnlKey): NationalBusinessCheckResult
    {
        $this->m1PostnlKey = $m1PostnlKey;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAuthorizedPersons(): ?string
    {
        return $this->authorizedPersons;
    }

    /**
     * @param string|null $authorizedPersons
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAuthorizedPersons(?string $authorizedPersons): NationalBusinessCheckResult
    {
        $this->authorizedPersons = $authorizedPersons;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getApFunction(): ?string
    {
        return $this->apFunction;
    }

    /**
     * @param string|null $apFunction
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setApFunction(?string $apFunction): NationalBusinessCheckResult
    {
        $this->apFunction = $apFunction;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getApType(): ?string
    {
        return $this->apType;
    }

    /**
     * @param string|null $apType
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setApType(?string $apType): NationalBusinessCheckResult
    {
        $this->apType = $apType;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getApInitials(): ?string
    {
        return $this->apInitials;
    }

    /**
     * @param string|null $apInitials
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setApInitials(?string $apInitials): NationalBusinessCheckResult
    {
        $this->apInitials = $apInitials;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getApPrefix(): ?string
    {
        return $this->apPrefix;
    }

    /**
     * @param string|null $apPrefix
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setApPrefix(?string $apPrefix): NationalBusinessCheckResult
    {
        $this->apPrefix = $apPrefix;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getApLastName(): ?string
    {
        return $this->apLastName;
    }

    /**
     * @param string|null $apLastName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setApLastName(?string $apLastName): NationalBusinessCheckResult
    {
        $this->apLastName = $apLastName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getApGender(): ?string
    {
        return $this->apGender;
    }

    /**
     * @param string|null $apGender
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setApGender(?string $apGender): NationalBusinessCheckResult
    {
        $this->apGender = $apGender;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAuthorizedCompanies(): ?string
    {
        return $this->authorizedCompanies;
    }

    /**
     * @param string|null $authorizedCompanies
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAuthorizedCompanies(?string $authorizedCompanies): NationalBusinessCheckResult
    {
        $this->authorizedCompanies = $authorizedCompanies;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcKvkNumber(): ?string
    {
        return $this->acKvkNumber;
    }

    /**
     * @param string|null $acKvkNumber
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcKvkNumber(?string $acKvkNumber): NationalBusinessCheckResult
    {
        $this->acKvkNumber = $acKvkNumber;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcName(): ?string
    {
        return $this->acName;
    }

    /**
     * @param string|null $acName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcName(?string $acName): NationalBusinessCheckResult
    {
        $this->acName = $acName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcFunction(): ?string
    {
        return $this->acFunction;
    }

    /**
     * @param string|null $acFunction
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcFunction(?string $acFunction): NationalBusinessCheckResult
    {
        $this->acFunction = $acFunction;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcStartDate(): ?string
    {
        return $this->acStartDate;
    }

    /**
     * @param string|null $acStartDate
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcStartDate(?string $acStartDate): NationalBusinessCheckResult
    {
        $this->acStartDate = $acStartDate;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcPersonFunction(): ?string
    {
        return $this->acPersonFunction;
    }

    /**
     * @param string|null $acPersonFunction
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcPersonFunction(?string $acPersonFunction): NationalBusinessCheckResult
    {
        $this->acPersonFunction = $acPersonFunction;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcPersonType(): ?string
    {
        return $this->acPersonType;
    }

    /**
     * @param string|null $acPersonType
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcPersonType(?string $acPersonType): NationalBusinessCheckResult
    {
        $this->acPersonType = $acPersonType;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcPersonInitials(): ?string
    {
        return $this->acPersonInitials;
    }

    /**
     * @param string|null $acPersonInitials
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcPersonInitials(?string $acPersonInitials): NationalBusinessCheckResult
    {
        $this->acPersonInitials = $acPersonInitials;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcPersonPrefix(): ?string
    {
        return $this->acPersonPrefix;
    }

    /**
     * @param string|null $acPersonPrefix
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcPersonPrefix(?string $acPersonPrefix): NationalBusinessCheckResult
    {
        $this->acPersonPrefix = $acPersonPrefix;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcPersonLastName(): ?string
    {
        return $this->acPersonLastName;
    }

    /**
     * @param string|null $acPersonLastName
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcPersonLastName(?string $acPersonLastName): NationalBusinessCheckResult
    {
        $this->acPersonLastName = $acPersonLastName;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0 Strict typing
     */
    public function getAcPersonGender(): ?string
    {
        return $this->acPersonGender;
    }

    /**
     * @param string|null $acPersonGender
     *
     * @return static
     *
     * @since 2.0.0 Strict typing
     */
    public function setAcPersonGender(?string $acPersonGender): NationalBusinessCheckResult
    {
        $this->acPersonGender = $acPersonGender;

        return $this;
    }
}
