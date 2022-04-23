<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/


namespace Amasty\CheckoutCore\Plugin\Framework\View\Asset;

class ConfigInterfacePlugin
{
    /**
     * @var \Amasty\CheckoutCore\Model\Optimization\BundleService
     */
    private $bundleService;

    public function __construct(\Amasty\CheckoutCore\Model\Optimization\BundleService $bundleService)
    {
        $this->bundleService = $bundleService;
    }

    /**
     * Force enable bundling for checkout
     *
     * @param \Magento\Framework\View\Asset\ConfigInterface $subject
     * @param bool $result
     *
     * @return bool
     */
    public function afterIsBundlingJsFiles(\Magento\Framework\View\Asset\ConfigInterface $subject, $result)
    {
        if (!$result && $this->bundleService->canLoadBundle()) {
            return true;
        }

        return $result;
    }
}
