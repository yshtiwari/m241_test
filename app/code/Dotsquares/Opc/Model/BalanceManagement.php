<?php

namespace Dotsquares\Opc\Model;

use Dotsquares\Opc\Api\BalanceManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;

class BalanceManagement implements BalanceManagementInterface
{
    /**
     * @var CartRepositoryInterface
     */
    public $cartRepository;

    /**
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository
    ) {
        $this->cartRepository = $cartRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($cartId)
    {
        /** @var \Magento\Quote\Api\Data\CartInterface $quote */
        $quote = $this->cartRepository->get($cartId);
        $quote->setUseCustomerBalance(false);
        $quote->setDotsquaresUseCustomerBalance(false);
        $quote->collectTotals();
        $quote->save();
        return true;
    }
}
