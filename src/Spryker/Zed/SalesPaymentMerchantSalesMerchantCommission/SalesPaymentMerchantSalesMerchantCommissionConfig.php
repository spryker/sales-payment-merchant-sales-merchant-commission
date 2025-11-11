<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesPaymentMerchantSalesMerchantCommission;

use Generated\Shared\Transfer\ItemTransfer;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class SalesPaymentMerchantSalesMerchantCommissionConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @uses \Spryker\Shared\Price\PriceConfig::PRICE_MODE_NET
     *
     * @var string
     */
    public const PRICE_MODE_NET = 'NET_MODE';

    /**
     * @api
     *
     * @uses \Spryker\Shared\Price\PriceConfig::PRICE_MODE_GROSS
     *
     * @var string
     */
    public const PRICE_MODE_GROSS = 'GROSS_MODE';

    /**
     * @var string|null
     */
    protected const BASE_AMOUNT_FIELD_GROSS_MODE = null;

    /**
     * @var string|null
     */
    protected const BASE_AMOUNT_FIELD_NET_MODE = null;

    /**
     * @var string|null
     */
    protected const BASE_AMOUNT_FIELD_FOR_REVERSE_PAYOUT = null;

    /**
     * @var array<string, array<string, bool>>
     */
    protected const TAX_DEDUCTION_ENABLED_FOR_STORE_AND_PRICE_MODE = [];

    /**
     * Specification:
     * - Determines if tax deduction is enabled for the given store and price mode.
     * - Applies on payout and payout reverse amount calculations.
     * - If true, taxes are deducted from the base amount before payout and payout reverse amount calculations.
     *
     * @api
     *
     * @param string $storeName
     * @param string $priceMode
     *
     * @return bool
     */
    public function isTaxDeductionEnabledForStoreAndPriceMode(string $storeName, string $priceMode): bool
    {
        return static::TAX_DEDUCTION_ENABLED_FOR_STORE_AND_PRICE_MODE[$storeName][$priceMode] ?? false;
    }

    /**
     * Specification:
     * - Returns the field name to be used for base amount calculation in GROSS mode.
     * - Utilizes `ItemTransfer::SUM_PRICE_TO_PAY_AGGREGATION` for the default configuration.
     *
     * @api
     *
     * @return string
     */
    public function getBaseAmountFieldForGrossMode(): string
    {
        if (static::BASE_AMOUNT_FIELD_GROSS_MODE) {
            return static::BASE_AMOUNT_FIELD_GROSS_MODE;
        }

        return ItemTransfer::SUM_PRICE_TO_PAY_AGGREGATION;
    }

    /**
     * Specification:
     * - Returns the field name to be used for base amount calculation in NET mode.
     * - Utilizes `ItemTransfer::SUM_PRICE_TO_PAY_AGGREGATION` for the default configuration.
     *
     * @api
     *
     * @return string
     */
    public function getBaseAmountFieldForNetMode(): string
    {
        if (static::BASE_AMOUNT_FIELD_NET_MODE) {
            return static::BASE_AMOUNT_FIELD_NET_MODE;
        }

        return ItemTransfer::SUM_PRICE_TO_PAY_AGGREGATION;
    }

    /**
     * Specification:
     * - Returns the field name to be used for base amount calculation in reverse payout process.
     * - Utilizes `ItemTransfer::CANCELED_AMOUNT` for the default configuration.
     *
     * @api
     *
     * @return string
     */
    public function getBaseAmountFieldForReversePayout(): string
    {
        if (static::BASE_AMOUNT_FIELD_FOR_REVERSE_PAYOUT) {
            return static::BASE_AMOUNT_FIELD_FOR_REVERSE_PAYOUT;
        }

        return ItemTransfer::CANCELED_AMOUNT;
    }
}
