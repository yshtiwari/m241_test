<?php
namespace Dotsquares\Opc\Block\Adminhtml\System\Config\Version;

/**
 * Interceptor class for @see \Dotsquares\Opc\Block\Adminhtml\System\Config\Version
 */
class Interceptor extends \Dotsquares\Opc\Block\Adminhtml\System\Config\Version implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Component\ComponentRegistrar $componentRegistrar, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $componentRegistrar, $data);
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
