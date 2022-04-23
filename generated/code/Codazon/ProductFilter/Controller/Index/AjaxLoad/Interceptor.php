<?php
namespace Codazon\ProductFilter\Controller\Index\AjaxLoad;

/**
 * Interceptor class for @see \Codazon\ProductFilter\Controller\Index\AjaxLoad
 */
class Interceptor extends \Codazon\ProductFilter\Controller\Index\AjaxLoad implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Codazon\ProductFilter\Block\Product\Ajax $productsListBlock)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $productsListBlock);
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
