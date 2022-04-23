<?php
namespace Magento\SalesGraphQl\Model\Order\OrderAddress;

/**
 * Interceptor class for @see \Magento\SalesGraphQl\Model\Order\OrderAddress
 */
class Interceptor extends \Magento\SalesGraphQl\Model\Order\OrderAddress implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderShippingAddress(\Magento\Sales\Api\Data\OrderInterface $order) : ?array
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrderShippingAddress');
        return $pluginInfo ? $this->___callPlugins('getOrderShippingAddress', func_get_args(), $pluginInfo) : parent::getOrderShippingAddress($order);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderBillingAddress(\Magento\Sales\Api\Data\OrderInterface $order) : ?array
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrderBillingAddress');
        return $pluginInfo ? $this->___callPlugins('getOrderBillingAddress', func_get_args(), $pluginInfo) : parent::getOrderBillingAddress($order);
    }
}
