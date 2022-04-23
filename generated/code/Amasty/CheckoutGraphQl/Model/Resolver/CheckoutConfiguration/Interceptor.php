<?php
namespace Amasty\CheckoutGraphQl\Model\Resolver\CheckoutConfiguration;

/**
 * Interceptor class for @see \Amasty\CheckoutGraphQl\Model\Resolver\CheckoutConfiguration
 */
class Interceptor extends \Amasty\CheckoutGraphQl\Model\Resolver\CheckoutConfiguration implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Escaper $escaper, \Magento\Framework\Serialize\Serializer\Json $jsonSerializer, \Amasty\CheckoutCore\Model\Config $configProvider, \Amasty\CheckoutCore\Model\ConfigProvider $checkoutConfig, \Magento\Framework\Module\Manager $moduleManager, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone)
    {
        $this->___init();
        parent::__construct($escaper, $jsonSerializer, $configProvider, $checkoutConfig, $moduleManager, $timezone);
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
