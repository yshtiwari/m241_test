<?php
namespace Dotsquares\Opc\Controller\Index\Index;

/**
 * Interceptor class for @see \Dotsquares\Opc\Controller\Index\Index
 */
class Interceptor extends \Dotsquares\Opc\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session\Proxy $customerSession, \Magento\Checkout\Model\Type\Onepage $onepage, \Magento\Checkout\Helper\Data $checkoutHelper, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Checkout\Model\Session\Proxy $checkoutSession, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Dotsquares\Opc\Helper\Data $opcHelper, \Magento\Customer\Api\AccountManagementInterface $accountManagement)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $onepage, $checkoutHelper, $customerRepository, $resultRawFactory, $checkoutSession, $resultPageFactory, $opcHelper, $accountManagement);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
