<?php

namespace Dotsquares\Opc\Plugin\Payments\Paypal;

use \Magento\Paypal\Model\AbstractConfig as PaypalConfig;

/**
 * Class Config
 * @package Dotsquares\Opc\Model\Payments\Paypal
 */
class Config
{
    /**
     * @param PaypalConfig $subject
     * @param $result
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @return string
     */
    public function afterGetBuildNotationCode(PaypalConfig $subject, $result)
    {
        return 'Dotsquares_SP_PCP';
    }
}
