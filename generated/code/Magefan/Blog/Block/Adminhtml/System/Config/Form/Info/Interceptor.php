<?php
namespace Magefan\Blog\Block\Adminhtml\System\Config\Form\Info;

/**
 * Interceptor class for @see \Magefan\Blog\Block\Adminhtml\System\Config\Form\Info
 */
class Interceptor extends \Magefan\Blog\Block\Adminhtml\System\Config\Form\Info implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Module\ModuleListInterface $moduleList, \Magento\Backend\Block\Template\Context $context, array $data = [], ?\Magefan\Community\Api\GetModuleVersionInterface $getModuleVersion = null)
    {
        $this->___init();
        parent::__construct($moduleList, $context, $data, $getModuleVersion);
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
