<?php
/**
 * This file is part of the Flurrybox EnhancedPrivacy package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Flurrybox EnhancedPrivacy
 * to newer versions in the future.
 *
 * @copyright Copyright (c) 2018 Flurrybox, Ltd. (https://flurrybox.com/)
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Flurrybox\EnhancedPrivacy\Model\ResourceModel;

use Flurrybox\EnhancedPrivacy\Api\Data\ReasonInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Deletion or anonymization reason resource model.
 */
class Reason extends AbstractDb
{
    /**
     * Resource initialization.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ReasonInterface::TABLE, ReasonInterface::ID);
    }
}
