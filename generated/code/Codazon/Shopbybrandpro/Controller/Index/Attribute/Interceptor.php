<?php
namespace Codazon\Shopbybrandpro\Controller\Index\Attribute;

/**
 * Interceptor class for @see \Codazon\Shopbybrandpro\Controller\Index\Attribute
 */
class Interceptor extends \Codazon\Shopbybrandpro\Controller\Index\Attribute implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Codazon\Shopbybrandpro\Model\BrandFactory $brandFactory, \Codazon\Shopbybrandpro\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $brandFactory, $helper);
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
