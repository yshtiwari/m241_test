<?php
namespace Amasty\CheckoutGraphQl\Model\Resolver\UpdateGiftWrapInformation;

/**
 * Interceptor class for @see \Amasty\CheckoutGraphQl\Model\Resolver\UpdateGiftWrapInformation
 */
class Interceptor extends \Amasty\CheckoutGraphQl\Model\Resolver\UpdateGiftWrapInformation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\CheckoutGraphQl\Model\Utils\CartProvider $cartProvider, \Magento\Framework\Module\Manager $moduleManager, \Amasty\CheckoutCore\Api\FeeRepositoryInterface $feeRepository)
    {
        $this->___init();
        parent::__construct($cartProvider, $moduleManager, $feeRepository);
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
