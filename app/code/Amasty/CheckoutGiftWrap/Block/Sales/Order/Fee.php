<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutGiftWrap
*/

declare(strict_types=1);

namespace Amasty\CheckoutGiftWrap\Block\Sales\Order;

use Amasty\CheckoutCore\Model\ResourceModel\Fee\CollectionFactory as FeeCollectionFactory;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\OrderInterface;

class Fee extends AbstractBlock
{
    /**
     * @var FeeCollectionFactory
     */
    private $feeCollectionFactory;

    public function __construct(
        Context $context,
        FeeCollectionFactory $feeCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->feeCollectionFactory = $feeCollectionFactory;
    }

    /**
     * Create the Gift Wrap totals summary
     *
     * @return $this
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();

        if (!$parent || !method_exists($parent, 'getOrder')) {
            return $this;
        }

        /** @var \Magento\Sales\Model\Order $order */
        $order = $parent->getOrder();

        if (!($order instanceof OrderInterface)) {
            return $this;
        }

        $quoteId = $order->getQuoteId();

        $feesQuoteCollection = $this->feeCollectionFactory->create()
            ->addFieldToFilter('quote_id', $quoteId);

        $feeAmount = 0;
        $baseFeeAmount = 0;

        /** @var \Amasty\CheckoutCore\Model\Fee $fee */
        foreach ($feesQuoteCollection->getItems() as $fee) {
            $feeAmount += $fee->getData('amount');
            $baseFeeAmount += $fee->getData('base_amount');
        }

        if ($feesQuoteCollection->getSize()) {
            $total = new \Magento\Framework\DataObject(
                [
                    'code' => $this->getNameInLayout(),
                    'label' => __('Gift Wrap'),
                    'value' => +$feeAmount,
                    'base_value' => +$baseFeeAmount
                ]
            );

            $parent->addTotalBefore($total, 'grand_total');
        }

        return $this;
    }
}
