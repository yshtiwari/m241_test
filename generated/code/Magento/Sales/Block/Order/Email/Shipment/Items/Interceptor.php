<?php
namespace Magento\Sales\Block\Order\Email\Shipment\Items;

/**
 * Interceptor class for @see \Magento\Sales\Block\Order\Email\Shipment\Items
 */
class Interceptor extends \Magento\Sales\Block\Order\Email\Shipment\Items implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = [], ?\Magento\Sales\Api\OrderRepositoryInterface $orderRepository = null, ?\Magento\Sales\Api\ShipmentRepositoryInterface $creditmemoRepository = null)
    {
        $this->___init();
        parent::__construct($context, $data, $orderRepository, $creditmemoRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        return $pluginInfo ? $this->___callPlugins('toHtml', func_get_args(), $pluginInfo) : parent::toHtml();
    }
}
