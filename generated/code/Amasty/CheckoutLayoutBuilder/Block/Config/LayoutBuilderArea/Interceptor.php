<?php
namespace Amasty\CheckoutLayoutBuilder\Block\Config\LayoutBuilderArea;

/**
 * Interceptor class for @see \Amasty\CheckoutLayoutBuilder\Block\Config\LayoutBuilderArea
 */
class Interceptor extends \Amasty\CheckoutLayoutBuilder\Block\Config\LayoutBuilderArea implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Amasty\CheckoutLayoutBuilder\Model\Config\CheckoutBlocksProvider $checkoutBlocksProvider, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $checkoutBlocksProvider, $scopeConfig, $data);
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
