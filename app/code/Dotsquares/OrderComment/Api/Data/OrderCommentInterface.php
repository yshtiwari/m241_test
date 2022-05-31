<?php
/**
 * Copyright © Dotsquares. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Dotsquares\OrderComment\Api\Data;

/**
 * Interface OrderCommentInterface
 * @api
 */
interface OrderCommentInterface
{
    /**
     * @return string|null
     */
    public function getComment();

    /**
     * @param string $comment
     * @return null
     */
    public function setComment($comment);
}
