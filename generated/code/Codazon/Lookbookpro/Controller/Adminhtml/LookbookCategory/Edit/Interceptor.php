<?php
namespace Codazon\Lookbookpro\Controller\Adminhtml\LookbookCategory\Edit;

/**
 * Interceptor class for @see \Codazon\Lookbookpro\Controller\Adminhtml\LookbookCategory\Edit
 */
class Interceptor extends \Codazon\Lookbookpro\Controller\Adminhtml\LookbookCategory\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $registry, \Codazon\Lookbookpro\Model\ResourceModel\LookbookCategory\CollectionFactory $lookCollectionFactory, \Codazon\Lookbookpro\Model\LookbookCategoryFactory $lookCategoryFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $registry, $lookCollectionFactory, $lookCategoryFactory);
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
