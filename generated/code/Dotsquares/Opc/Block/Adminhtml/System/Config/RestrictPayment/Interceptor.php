<?php
namespace Dotsquares\Opc\Block\Adminhtml\System\Config\RestrictPayment;

/**
 * Interceptor class for @see \Dotsquares\Opc\Block\Adminhtml\System\Config\RestrictPayment
 */
class Interceptor extends \Dotsquares\Opc\Block\Adminhtml\System\Config\RestrictPayment implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroupCollection, \Magento\Payment\Helper\Data $paymentHelper, \Magento\Framework\Json\Helper\Data $jsonHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $customerGroupCollection, $paymentHelper, $jsonHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        return $pluginInfo ? $this->___callPlugins('render', func_get_args(), $pluginInfo) : parent::render($element);
    }
}
