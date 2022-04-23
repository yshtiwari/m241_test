<?php
namespace Magento\Multishipping\Block\Checkout\Billing\Items;

/**
 * Interceptor class for @see \Magento\Multishipping\Block\Checkout\Billing\Items
 */
class Interceptor extends \Magento\Multishipping\Block\Checkout\Billing\Items implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Multishipping\Model\Checkout\Type\Multishipping $multishipping, \Magento\Checkout\Model\Session $checkoutSession, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $multishipping, $checkoutSession, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        return $pluginInfo ? $this->___callPlugins('toHtml', func_get_args(), $pluginInfo) : parent::toHtml();
    }
}
