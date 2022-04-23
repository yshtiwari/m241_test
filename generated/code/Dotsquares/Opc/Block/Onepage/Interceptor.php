<?php
namespace Dotsquares\Opc\Block\Onepage;

/**
 * Interceptor class for @see \Dotsquares\Opc\Block\Onepage
 */
class Interceptor extends \Dotsquares\Opc\Block\Onepage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Data\Form\FormKey $formKey, \Magento\Checkout\Model\CompositeConfigProvider $configProvider, \Magento\Checkout\Model\Session\Proxy $checkoutSession, array $layoutProcessors = [], array $data = [])
    {
        $this->___init();
        parent::__construct($context, $formKey, $configProvider, $checkoutSession, $layoutProcessors, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getJsLayout()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getJsLayout');
        return $pluginInfo ? $this->___callPlugins('getJsLayout', func_get_args(), $pluginInfo) : parent::getJsLayout();
    }
}
