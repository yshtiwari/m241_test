<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/


namespace Amasty\CheckoutCore\Block\Adminhtml\Field\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('amasty_checkout_fields_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('CHECKOUT FIELDS CONFIGURATION'));
    }
}
