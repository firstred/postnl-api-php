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

/**
 * Class CreditWorthiness
 */
class CreditWorthiness extends AbstractEntity
{
    /**
     * Main message
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $mainMessage
     *
     * @since   2.0.0
     */
    protected $mainMessage;

    /**
     * Additional message
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $additionalMessage
     *
     * @since   2.0.0
     */
    protected $additionalMessage;

    /**
     * Company identification
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $companyIdentification
     *
     * @since   2.0.0
     */
    protected $companyIdentification;

    /**
     * Credit flag
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $creditFlag
     *
     * @since   2.0.0
     */
    protected $creditFlag;

    /**
     * Credit advice
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $creditAdvice
     *
     * @since   2.0.0
     */
    protected $creditAdvice;

    /**
     * Financial calamity status
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $financialCalamityStatus
     *
     * @since   2.0.0
     */
    protected $financialCalamityStatus;

    /**
     * Discontinuance type
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $discontinuanceType
     *
     * @since   2.0.0
     */
    protected $discontinuanceType;

    /**
     * Discontinuance reason
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var string|null $discontinuanceReason
     *
     * @since   2.0.0
     */
    protected $discontinuanceReason;

    /**
     * CreditWorthiness constructor.
     *
     * @param string|null $mainMessage
     * @param string|null $additionalMessage
     * @param string|null $companyIdentification
     * @param string|null $creditFlag
     * @param string|null $creditAdvice
     * @param string|null $financialCalamityStatus
     * @param string|null $discontinuanceType
     * @param string|null $discontinuanceReason
     *
     * @since 2.0.0
     */
    public function __construct(?string $mainMessage = null, ?string $additionalMessage = null, ?string $companyIdentification = null, ?string $creditFlag = null, ?string $creditAdvice = null, ?string $financialCalamityStatus = null, ?string $discontinuanceType = null, ?string $discontinuanceReason = null)
    {
        parent::__construct();

        $this->setMainMessage($mainMessage);
        $this->setAdditionalMessage($additionalMessage);
        $this->setCompanyIdentification($companyIdentification);
        $this->setCreditFlag($creditFlag);
        $this->setCreditAdvice($creditAdvice);
        $this->setFinancialCalamityStatus($financialCalamityStatus);
        $this->setDiscontinuanceType($discontinuanceType);
        $this->setDiscontinuanceReason($discontinuanceReason);
    }

    /**
     * Get mainMessage
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CreditWorthiness::$mainMessage
     */
    public function getMainMessage(): ?string
    {
        return $this->mainMessage;
    }

    /**
     * Set mainMessage
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $mainMessage
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     CreditWorthiness::$mainMessage
     */
    public function setMainMessage(?string $mainMessage): CreditWorthiness
    {
        $this->mainMessage = $mainMessage;

        return $this;
    }

    /**
     * Get additionalMessage
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CreditWorthiness::$additionalMessage
     */
    public function getAdditionalMessage(): ?string
    {
        return $this->additionalMessage;
    }

    /**
     * Set additionalMessage
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $additionalMessage
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     CreditWorthiness::$additionalMessage
     */
    public function setAdditionalMessage(?string $additionalMessage): CreditWorthiness
    {
        $this->additionalMessage = $additionalMessage;

        return $this;
    }

    /**
     * Get companyIdentification
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CreditWorthiness::$companyIdentification
     */
    public function getCompanyIdentification(): ?string
    {
        return $this->companyIdentification;
    }

    /**
     * Set companyIdentification
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $companyIdentification
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     CreditWorthiness::$companyIdentification
     */
    public function setCompanyIdentification(?string $companyIdentification): CreditWorthiness
    {
        $this->companyIdentification = $companyIdentification;

        return $this;
    }

    /**
     * Get creditFlag
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CreditWorthiness::$creditFlag
     */
    public function getCreditFlag(): ?string
    {
        return $this->creditFlag;
    }

    /**
     * Set creditFlag
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $creditFlag
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     CreditWorthiness::$creditFlag
     */
    public function setCreditFlag(?string $creditFlag): CreditWorthiness
    {
        $this->creditFlag = $creditFlag;

        return $this;
    }

    /**
     * Get creditAdvice
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CreditWorthiness::$creditAdvice
     */
    public function getCreditAdvice(): ?string
    {
        return $this->creditAdvice;
    }

    /**
     * Set creditAdvice
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $creditAdvice
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     CreditWorthiness::$creditAdvice
     */
    public function setCreditAdvice(?string $creditAdvice): CreditWorthiness
    {
        $this->creditAdvice = $creditAdvice;

        return $this;
    }

    /**
     * Get financialCalamityStatus
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CreditWorthiness::$financialCalamityStatus
     */
    public function getFinancialCalamityStatus(): ?string
    {
        return $this->financialCalamityStatus;
    }

    /**
     * Set financialCalamityStatus
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $financialCalamityStatus
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     CreditWorthiness::$financialCalamityStatus
     */
    public function setFinancialCalamityStatus(?string $financialCalamityStatus): CreditWorthiness
    {
        $this->financialCalamityStatus = $financialCalamityStatus;

        return $this;
    }

    /**
     * Get discontinuanceType
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CreditWorthiness::$discontinuanceType
     */
    public function getDiscontinuanceType(): ?string
    {
        return $this->discontinuanceType;
    }

    /**
     * Set discontinuanceType
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $discontinuanceType
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     CreditWorthiness::$discontinuanceType
     */
    public function setDiscontinuanceType(?string $discontinuanceType): CreditWorthiness
    {
        $this->discontinuanceType = $discontinuanceType;

        return $this;
    }

    /**
     * Get discontinuanceReason
     *
     * @return string|null
     *
     * @since 2.0.0
     *
     * @see   CreditWorthiness::$discontinuanceReason
     */
    public function getDiscontinuanceReason(): ?string
    {
        return $this->discontinuanceReason;
    }

    /**
     * Set discontinuanceReason
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @param string|null $discontinuanceReason
     *
     * @return static
     *
     * @since   2.0.0
     *
     * @see     CreditWorthiness::$discontinuanceReason
     */
    public function setDiscontinuanceReason(?string $discontinuanceReason): CreditWorthiness
    {
        $this->discontinuanceReason = $discontinuanceReason;

        return $this;
    }
}
