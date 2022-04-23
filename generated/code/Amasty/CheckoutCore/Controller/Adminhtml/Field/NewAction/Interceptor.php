<?php
namespace Amasty\CheckoutCore\Controller\Adminhtml\Field\NewAction;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Controller\Adminhtml\Field\NewAction
 */
class Interceptor extends \Amasty\CheckoutCore\Controller\Adminhtml\Field\NewAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\CheckoutCore\Model\ResourceModel\Field $fieldResource, \Amasty\CheckoutCore\Model\FieldFactory $fieldFactory, \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->___init();
        parent::__construct($context, $fieldResource, $fieldFactory, $eavSetupFactory);
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
