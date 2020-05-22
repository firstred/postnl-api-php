<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
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
 *
 * @copyright 2017-2020 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity;

use Firstred\PostNL\Misc\FlexibleEntityTrait;

/**
 * Class NationalBusinessCheckResult
 */
class NationalBusinessCheckResult extends AbstractEntity
{
    use FlexibleEntityTrait;

    /**
     * Organizational name
     *
     * @pattern ^.{0,100}$
     *
     * @example Koninklijke Postnl B.V.
     *
     * @var string|null $companyName
     *
     * @since 2.0.0
     */
    protected $companyName;

    /**
     * KvK number
     *
     * @pattern N/A
     *
     * @example 27124700
     *
     * @var string|null $kvkNumber
     *
     * @since 2.0.0
     */
    protected $kvkNumber;

    /**
     * PostNL identification number
     *
     * @pattern N/A
     *
     * @example 1004364844
     *
     * @var string|null $postnlKey
     *
     * @since 2.0.0
     */
    protected $postnlKey;

    /**
     * CoC-location identification number.
     *
     * Dutch: vestigingsnummer
     *
     * @pattern ^.{1,12}$
     *
     * @example 000017063566
     *
     * @var string|null $branchNumber
     *
     * @since 2.0.0
     */
    protected $branchNumber;

    /**
     * Main phone number
     *
     * @pattern N/A
     *
     * @example 9000990
     *
     * @var string|null $companyPhoneNumber
     *
     * @since 2.0.0
     */
    protected $companyPhoneNumber;

    /**
     * Main mobile phone number
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $companyMobilePhoneNumber
     *
     * @since 2.0.0
     */
    protected $companyMobilePhoneNumber;

    /**
     * Branch street name
     *
     * @pattern N/A
     *
     * @example Prinses Beatrixlaan
     *
     * @var string|null $branchStreetName
     *
     * @since 2.0.0
     */
    protected $branchStreetName;

    /**
     * Branch house number
     *
     * @pattern N/A
     *
     * @example 23
     *
     * @var string|null $branchHouseNumber
     *
     * @since 2.0.0
     */
    protected $branchHouseNumber;

    /**
     * Branch house number addition
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $branchHouseNumberAddition
     *
     * @since 2.0.0
     */
    protected $branchHouseNumberAddition;

    /**
     * Branch postal code
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $branchPostalCode
     *
     * @since 2.0.0
     */
    protected $branchPostalCode;

    /**
     * Branch city
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $branchCity
     *
     * @since 2.0.0
     */
    protected $branchCity;

    /**
     * Mailing street name
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $mailingStreetName
     *
     * @since 2.0.0
     */
    protected $mailingStreetName;

    /**
     * Mailing house number
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $mailingHouseNumber
     *
     * @since 2.0.0
     */
    protected $mailingHouseNumber;

    /**
     * Mailing house number addition
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $mailingHouseNumberAddition
     *
     * @since 2.0.0
     */
    protected $mailingHouseNumberAddition;

    /**
     * Mailing postal code
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $mailingPostalCode
     *
     * @since 2.0.0
     */
    protected $mailingPostalCode;

    /**
     * Mailing city
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $mailingCity
     *
     * @since 2.0.0
     */
    protected $mailingCity;

    /**
     * Legal name
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $legalName
     *
     * @since 2.0.0
     */
    protected $legalName;

    /**
     * Trade names
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $tradeNames
     *
     * @since 2.0.0
     */
    protected $tradeNames;

    /**
     * RSIN
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $rsin
     *
     * @since 2.0.0
     */
    protected $rsin;

    /**
     * Legal type CD
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $legalTypeCd
     *
     * @since 2.0.0
     */
    protected $legalTypeCd;

    /**
     * Commercial Ind
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $commercialInd
     *
     * @since 2.0.0
     */
    protected $commercialInd;

    /**
     * Head office Ind
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $headOfficeInd
     *
     * @since 2.0.0
     */
    protected $headOfficeInd;

    /**
     * Allow DM Ind
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $allowDmInd
     *
     * @since 2.0.0
     */
    protected $allowDmInd;

    /**
     * URL
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $url
     *
     * @since 2.0.0
     */
    protected $url;

    /**
     * Registration date
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $registrationDate
     *
     * @since 2.0.0
     */
    protected $registrationDate;

    /**
     * Registration reason CD
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $registrationReasonCd
     *
     * @since 2.0.0
     */
    protected $registrationReasonCd;

    /**
     * Registration reason Desc
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $registrationReasonDesc
     *
     * @since 2.0.0
     */
    protected $registrationReasonDesc;

    /**
     * Bankrupt Ind
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $bankruptInd
     *
     * @since 2.0.0
     */
    protected $bankruptInd;

    /**
     * Surceance Ind
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $surceanceInd
     *
     * @since 2.0.0
     */
    protected $surceanceInd;

    /**
     * Rijksdriehoek X-coordinate
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $xCoordinate
     *
     * @since 2.0.0
     */
    protected $xCoordinate;

    /**
     * Rijksdriehoek Y-coordinate
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $yCoordinate
     *
     * @since 2.0.0
     */
    protected $yCoordinate;

    /**
     * Longitude
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $longitude
     *
     * @since 2.0.0
     */
    protected $longitude;

    /**
     * Latitude
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $latitude
     *
     * @since 2.0.0
     */
    protected $latitude;

    /**
     * CbiCds
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $cbiCds
     *
     * @since 2.0.0
     */
    protected $cbiCds;

    /**
     * CBI description
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $cbiDescription
     *
     * @since 2.0.0
     */
    protected $cbiDescription;

    /**
     * Number of employees
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $numberOfEmployees
     *
     * @since 2.0.0
     */
    protected $numberOfEmployees;

    /**
     * Number of AGWP
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $numberOfAGWP
     *
     * @since 2.0.0
     */
    protected $numberOfAGWP;

    /**
     * KvK person
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $kvkPerson
     *
     * @since 2.0.0
     */
    protected $kvkPerson;

    /**
     * Function CD
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $functionCd
     *
     * @since 2.0.0
     */
    protected $functionCd;

    /**
     * Function description
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $functionDesc
     *
     * @since 2.0.0
     */
    protected $functionDesc;

    /**
     * Initials
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $initials
     *
     * @since 2.0.0
     */
    protected $initials;

    /**
     * Prefix
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $prefix
     *
     * @since 2.0.0
     */
    protected $prefix;

    /**
     * Last name
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $lastname
     *
     * @since 2.0.0
     */
    protected $lastname;

    /**
     * Gender
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $gender
     *
     * @since 2.0.0
     */
    protected $gender;

    /**
     * DMU Persons
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $dmuPersons
     *
     * @since 2.0.0
     */
    protected $dmuPersons;

    /**
     * MHIC Company name
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $mhicCompanyName
     *
     * @since 2.0.0
     */
    protected $mhicCompanyName;

    /**
     * MHIC PostNL key
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $mhicPostnlKey
     *
     * @since 2.0.0
     */
    protected $mhicPostnlKey;

    // @codingStandardsIgnoreStart
    /**
     * m1 company name
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $m1CompanyName
     *
     * @since 2.0.0
     */
    protected $m1CompanyName;

    /**
     * m1 PostNL key
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $m1PostnlKey
     *
     * @since 2.0.0
     */
    protected $m1PostnlKey;
    // @codingStandardsIgnoreEnd

    /**
     * Authorized persons
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $authorizedPersons
     *
     * @since 2.0.0
     */
    protected $authorizedPersons;

    /**
     * AP function
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $apFunction
     *
     * @since 2.0.0
     */
    protected $apFunction;

    /**
     * AP type
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $apType
     *
     * @since 2.0.0
     */
    protected $apType;

    /**
     * AP initials
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $apInitials
     *
     * @since 2.0.0
     */
    protected $apInitials;

    /**
     * AP prefix
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $apPrefix
     *
     * @since 2.0.0
     */
    protected $apPrefix;

    /**
     * AP last name
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $apLastName
     *
     * @since 2.0.0
     */
    protected $apLastName;

    /**
     * AP gender
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $apGender
     *
     * @since 2.0.0
     */
    protected $apGender;

    /**
     * Authorized companies
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $authorizedCompanies
     *
     * @since 2.0.0
     */
    protected $authorizedCompanies;

    /**
     * AC KvK Number
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acKvkNumber
     *
     * @since 2.0.0
     */
    protected $acKvkNumber;

    /**
     * AC name
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acName
     *
     * @since 2.0.0
     */
    protected $acName;

    /**
     * AC function
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acFunction
     *
     * @since 2.0.0
     */
    protected $acFunction;

    /**
     * AC start date
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acStartDate
     *
     * @since 2.0.0
     */
    protected $acStartDate;

    /**
     * AC person function
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acPersonFunction
     *
     * @since 2.0.0
     */
    protected $acPersonFunction;

    /**
     * AC Person type
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acPersonType
     *
     * @since 2.0.0
     */
    protected $acPersonType;

    /**
     * AC Person Initials
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acPersonInitials
     *
     * @since 2.0.0
     */
    protected $acPersonInitials;

    /**
     * AC Person prefix
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acPersonPrefix
     *
     * @since 2.0.0
     */
    protected $acPersonPrefix;

    /**
     * AC Person last name
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $acPersonLastName
     *
     * @since 2.0.0
     */
    protected $acPersonLastName;

    /**
     * AC Person gender
     *
     * @pattern N/A
     *
     * @example N/A
     *
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
     * Get companyName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$companyName
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * Set companyName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $companyName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$companyName
     */
    public function setCompanyName(?string $companyName): NationalBusinessCheckResult
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get kvkNumber
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$kvkNumber
     */
    public function getKvkNumber(): ?string
    {
        return $this->kvkNumber;
    }

    /**
     * Set kvkNumber
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $kvkNumber
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$kvkNumber
     */
    public function setKvkNumber(?string $kvkNumber): NationalBusinessCheckResult
    {
        $this->kvkNumber = $kvkNumber;

        return $this;
    }

    /**
     * Get postnlKey
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$postnlKey
     */
    public function getPostnlKey(): ?string
    {
        return $this->postnlKey;
    }

    /**
     * Set postnlKey
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $postnlKey
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$postnlKey
     */
    public function setPostnlKey(?string $postnlKey): NationalBusinessCheckResult
    {
        $this->postnlKey = $postnlKey;

        return $this;
    }

    /**
     * Get branchNumber
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$branchNumber
     */
    public function getBranchNumber(): ?string
    {
        return $this->branchNumber;
    }

    /**
     * Set branchNumber
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $branchNumber
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$branchNumber
     */
    public function setBranchNumber(?string $branchNumber): NationalBusinessCheckResult
    {
        $this->branchNumber = $branchNumber;

        return $this;
    }

    /**
     * Get companyPhoneNumber
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$companyPhoneNumber
     */
    public function getCompanyPhoneNumber(): ?string
    {
        return $this->companyPhoneNumber;
    }

    /**
     * Set companyPhoneNumber
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $companyPhoneNumber
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$companyPhoneNumber
     */
    public function setCompanyPhoneNumber(?string $companyPhoneNumber): NationalBusinessCheckResult
    {
        $this->companyPhoneNumber = $companyPhoneNumber;

        return $this;
    }

    /**
     * Get companyMobilePhoneNumber
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$companyMobilePhoneNumber
     */
    public function getCompanyMobilePhoneNumber(): ?string
    {
        return $this->companyMobilePhoneNumber;
    }

    /**
     * Set companyMobilePhoneNumber
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $companyMobilePhoneNumber
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$companyMobilePhoneNumber
     */
    public function setCompanyMobilePhoneNumber(?string $companyMobilePhoneNumber): NationalBusinessCheckResult
    {
        $this->companyMobilePhoneNumber = $companyMobilePhoneNumber;

        return $this;
    }

    /**
     * Get branchStreetName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$branchStreetName
     */
    public function getBranchStreetName(): ?string
    {
        return $this->branchStreetName;
    }

    /**
     * Set branchStreetName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $branchStreetName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$branchStreetName
     */
    public function setBranchStreetName(?string $branchStreetName): NationalBusinessCheckResult
    {
        $this->branchStreetName = $branchStreetName;

        return $this;
    }

    /**
     * Get branchHouseNumber
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$branchHouseNumber
     */
    public function getBranchHouseNumber(): ?string
    {
        return $this->branchHouseNumber;
    }

    /**
     * Set branchHouseNumber
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $branchHouseNumber
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$branchHouseNumber
     */
    public function setBranchHouseNumber(?string $branchHouseNumber): NationalBusinessCheckResult
    {
        $this->branchHouseNumber = $branchHouseNumber;

        return $this;
    }

    /**
     * Get branchHouseNumberAddition
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$branchHouseNumberAddition
     */
    public function getBranchHouseNumberAddition(): ?string
    {
        return $this->branchHouseNumberAddition;
    }

    /**
     * Set branchHouseNumberAddition
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $branchHouseNumberAddition
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$branchHouseNumberAddition
     */
    public function setBranchHouseNumberAddition(?string $branchHouseNumberAddition): NationalBusinessCheckResult
    {
        $this->branchHouseNumberAddition = $branchHouseNumberAddition;

        return $this;
    }

    /**
     * Get branchPostalCode
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$branchPostalCode
     */
    public function getBranchPostalCode(): ?string
    {
        return $this->branchPostalCode;
    }

    /**
     * Set branchPostalCode
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $branchPostalCode
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$branchPostalCode
     */
    public function setBranchPostalCode(?string $branchPostalCode): NationalBusinessCheckResult
    {
        $this->branchPostalCode = $branchPostalCode;

        return $this;
    }

    /**
     * Get branchCity
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$branchCity
     */
    public function getBranchCity(): ?string
    {
        return $this->branchCity;
    }

    /**
     * Set branchCity
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $branchCity
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$branchCity
     */
    public function setBranchCity(?string $branchCity): NationalBusinessCheckResult
    {
        $this->branchCity = $branchCity;

        return $this;
    }

    /**
     * Get mailingStreetName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$mailingStreetName
     */
    public function getMailingStreetName(): ?string
    {
        return $this->mailingStreetName;
    }

    /**
     * Set mailingStreetName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $mailingStreetName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$mailingStreetName
     */
    public function setMailingStreetName(?string $mailingStreetName): NationalBusinessCheckResult
    {
        $this->mailingStreetName = $mailingStreetName;

        return $this;
    }

    /**
     * Get mailingHouseNumber
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$mailingHouseNumber
     */
    public function getMailingHouseNumber(): ?string
    {
        return $this->mailingHouseNumber;
    }

    /**
     * Set mailingHouseNumber
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $mailingHouseNumber
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$mailingHouseNumber
     */
    public function setMailingHouseNumber(?string $mailingHouseNumber): NationalBusinessCheckResult
    {
        $this->mailingHouseNumber = $mailingHouseNumber;

        return $this;
    }

    /**
     * Get mailingHouseNumberAddition
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$mailingHouseNumberAddition
     */
    public function getMailingHouseNumberAddition(): ?string
    {
        return $this->mailingHouseNumberAddition;
    }

    /**
     * Set mailingHouseNumberAddition
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $mailingHouseNumberAddition
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$mailingHouseNumberAddition
     */
    public function setMailingHouseNumberAddition(?string $mailingHouseNumberAddition): NationalBusinessCheckResult
    {
        $this->mailingHouseNumberAddition = $mailingHouseNumberAddition;

        return $this;
    }

    /**
     * Get mailingPostalCode
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$mailingPostalCode
     */
    public function getMailingPostalCode(): ?string
    {
        return $this->mailingPostalCode;
    }

    /**
     * Set mailingPostalCode
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $mailingPostalCode
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$mailingPostalCode
     */
    public function setMailingPostalCode(?string $mailingPostalCode): NationalBusinessCheckResult
    {
        $this->mailingPostalCode = $mailingPostalCode;

        return $this;
    }

    /**
     * Get mailingCity
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$mailingCity
     */
    public function getMailingCity(): ?string
    {
        return $this->mailingCity;
    }

    /**
     * Set mailingCity
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $mailingCity
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$mailingCity
     */
    public function setMailingCity(?string $mailingCity): NationalBusinessCheckResult
    {
        $this->mailingCity = $mailingCity;

        return $this;
    }

    /**
     * Get legalName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$legalName
     */
    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    /**
     * Set legalName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $legalName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$legalName
     */
    public function setLegalName(?string $legalName): NationalBusinessCheckResult
    {
        $this->legalName = $legalName;

        return $this;
    }

    /**
     * Get tradeNames
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$tradeNames
     */
    public function getTradeNames(): ?string
    {
        return $this->tradeNames;
    }

    /**
     * Set tradeNames
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $tradeNames
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$tradeNames
     */
    public function setTradeNames(?string $tradeNames): NationalBusinessCheckResult
    {
        $this->tradeNames = $tradeNames;

        return $this;
    }

    /**
     * Get rsin
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$rsin
     */
    public function getRsin(): ?string
    {
        return $this->rsin;
    }

    /**
     * Set rsin
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $rsin
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$rsin
     */
    public function setRsin(?string $rsin): NationalBusinessCheckResult
    {
        $this->rsin = $rsin;

        return $this;
    }

    /**
     * Get legalTypeCd
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$legalTypeCd
     */
    public function getLegalTypeCd(): ?string
    {
        return $this->legalTypeCd;
    }

    /**
     * Set legalTypeCd
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $legalTypeCd
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$legalTypeCd
     */
    public function setLegalTypeCd(?string $legalTypeCd): NationalBusinessCheckResult
    {
        $this->legalTypeCd = $legalTypeCd;

        return $this;
    }

    /**
     * Get commercialInd
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$commercialInd
     */
    public function getCommercialInd(): ?string
    {
        return $this->commercialInd;
    }

    /**
     * Set commercialInd
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $commercialInd
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$commercialInd
     */
    public function setCommercialInd(?string $commercialInd): NationalBusinessCheckResult
    {
        $this->commercialInd = $commercialInd;

        return $this;
    }

    /**
     * Get headOfficeInd
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$headOfficeInd
     */
    public function getHeadOfficeInd(): ?string
    {
        return $this->headOfficeInd;
    }

    /**
     * Set headOfficeInd
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $headOfficeInd
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$headOfficeInd
     */
    public function setHeadOfficeInd(?string $headOfficeInd): NationalBusinessCheckResult
    {
        $this->headOfficeInd = $headOfficeInd;

        return $this;
    }

    /**
     * Get allowDmInd
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$allowDmInd
     */
    public function getAllowDmInd(): ?string
    {
        return $this->allowDmInd;
    }

    /**
     * Set allowDmInd
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $allowDmInd
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$allowDmInd
     */
    public function setAllowDmInd(?string $allowDmInd): NationalBusinessCheckResult
    {
        $this->allowDmInd = $allowDmInd;

        return $this;
    }

    /**
     * Get url
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$url
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $url
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$url
     */
    public function setUrl(?string $url): NationalBusinessCheckResult
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$registrationDate
     */
    public function getRegistrationDate(): ?string
    {
        return $this->registrationDate;
    }

    /**
     * Set registrationDate
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $registrationDate
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$registrationDate
     */
    public function setRegistrationDate(?string $registrationDate): NationalBusinessCheckResult
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationReasonCd
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$registrationReasonCd
     */
    public function getRegistrationReasonCd(): ?string
    {
        return $this->registrationReasonCd;
    }

    /**
     * Set registrationReasonCd
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $registrationReasonCd
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$registrationReasonCd
     */
    public function setRegistrationReasonCd(?string $registrationReasonCd): NationalBusinessCheckResult
    {
        $this->registrationReasonCd = $registrationReasonCd;

        return $this;
    }

    /**
     * Get registrationReasonDesc
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$registrationReasonDesc
     */
    public function getRegistrationReasonDesc(): ?string
    {
        return $this->registrationReasonDesc;
    }

    /**
     * Set registrationReasonDesc
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $registrationReasonDesc
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$registrationReasonDesc
     */
    public function setRegistrationReasonDesc(?string $registrationReasonDesc): NationalBusinessCheckResult
    {
        $this->registrationReasonDesc = $registrationReasonDesc;

        return $this;
    }

    /**
     * Get bankruptInd
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$bankruptInd
     */
    public function getBankruptInd(): ?string
    {
        return $this->bankruptInd;
    }

    /**
     * Set bankruptInd
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $bankruptInd
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$bankruptInd
     */
    public function setBankruptInd(?string $bankruptInd): NationalBusinessCheckResult
    {
        $this->bankruptInd = $bankruptInd;

        return $this;
    }

    /**
     * Get surceanceInd
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$surceanceInd
     */
    public function getSurceanceInd(): ?string
    {
        return $this->surceanceInd;
    }

    /**
     * Set surceanceInd
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $surceanceInd
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$surceanceInd
     */
    public function setSurceanceInd(?string $surceanceInd): NationalBusinessCheckResult
    {
        $this->surceanceInd = $surceanceInd;

        return $this;
    }

    /**
     * Get xCoordinate
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$xCoordinate
     */
    public function getXCoordinate(): ?string
    {
        return $this->xCoordinate;
    }

    /**
     * Set xCoordinate
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $xCoordinate
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$xCoordinate
     */
    public function setXCoordinate(?string $xCoordinate): NationalBusinessCheckResult
    {
        $this->xCoordinate = $xCoordinate;

        return $this;
    }

    /**
     * Get yCoordinate
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$yCoordinate
     */
    public function getYCoordinate(): ?string
    {
        return $this->yCoordinate;
    }

    /**
     * Set yCoordinate
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $yCoordinate
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$yCoordinate
     */
    public function setYCoordinate(?string $yCoordinate): NationalBusinessCheckResult
    {
        $this->yCoordinate = $yCoordinate;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$longitude
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * Set longitude
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $longitude
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$longitude
     */
    public function setLongitude(?string $longitude): NationalBusinessCheckResult
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$latitude
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * Set latitude
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $latitude
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$latitude
     */
    public function setLatitude(?string $latitude): NationalBusinessCheckResult
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get cbiCds
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$cbiCds
     */
    public function getCbiCds(): ?string
    {
        return $this->cbiCds;
    }

    /**
     * Set cbiCds
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $cbiCds
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$cbiCds
     */
    public function setCbiCds(?string $cbiCds): NationalBusinessCheckResult
    {
        $this->cbiCds = $cbiCds;

        return $this;
    }

    /**
     * Get cbiDescription
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$cbiDescription
     */
    public function getCbiDescription(): ?string
    {
        return $this->cbiDescription;
    }

    /**
     * Set cbiDescription
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $cbiDescription
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$cbiDescription
     */
    public function setCbiDescription(?string $cbiDescription): NationalBusinessCheckResult
    {
        $this->cbiDescription = $cbiDescription;

        return $this;
    }

    /**
     * Get numberOfEmployees
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$numberOfEmployees
     */
    public function getNumberOfEmployees(): ?string
    {
        return $this->numberOfEmployees;
    }

    /**
     * Set numberOfEmployees
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $numberOfEmployees
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$numberOfEmployees
     */
    public function setNumberOfEmployees(?string $numberOfEmployees): NationalBusinessCheckResult
    {
        $this->numberOfEmployees = $numberOfEmployees;

        return $this;
    }

    /**
     * Get numberOfAGWP
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$numberOfAGWP
     */
    public function getNumberOfAGWP(): ?string
    {
        return $this->numberOfAGWP;
    }

    /**
     * Set numberOfAGWP
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $numberOfAGWP
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$numberOfAGWP
     */
    public function setNumberOfAGWP(?string $numberOfAGWP): NationalBusinessCheckResult
    {
        $this->numberOfAGWP = $numberOfAGWP;

        return $this;
    }

    /**
     * Get kvkPerson
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$kvkPerson
     */
    public function getKvkPerson(): ?string
    {
        return $this->kvkPerson;
    }

    /**
     * Set kvkPerson
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $kvkPerson
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$kvkPerson
     */
    public function setKvkPerson(?string $kvkPerson): NationalBusinessCheckResult
    {
        $this->kvkPerson = $kvkPerson;

        return $this;
    }

    /**
     * Get functionCd
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$functionCd
     */
    public function getFunctionCd(): ?string
    {
        return $this->functionCd;
    }

    /**
     * Set functionCd
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $functionCd
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$functionCd
     */
    public function setFunctionCd(?string $functionCd): NationalBusinessCheckResult
    {
        $this->functionCd = $functionCd;

        return $this;
    }

    /**
     * Get functionDesc
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$functionDesc
     */
    public function getFunctionDesc(): ?string
    {
        return $this->functionDesc;
    }

    /**
     * Set functionDesc
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $functionDesc
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$functionDesc
     */
    public function setFunctionDesc(?string $functionDesc): NationalBusinessCheckResult
    {
        $this->functionDesc = $functionDesc;

        return $this;
    }

    /**
     * Get initials
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$initials
     */
    public function getInitials(): ?string
    {
        return $this->initials;
    }

    /**
     * Set initials
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $initials
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$initials
     */
    public function setInitials(?string $initials): NationalBusinessCheckResult
    {
        $this->initials = $initials;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$prefix
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * Set prefix
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $prefix
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$prefix
     */
    public function setPrefix(?string $prefix): NationalBusinessCheckResult
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$lastname
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set lastname
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $lastname
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$lastname
     */
    public function setLastname(?string $lastname): NationalBusinessCheckResult
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$gender
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * Set gender
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $gender
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$gender
     */
    public function setGender(?string $gender): NationalBusinessCheckResult
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get dmuPersons
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$dmuPersons
     */
    public function getDmuPersons(): ?string
    {
        return $this->dmuPersons;
    }

    /**
     * Set dmuPersons
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $dmuPersons
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$dmuPersons
     */
    public function setDmuPersons(?string $dmuPersons): NationalBusinessCheckResult
    {
        $this->dmuPersons = $dmuPersons;

        return $this;
    }

    /**
     * Get mhicCompanyName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$mhicCompanyName
     */
    public function getMhicCompanyName(): ?string
    {
        return $this->mhicCompanyName;
    }

    /**
     * Set mhicCompanyName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $mhicCompanyName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$mhicCompanyName
     */
    public function setMhicCompanyName(?string $mhicCompanyName): NationalBusinessCheckResult
    {
        $this->mhicCompanyName = $mhicCompanyName;

        return $this;
    }

    /**
     * Get mhicPostnlKey
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$mhicPostnlKey
     */
    public function getMhicPostnlKey(): ?string
    {
        return $this->mhicPostnlKey;
    }

    /**
     * Set mhicPostnlKey
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $mhicPostnlKey
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$mhicPostnlKey
     */
    public function setMhicPostnlKey(?string $mhicPostnlKey): NationalBusinessCheckResult
    {
        $this->mhicPostnlKey = $mhicPostnlKey;

        return $this;
    }

    /**
     * Get m1CompanyName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$m1CompanyName
     */
    public function getM1CompanyName(): ?string
    {
        return $this->m1CompanyName;
    }

    /**
     * Set m1CompanyName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $m1CompanyName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$m1CompanyName
     */
    public function setM1CompanyName(?string $m1CompanyName): NationalBusinessCheckResult
    {
        $this->m1CompanyName = $m1CompanyName;

        return $this;
    }

    /**
     * Get m1PostnlKey
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$m1PostnlKey
     */
    public function getM1PostnlKey(): ?string
    {
        return $this->m1PostnlKey;
    }

    /**
     * Set m1PostnlKey
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $m1PostnlKey
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$m1PostnlKey
     */
    public function setM1PostnlKey(?string $m1PostnlKey): NationalBusinessCheckResult
    {
        $this->m1PostnlKey = $m1PostnlKey;

        return $this;
    }

    /**
     * Get authorizedPersons
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$authorizedPersons
     */
    public function getAuthorizedPersons(): ?string
    {
        return $this->authorizedPersons;
    }

    /**
     * Set authorizedPersons
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $authorizedPersons
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$authorizedPersons
     */
    public function setAuthorizedPersons(?string $authorizedPersons): NationalBusinessCheckResult
    {
        $this->authorizedPersons = $authorizedPersons;

        return $this;
    }

    /**
     * Get apFunction
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$apFunction
     */
    public function getApFunction(): ?string
    {
        return $this->apFunction;
    }

    /**
     * Set apFunction
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $apFunction
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$apFunction
     */
    public function setApFunction(?string $apFunction): NationalBusinessCheckResult
    {
        $this->apFunction = $apFunction;

        return $this;
    }

    /**
     * Get apType
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$apType
     */
    public function getApType(): ?string
    {
        return $this->apType;
    }

    /**
     * Set apType
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $apType
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$apType
     */
    public function setApType(?string $apType): NationalBusinessCheckResult
    {
        $this->apType = $apType;

        return $this;
    }

    /**
     * Get apInitials
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$apInitials
     */
    public function getApInitials(): ?string
    {
        return $this->apInitials;
    }

    /**
     * Set apInitials
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $apInitials
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$apInitials
     */
    public function setApInitials(?string $apInitials): NationalBusinessCheckResult
    {
        $this->apInitials = $apInitials;

        return $this;
    }

    /**
     * Get apPrefix
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$apPrefix
     */
    public function getApPrefix(): ?string
    {
        return $this->apPrefix;
    }

    /**
     * Set apPrefix
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $apPrefix
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$apPrefix
     */
    public function setApPrefix(?string $apPrefix): NationalBusinessCheckResult
    {
        $this->apPrefix = $apPrefix;

        return $this;
    }

    /**
     * Get apLastName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$apLastName
     */
    public function getApLastName(): ?string
    {
        return $this->apLastName;
    }

    /**
     * Set apLastName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $apLastName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$apLastName
     */
    public function setApLastName(?string $apLastName): NationalBusinessCheckResult
    {
        $this->apLastName = $apLastName;

        return $this;
    }

    /**
     * Get apGender
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$apGender
     */
    public function getApGender(): ?string
    {
        return $this->apGender;
    }

    /**
     * Set apGender
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $apGender
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$apGender
     */
    public function setApGender(?string $apGender): NationalBusinessCheckResult
    {
        $this->apGender = $apGender;

        return $this;
    }

    /**
     * Get authorizedCompanies
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$authorizedCompanies
     */
    public function getAuthorizedCompanies(): ?string
    {
        return $this->authorizedCompanies;
    }

    /**
     * Set authorizedCompanies
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $authorizedCompanies
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$authorizedCompanies
     */
    public function setAuthorizedCompanies(?string $authorizedCompanies): NationalBusinessCheckResult
    {
        $this->authorizedCompanies = $authorizedCompanies;

        return $this;
    }

    /**
     * Get acKvkNumber
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acKvkNumber
     */
    public function getAcKvkNumber(): ?string
    {
        return $this->acKvkNumber;
    }

    /**
     * Set acKvkNumber
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acKvkNumber
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acKvkNumber
     */
    public function setAcKvkNumber(?string $acKvkNumber): NationalBusinessCheckResult
    {
        $this->acKvkNumber = $acKvkNumber;

        return $this;
    }

    /**
     * Get acName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acName
     */
    public function getAcName(): ?string
    {
        return $this->acName;
    }

    /**
     * Set acName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acName
     */
    public function setAcName(?string $acName): NationalBusinessCheckResult
    {
        $this->acName = $acName;

        return $this;
    }

    /**
     * Get acFunction
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acFunction
     */
    public function getAcFunction(): ?string
    {
        return $this->acFunction;
    }

    /**
     * Set acFunction
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acFunction
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acFunction
     */
    public function setAcFunction(?string $acFunction): NationalBusinessCheckResult
    {
        $this->acFunction = $acFunction;

        return $this;
    }

    /**
     * Get acStartDate
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acStartDate
     */
    public function getAcStartDate(): ?string
    {
        return $this->acStartDate;
    }

    /**
     * Set acStartDate
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acStartDate
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acStartDate
     */
    public function setAcStartDate(?string $acStartDate): NationalBusinessCheckResult
    {
        $this->acStartDate = $acStartDate;

        return $this;
    }

    /**
     * Get acPersonFunction
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acPersonFunction
     */
    public function getAcPersonFunction(): ?string
    {
        return $this->acPersonFunction;
    }

    /**
     * Set acPersonFunction
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acPersonFunction
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acPersonFunction
     */
    public function setAcPersonFunction(?string $acPersonFunction): NationalBusinessCheckResult
    {
        $this->acPersonFunction = $acPersonFunction;

        return $this;
    }

    /**
     * Get acPersonType
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acPersonType
     */
    public function getAcPersonType(): ?string
    {
        return $this->acPersonType;
    }

    /**
     * Set acPersonType
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acPersonType
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acPersonType
     */
    public function setAcPersonType(?string $acPersonType): NationalBusinessCheckResult
    {
        $this->acPersonType = $acPersonType;

        return $this;
    }

    /**
     * Get acPersonInitials
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acPersonInitials
     */
    public function getAcPersonInitials(): ?string
    {
        return $this->acPersonInitials;
    }

    /**
     * Set acPersonInitials
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acPersonInitials
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acPersonInitials
     */
    public function setAcPersonInitials(?string $acPersonInitials): NationalBusinessCheckResult
    {
        $this->acPersonInitials = $acPersonInitials;

        return $this;
    }

    /**
     * Get acPersonPrefix
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acPersonPrefix
     */
    public function getAcPersonPrefix(): ?string
    {
        return $this->acPersonPrefix;
    }

    /**
     * Set acPersonPrefix
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acPersonPrefix
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acPersonPrefix
     */
    public function setAcPersonPrefix(?string $acPersonPrefix): NationalBusinessCheckResult
    {
        $this->acPersonPrefix = $acPersonPrefix;

        return $this;
    }

    /**
     * Get acPersonLastName
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acPersonLastName
     */
    public function getAcPersonLastName(): ?string
    {
        return $this->acPersonLastName;
    }

    /**
     * Set acPersonLastName
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acPersonLastName
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acPersonLastName
     */
    public function setAcPersonLastName(?string $acPersonLastName): NationalBusinessCheckResult
    {
        $this->acPersonLastName = $acPersonLastName;

        return $this;
    }

    /**
     * Get acPersonGender
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   NationalBusinessCheckResult::$acPersonGender
     */
    public function getAcPersonGender(): ?string
    {
        return $this->acPersonGender;
    }

    /**
     * Set acPersonGender
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $acPersonGender
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     NationalBusinessCheckResult::$acPersonGender
     */
    public function setAcPersonGender(?string $acPersonGender): NationalBusinessCheckResult
    {
        $this->acPersonGender = $acPersonGender;

        return $this;
    }
}
