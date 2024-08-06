<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesPaymentMerchantSalesMerchantCommission\Business\Calculator;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\SalesPaymentMerchantSalesMerchantCommission\Business\Exception\BaseAmountFieldNotSetException;

class PayoutAmountGrossModeCalculator extends AbstractPayoutAmountCalculator
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return int
     */
    public function calculatePayoutAmount(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer): int
    {
        $payoutAmount = $this->getBaseAmount($itemTransfer);
        $payoutAmount = $this->applyCommission($itemTransfer, $payoutAmount);
        $payoutAmount = $this->applyTaxDeduction($itemTransfer, $orderTransfer, $payoutAmount);

        return $payoutAmount;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @throws \Spryker\Zed\SalesPaymentMerchantSalesMerchantCommission\Business\Exception\BaseAmountFieldNotSetException
     *
     * @return int
     */
    protected function getBaseAmount(ItemTransfer $itemTransfer): int
    {
        if (!$itemTransfer->offsetExists($this->config->getBaseAmountFieldForGrossMode())) {
            throw new BaseAmountFieldNotSetException('Base amount field for GROSS mode is not set');
        }

        return $itemTransfer->offsetGet($this->config->getBaseAmountFieldForGrossMode());
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isApplicable(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer): bool
    {
        return $this->getPriceMode($orderTransfer) === $this->config::PRICE_MODE_GROSS;
    }
}
