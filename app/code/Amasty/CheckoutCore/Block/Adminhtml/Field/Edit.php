<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/


namespace Amasty\CheckoutCore\Block\Adminhtml\Field;

use Magento\Backend\Block\Widget\Form\Container as FormContainer;

class Edit extends FormContainer
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_field';
        $this->_blockGroup = 'Amasty_CheckoutCore';

        parent::_construct();

        $this->buttonList->remove('reset');
    }
}
