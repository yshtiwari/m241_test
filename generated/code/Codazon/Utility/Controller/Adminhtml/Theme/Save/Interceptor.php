<?php
namespace Codazon\Utility\Controller\Adminhtml\Theme\Save;

/**
 * Interceptor class for @see \Codazon\Utility\Controller\Adminhtml\Theme\Save
 */
class Interceptor extends \Codazon\Utility\Controller\Adminhtml\Theme\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\View\Design\Theme\ThemeProviderInterface $themeProvier)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $themeProvier);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
