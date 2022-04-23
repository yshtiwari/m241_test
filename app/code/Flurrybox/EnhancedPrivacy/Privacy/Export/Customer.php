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

namespace Flurrybox\EnhancedPrivacy\Privacy\Export;

use Flurrybox\EnhancedPrivacy\Api\DataExportInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Export customer data.
 */
class Customer implements DataExportInterface
{
    /**
     * Executed upon exporting customer data.
     *
     * Expected return structure:
     *      array(
     *          array('HEADER1', 'HEADER2', 'HEADER3', ...),
     *          array('VALUE1', 'VALUE2', 'VALUE3', ...),
     *          ...
     *      )
     *
     * @param CustomerInterface $customer
     *
     * @return array
     */
    public function export(CustomerInterface $customer)
    {
        $genders = [1 => 'Male', 2 => 'Female', 3 => 'Not Specified'];

        return [
            [
                'PREFIX',
                'FIRST NAME',
                'MIDDLE NAME',
                'LAST NAME',
                'SUFFIX',
                'CREATED AT',
                'UPDATED AT',
                'EMAIL',
                'DATE OF BIRTH',
                'TAX VAT',
                'GENDER'
            ],
            [
                $customer->getPrefix(),
                $customer->getFirstname(),
                $customer->getMiddlename(),
                $customer->getLastname(),
                $customer->getSuffix(),
                $customer->getCreatedAt(),
                $customer->getUpdatedAt(),
                $customer->getEmail(),
                $customer->getDob(),
                $customer->getTaxvat(),
                $genders[($customer->getGender() ?: 3)] ?? 'Not Specified'
            ]
        ];
    }
}
