<?php
namespace Amasty\CheckoutCore\Cache\CachedLayoutProcessor\AddressFormAttributes\DefaultAttributeValueUpdate;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Cache\CachedLayoutProcessor\AddressFormAttributes\DefaultAttributeValueUpdate
 */
class Interceptor extends \Amasty\CheckoutCore\Cache\CachedLayoutProcessor\AddressFormAttributes\DefaultAttributeValueUpdate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Helper\Address $addressHelper, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Directory\Helper\Data $directoryHelper, ?\Magento\Directory\Model\AllowedCountries $allowedCountryReader = null)
    {
        $this->___init();
        parent::__construct($addressHelper, $customerSession, $customerRepository, $directoryHelper, $allowedCountryReader);
    }

    /**
     * {@inheritdoc}
     */
    public function merge($elements, $providerName, $dataScopePrefix, array $fields = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'merge');
        return $pluginInfo ? $this->___callPlugins('merge', func_get_args(), $pluginInfo) : parent::merge($elements, $providerName, $dataScopePrefix, $fields);
    }
}
