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

namespace Flurrybox\EnhancedPrivacy\Api;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Data deletion and anonymization interface.
 *
 * @api
 * @since 1.0.0
 */
interface DataDeleteInterface
{
    /**
     * Executed upon customer data deletion.
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     *
     * @return void
     */
    public function delete(CustomerInterface $customer);

    /**
     * Executed upon customer data anonymization.
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     *
     * @return void
     */
    public function anonymize(CustomerInterface $customer);
}
