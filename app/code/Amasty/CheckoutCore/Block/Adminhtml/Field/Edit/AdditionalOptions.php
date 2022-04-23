<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/


namespace Amasty\CheckoutCore\Block\Adminhtml\Field\Edit;

use Amasty\CheckoutCore\Block\Adminhtml\Renderer\Template;
use Magento\Backend\Block\Template\Context;
use Amasty\CheckoutCore\Model\ModuleEnable;

class AdditionalOptions extends Template
{
    /**
     * @var ModuleEnable
     */
    private $moduleEnable;

    public function __construct(
        Context $context,
        ModuleEnable $moduleEnable,
        array $data = []
    ) {
        $this->moduleEnable = $moduleEnable;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isOrderAttributesEnable()
    {
        return $this->moduleEnable->isOrderAttributesEnable();
    }

    /**
     * @return bool
     */
    public function isCustomerAttributesEnable()
    {
        return $this->moduleEnable->isCustomerAttributesEnable();
    }
}
