<?php
/**
 * Copyright © Dotsquares. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Dotsquares\OrderComment\Model;

use Dotsquares\OrderComment\Api\GuestOrderCommentManagementInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Dotsquares\OrderComment\Api\OrderCommentManagementInterface;
use Dotsquares\OrderComment\Api\Data\OrderCommentInterface;

class GuestOrderCommentManagement implements GuestOrderCommentManagementInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var OrderCommentManagementInterface
     */
    protected $orderCommentManagement;
    
    /**
     * GuestOrderCommentManagement constructor.
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param OrderCommentManagementInterface $orderCommentManagement
     */
    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        OrderCommentManagementInterface $orderCommentManagement
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->orderCommentManagement = $orderCommentManagement;
    }

    /**
     * {@inheritDoc}
     */
    public function saveOrderComment(
        $cartId,
        OrderCommentInterface $orderComment
    ) {
        $quoteIdMask = $this->quoteIdMaskFactory->create()
            ->load($cartId, 'masked_id');
                            
        return $this->orderCommentManagement->saveOrderComment(
            $quoteIdMask->getQuoteId(),
            $orderComment
        );
    }
}
