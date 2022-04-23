<?php
namespace Dotsquares\Shipping\Block\Adminhtml\System\Exportcsv;

/**
 * Interceptor class for @see \Dotsquares\Shipping\Block\Adminhtml\System\Exportcsv
 */
class Interceptor extends \Dotsquares\Shipping\Block\Adminhtml\System\Exportcsv implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Backend\Model\UrlInterface $backendUrl, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $backendUrl, $data);
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
