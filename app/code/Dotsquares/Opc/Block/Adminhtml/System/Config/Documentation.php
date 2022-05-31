<?php

namespace Dotsquares\Opc\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

class Documentation extends Field
{
     protected $_storeManager;
      public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    )
    {        
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }

public $userGuideUrl = "https://www.dotsquares.com/";



    protected function _getElementHtml(AbstractElement $element)
    {
    $userguide = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
    $userguide = $userguide."pub/Onestep.doc";
    
        $element->getValue();
        return sprintf(
            '<span>
                        <a href="%s" target="_blank">%s</a>
                    </span>',
            $userguide,
            __('User Guide')
        );
    }
}
