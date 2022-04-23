<?php
namespace Ewave\ExtendedBundleProduct\Controller\Adminhtml\ExtendedBundleProduct\ConfigurableOptions;

/**
 * Interceptor class for @see \Ewave\ExtendedBundleProduct\Controller\Adminhtml\ExtendedBundleProduct\ConfigurableOptions
 */
class Interceptor extends \Ewave\ExtendedBundleProduct\Controller\Adminhtml\ExtendedBundleProduct\ConfigurableOptions implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Ewave\ExtendedBundleProduct\Api\SelectionRepositoryInterface $selectionRepository, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
    {
        $this->___init();
        parent::__construct($context, $selectionRepository, $productRepository);
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
