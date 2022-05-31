<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutGiftWrap
*/

declare(strict_types=1);

namespace Amasty\CheckoutGiftWrap\Model\Quote;

use Amasty\CheckoutCore\Model\ResourceModel\Fee\CollectionFactory as FeeCollectionFactory;
use Amasty\CheckoutGiftWrap\Model\GiftWrapInformationManagement;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Store\Model\StoreManagerInterface;

class Additional extends AbstractTotal
{
    /**
     * @var float
     */
    protected $feeAmount;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var FeeCollectionFactory
     */
    protected $feeCollectionFactory;
    /**
     * @var GiftWrapInformationManagement
     */
    protected $giftWrapInformationManagement;

    public function __construct(
        FeeCollectionFactory $feeCollectionFactory,
        StoreManagerInterface $storeManager,
        GiftWrapInformationManagement $giftWrapInformationManagement
    ) {
        $this->storeManager = $storeManager;
        $this->feeCollectionFactory = $feeCollectionFactory;
        $this->giftWrapInformationManagement = $giftWrapInformationManagement;
    }

    /**
     * If current currency code of quote is not equal current currency code of store,
     * need recalculate fees of quote. It is possible if customer use currency switcher or
     * store switcher.
     *
     * @param Quote $quote
     */
    protected function checkCurrencyCode(Quote $quote)
    {
        $feeCollection = $this->feeCollectionFactory->create()
            ->addFieldToFilter('quote_id', $quote->getId());

        if ($feeCollection->getSize() == 0) {
            return;
        }

        if ($quote->getQuoteCurrencyCode() !== $this->storeManager->getStore()->getCurrentCurrencyCode()) {
            $this->giftWrapInformationManagement->update($quote->getId(), false);
            $this->giftWrapInformationManagement->update($quote->getId(), true);
        }
    }

    /**
     * @param Quote                       $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total                       $total
     *
     * @return $this
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $total->setTotalAmount($this->getCode(), 0);
        $total->setBaseTotalAmount($this->getCode(), 0);

        if (!count($shippingAssignment->getItems())) {
            return $this;
        }

        $this->checkCurrencyCode($quote);

        $feesQuoteCollection = $this->feeCollectionFactory->create()
            ->addFieldToFilter('quote_id', $quote->getId());

        $feeAmount = 0;
        $baseFeeAmount = 0;

        /** @var \Amasty\CheckoutCore\Model\Fee $fee */
        foreach ($feesQuoteCollection->getItems() as $fee) {
            $feeAmount += $fee->getData('amount');
            $baseFeeAmount += $fee->getData('base_amount');
        }

        if ($feesQuoteCollection->getSize()) {
            $total->setTotalAmount($this->getCode(), $feeAmount);
            $total->setBaseTotalAmount($this->getCode(), $baseFeeAmount);

            $this->feeAmount = $feeAmount;
        }

        return $this;
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param Quote $quote
     * @param Total $total
     *
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(Quote $quote, Total $total)
    {

        $result = [];

        if ($this->feeAmount !== null) {
            $result = [
                'code' => 'amasty_checkout',
                'title' => __('Gift Wrap'),
                'value' => $this->feeAmount
            ];
        }

        return $result;
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Additional');
    }
}
