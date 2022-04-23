<?php
namespace Amasty\CheckoutGraphQl\Model\Resolver\GiftMessageForOrderItemInCart;

/**
 * Interceptor class for @see \Amasty\CheckoutGraphQl\Model\Resolver\GiftMessageForOrderItemInCart
 */
class Interceptor extends \Amasty\CheckoutGraphQl\Model\Resolver\GiftMessageForOrderItemInCart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\GiftMessage\Api\ItemRepositoryInterface $gmItemRepository)
    {
        $this->___init();
        parent::__construct($gmItemRepository);
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
