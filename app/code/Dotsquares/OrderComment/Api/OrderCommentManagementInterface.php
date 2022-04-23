<?php
/**
 * Copyright © Dotsquares. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Dotsquares\OrderComment\Api;

use Dotsquares\OrderComment\Api\Data\OrderCommentInterface;

/**
 * Interface for saving the checkout order comment
 * to the quote for logged in users
 * @api
 */
interface OrderCommentManagementInterface
{
    /**
     * @param int $cartId
     * @param OrderCommentInterface $orderComment
     * @return string
     */
    public function saveOrderComment(
        $cartId,
        OrderCommentInterface $orderComment
    );
}
