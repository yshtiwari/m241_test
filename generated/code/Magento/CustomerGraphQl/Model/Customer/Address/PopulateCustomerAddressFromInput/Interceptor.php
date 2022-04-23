<?php
namespace Magento\CustomerGraphQl\Model\Customer\Address\PopulateCustomerAddressFromInput;

/**
 * Interceptor class for @see \Magento\CustomerGraphQl\Model\Customer\Address\PopulateCustomerAddressFromInput
 */
class Interceptor extends \Magento\CustomerGraphQl\Model\Customer\Address\PopulateCustomerAddressFromInput implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Api\Data\AddressInterfaceFactory $addressFactory, \Magento\Customer\Api\Data\RegionInterfaceFactory $regionFactory, \Magento\Directory\Helper\Data $directoryData, \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper)
    {
        $this->___init();
        parent::__construct($addressFactory, $regionFactory, $directoryData, $regionCollectionFactory, $dataObjectHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\Customer\Api\Data\AddressInterface $address, array $addressData) : \Magento\Customer\Api\Data\AddressInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute($address, $addressData);
    }
}
