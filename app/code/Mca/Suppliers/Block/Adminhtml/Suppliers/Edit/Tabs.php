<?php

namespace Mca\Suppliers\Block\Adminhtml\Suppliers\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
	    parent::_construct();
        $this->setId('mca_suppliers_suppliers_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Suppliers Information'));
    }
}
