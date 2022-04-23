<?php

namespace Ewave\ExtendedBundleProduct\Observer\Adminhtml;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class BundleProductMultipleTypeSaveAfter
 * @package Ewave\ExtendedBundleProduct\Observer\Adminhtml
 */
class BundleProductMultipleTypeSaveAfter implements ObserverInterface
{
    /**
     * Type of option
     */
    const MULTI_TYPE = 'multi';

    /**
     * @param Observer $observer
     * @throws LocalizedException
     * @return void
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();
        if ($product->getTypeId() != \Magento\Bundle\Model\Product\Type::TYPE_CODE) {
            return;
        }

        $multyOptions = [];
        $bundleOptions = $product->getBundleOptionsData();
        if (is_array($bundleOptions)) {
            foreach ($bundleOptions as $bundleOption) {
                if (isset($bundleOption['type']) && $bundleOption['type'] == self::MULTI_TYPE) {
                    $multyOptions[] = $bundleOption['option_id'];
                }
            }
        }

        $bundleSelections = $product->getBundleSelectionsData();
        if (is_array($bundleSelections)) {
            foreach ($bundleSelections as $optionSelections) {
                foreach ($optionSelections as $optionSelection) {
                    if (in_array($optionSelection['option_id'], $multyOptions)
                        && !empty($optionSelection['configurable_options-prepared-for-send'])
                    ) {
                        throw new LocalizedException(
                            __('Error: Configurable products cannot be used as part of multiselect option')
                        );
                    }
                }
            }
        }
    }
}
