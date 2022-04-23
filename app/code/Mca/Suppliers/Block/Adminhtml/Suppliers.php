<?php

namespace Mca\Suppliers\Block\Adminhtml;

/**
 * Adminhtml contact content block
 */
class Suppliers extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'Suppliers';
        $this->_headerText = __('Suppliers');
        $this->_addButtonLabel = __('Add New Suppliers');
        parent::_construct();
    }
}
