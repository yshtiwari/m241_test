<?php
namespace Dotsquares\Opc\Controller\Account\CreateWithPassword;

/**
 * Interceptor class for @see \Dotsquares\Opc\Controller\Account\CreateWithPassword
 */
class Interceptor extends \Dotsquares\Opc\Controller\Account\CreateWithPassword implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\DataObject\Copy $objectCopyService, \Magento\Customer\Api\AccountManagementInterface $accountManagement, \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerInterfaceFactory, \Magento\Customer\Api\Data\AddressInterfaceFactory $addressFactory, \Magento\Customer\Api\Data\RegionInterfaceFactory $regionFactory, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Quote\Model\Quote\AddressFactory $quoteAddressFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Checkout\Model\Session $checkoutSession, \Dotsquares\Opc\Model\OrderCustomerExtractor $orderCustomerExtractor, \Magento\Customer\Model\CustomerFactory $customerFactory, \Magento\Framework\Encryption\EncryptorInterface $encryptor, \Magento\Customer\Model\Session\Proxy $customerSession)
    {
        $this->___init();
        parent::__construct($context, $objectCopyService, $accountManagement, $customerInterfaceFactory, $addressFactory, $regionFactory, $orderRepository, $quoteAddressFactory, $resultJsonFactory, $checkoutSession, $orderCustomerExtractor, $customerFactory, $encryptor, $customerSession);
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
