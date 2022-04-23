<?php
namespace Amasty\CheckoutGraphQl\Model\Resolver\GiftWrapOrderInformation;

/**
 * Interceptor class for @see \Amasty\CheckoutGraphQl\Model\Resolver\GiftWrapOrderInformation
 */
class Interceptor extends \Amasty\CheckoutGraphQl\Model\Resolver\GiftWrapOrderInformation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\CheckoutCore\Api\FeeRepositoryInterface $feeRepository, \Magento\Sales\Api\Data\OrderInterface $orderModel)
    {
        $this->___init();
        parent::__construct($feeRepository, $orderModel);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        return $pluginInfo ? $this->___callPlugins('resolve', func_get_args(), $pluginInfo) : parent::resolve($field, $context, $info, $value, $args);
    }
}
