<?php
namespace Magento\PageBuilder\Block\Adminhtml\System\Config\SwitchAttributeType;

/**
 * Interceptor class for @see \Magento\PageBuilder\Block\Adminhtml\System\Config\SwitchAttributeType
 */
class Interceptor extends \Magento\PageBuilder\Block\Adminhtml\System\Config\SwitchAttributeType implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $data);
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
