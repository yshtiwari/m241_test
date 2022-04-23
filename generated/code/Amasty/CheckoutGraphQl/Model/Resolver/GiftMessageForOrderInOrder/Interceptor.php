<?php
namespace Amasty\CheckoutGraphQl\Model\Resolver\GiftMessageForOrderInOrder;

/**
 * Interceptor class for @see \Amasty\CheckoutGraphQl\Model\Resolver\GiftMessageForOrderInOrder
 */
class Interceptor extends \Amasty\CheckoutGraphQl\Model\Resolver\GiftMessageForOrderInOrder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\GiftMessage\Api\OrderRepositoryInterface $gmOrderRepository)
    {
        $this->___init();
        parent::__construct($gmOrderRepository);
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
