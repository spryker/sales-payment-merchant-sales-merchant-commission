<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesPaymentMerchantSalesMerchantCommission\Business\Calculator;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class PayoutReverseAmountModeCalculator extends AbstractPayoutAmountCalculator
{
    public function calculatePayoutAmount(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer): int
    {
        $payoutReverseAmount = $this->getBaseReverseAmount($itemTransfer);
        $payoutReverseAmount = $this->applyReverseCommission($itemTransfer, $payoutReverseAmount);
        $payoutReverseAmount = $this->applyReverseTaxDeduction($itemTransfer, $orderTransfer, $payoutReverseAmount);

        return $payoutReverseAmount;
    }

    public function isApplicable(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer): bool
    {
        return true;
    }
}
