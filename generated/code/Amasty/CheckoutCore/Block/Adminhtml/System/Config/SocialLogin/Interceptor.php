<?php
namespace Amasty\CheckoutCore\Block\Adminhtml\System\Config\SocialLogin;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Block\Adminhtml\System\Config\SocialLogin
 */
class Interceptor extends \Amasty\CheckoutCore\Block\Adminhtml\System\Config\SocialLogin implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Amasty\CheckoutCore\Model\ModuleEnable $moduleEnable, \Amasty\CheckoutCore\Model\Config\SocialLogin\CheckoutPositionValue $checkoutPositionValue, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $moduleEnable, $checkoutPositionValue, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element) : string
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        return $pluginInfo ? $this->___callPlugins('render', func_get_args(), $pluginInfo) : parent::render($element);
    }
}
