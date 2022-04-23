<?php
namespace Amasty\CheckoutCore\Helper\AttributeMerger\AddressHelper;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Helper\AttributeMerger\AddressHelper
 */
class Interceptor extends \Amasty\CheckoutCore\Helper\AttributeMerger\AddressHelper implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Helper\Context $context, \Magento\Framework\View\Element\BlockFactory $blockFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Customer\Api\CustomerMetadataInterface $customerMetadataService, \Magento\Customer\Api\AddressMetadataInterface $addressMetadataService, \Magento\Customer\Model\Address\Config $addressConfig)
    {
        $this->___init();
        parent::__construct($context, $blockFactory, $storeManager, $customerMetadataService, $addressMetadataService, $addressConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function getStreetLines($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStreetLines');
        return $pluginInfo ? $this->___callPlugins('getStreetLines', func_get_args(), $pluginInfo) : parent::getStreetLines($store);
    }
}
