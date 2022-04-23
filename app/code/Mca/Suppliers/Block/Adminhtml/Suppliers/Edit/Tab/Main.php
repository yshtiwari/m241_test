<?php

namespace Mca\Suppliers\Block\Adminhtml\Suppliers\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;


class Main extends Generic implements TabInterface
{
    protected function _prepareForm()
    {
	    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	    $suppliersname = $objectManager->create('Mca\Suppliers\Model\Suppliersname');
	    $status = $objectManager->create('Mca\Suppliers\Model\Status');
	    $model = $this->_coreRegistry->registry('mca_supplier');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('suppliers_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Suppliers')]);
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        $fieldset->addField(
            'suppliers_name',
            'select',
            [
                'label' => __('Suppliers Name'),
                'title' => __('Suppliers Name'),
                'name' => 'suppliers_name',
                'required' => true,
				'values' => $suppliersname->getOptionArray()
            ]
        );
		
		$fieldset->addField(
            'suppliers_email',
            'text',
            ['name' => 'suppliers_email', 'label' => __('Suppliers Email'), 'title' => __('Suppliers Email'), 'class'=> 'validate-email','required' => true]
        );
		
		
		$fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
				'values' => $status->getOptionArray()
            ]
        );
		
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
	
    public function getTabLabel()
    {
        return __('Suppliers');
    }

    
    public function getTabTitle()
    {
        return __('Suppliers');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

}
