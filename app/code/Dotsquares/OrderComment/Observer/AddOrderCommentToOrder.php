<?php
/**
 * Copyright © Dotsquares. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Dotsquares\OrderComment\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Dotsquares\OrderComment\Model\Data\OrderComment;

class AddOrderCommentToOrder implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        /** @var $order \Magento\Sales\Model\Order **/

        $quote = $observer->getEvent()->getQuote();
        /** @var $quote \Magento\Quote\Model\Quote **/

        $order->setData(
            OrderComment::COMMENT_FIELD_NAME,
            $quote->getData(OrderComment::COMMENT_FIELD_NAME)
        );
    }
}
