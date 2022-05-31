<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/

declare(strict_types=1);

namespace Amasty\CheckoutCore\Plugin\Gdpr\Model\Consent\DataProvider;

use Magento\Framework\View\LayoutInterface;

class SkipCountryRestriction
{
    public const OSC_HANDLE = 'amasty_checkout';

    /**
     * @var LayoutInterface
     */
    private $layout;

    public function __construct(
        LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    /**
     * Skip consent restriction by country during checkout page loading
     *
     * @param $subject
     * @param bool $result
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function afterIsNeedShowConsentByCountry($subject, bool $result): bool
    {
        $handles = $this->layout->getUpdate()->getHandles();

        return in_array(self::OSC_HANDLE, $handles, true)
            ? true
            : $result;
    }
}
