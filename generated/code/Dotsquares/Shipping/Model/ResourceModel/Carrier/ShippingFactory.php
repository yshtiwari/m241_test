<?php
namespace Dotsquares\Shipping\Model\ResourceModel\Carrier;

/**
 * Factory class for @see \Dotsquares\Shipping\Model\ResourceModel\Carrier\Shipping
 */
class ShippingFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Dotsquares\\Shipping\\Model\\ResourceModel\\Carrier\\Shipping')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Dotsquares\Shipping\Model\ResourceModel\Carrier\Shipping
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
