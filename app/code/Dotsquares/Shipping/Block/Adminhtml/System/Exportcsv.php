<?php
namespace Dotsquares\Shipping\Block\Adminhtml\System;

class Exportcsv extends \Magento\Config\Block\System\Config\Form\Field
{
	protected $backendUrl;
    protected $_template = 'Dotsquares_Shipping::system/config/Export.phtml';
	
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->backendUrl = $backendUrl;
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
    
	protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }

    public function getCustomExportButton()
    {
		$exportBlock = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button');
        $params = ['website' => $exportBlock->getRequest()->getParam('website')];
        $url = $this->backendUrl->getUrl("dotshipping/system/exportcsv", $params);
        $data = [
            'label' => __('Export CSV'),
            'onclick' => "setLocation('" .
            $url .
            "conditiontype/' + $('carriers_dotsquares_condition_type').value)",
            'class' => '',
        ];
        $html = $exportBlock->setData($data)->toHtml();
        return $html;
    }
}