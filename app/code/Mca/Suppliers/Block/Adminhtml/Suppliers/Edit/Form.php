<?php

namespace Mca\Suppliers\Block\Adminhtml\Suppliers\Edit;

/**
 * Adminhtml attachment edit form block
 *
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Prepare form
     *
     * @return $this
     */
	protected function _construct()
    {
        parent::_construct();
        $this->setId('mca_suppliers_form');
        $this->setTitle(__('Suppliers'));
    }
	
    protected function _prepareForm()
    {
	    /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => 
				[
					'id' => 'edit_form',
					'action' => $this->getUrl('suppliers/index/save'),
					'method' => 'post',
					'enctype' => 'multipart/form-data',
				]
			]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}