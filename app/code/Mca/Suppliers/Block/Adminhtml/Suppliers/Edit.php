<?php namespace Mca\Suppliers\Block\Adminhtml\Suppliers;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry = null;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Mca_Suppliers';
        $this->_controller = 'adminhtml_suppliers';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Suppliers'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        );

        $this->buttonList->update('delete', 'label', __('Delete Suppliers'));
    }

    public function getHeaderText()
    {
        $item = $this->_coreRegistry->registry('mca_supplier');
        if ($item->getId()) {
            return __("Edit Suppliers '%1'", $this->escapeHtml($item->getSupplierName()));
        } else {
            return __('New Suppliers');
        }
    }
}