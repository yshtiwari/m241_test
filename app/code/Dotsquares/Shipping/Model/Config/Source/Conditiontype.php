<?php

namespace Dotsquares\Shipping\Model\Config\Source;

use Magento\Framework\Exception\LocalizedException;

class Conditiontype implements \Magento\Framework\Option\ArrayInterface
{
    public function getCode($type, $code = '')
    {
		$codes = [
            'condition_name' => [
                'package_weight' => __('Weight vs Destination'),
                'package_value' => __('Order Subtotal vs Destination'),
                'package_qty' => __('# of Items vs Destination'),
            ],
            'condition_name_short' => [
                'package_weight' => __('Weight'),
                'package_value' => __('Order Subtotal'),
                'package_qty' => __('# of Items'),
            ],
        ];
		
		if (!isset($codes[$type])) {
            throw new LocalizedException(__('Please correct Shipping Rate code type: %1.', $type));
        }

        if ('' === $code) {
            return $codes[$type];
        }

        if (!isset($codes[$type][$code])) {
            throw new LocalizedException(__('Please correct Shipping Rate code for type %1: %2.', $type, $code));
        }

        return $codes[$type][$code];
    }
	
    public function toOptionArray()
    {
        $arr = [];
        foreach ($this->getCode('condition_name') as $k => $v) {
            $arr[] = ['value' => $k, 'label' => $v];
        }
        return $arr;
    }
}
