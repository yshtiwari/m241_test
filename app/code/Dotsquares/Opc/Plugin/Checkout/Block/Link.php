<?php

namespace Dotsquares\Opc\Plugin\Checkout\Block;

use Dotsquares\Opc\Helper\Data as OpcHelper;
use Magento\Framework\UrlInterface;

class Link
{
    public $opcHelper;
    public $url;

    public function __construct(
        OpcHelper $opcHelper,
        UrlInterface $url
    ) {
        $this->opcHelper = $opcHelper;
        $this->url = $url;
    }

    public function afterGetHref($subject, $result)
    {
        if ($this->opcHelper->isEnable() && $this->opcHelper->isCheckoutDesign()
            && !($this->opcHelper->isGaAbEnable() && $this->opcHelper->getGaAbCode())) {
            $result = $this->url->getUrl('onepage', ['_secure' => true]);
        }

        return $result;
    }
}
