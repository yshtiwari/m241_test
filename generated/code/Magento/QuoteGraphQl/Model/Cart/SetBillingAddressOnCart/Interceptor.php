<?php
namespace Magento\QuoteGraphQl\Model\Cart\SetBillingAddressOnCart;

/**
 * Interceptor class for @see \Magento\QuoteGraphQl\Model\Cart\SetBillingAddressOnCart
 */
class Interceptor extends \Magento\QuoteGraphQl\Model\Cart\SetBillingAddressOnCart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\QuoteGraphQl\Model\Cart\QuoteAddressFactory $quoteAddressFactory, \Magento\QuoteGraphQl\Model\Cart\AssignBillingAddressToCart $assignBillingAddressToCart)
    {
        $this->___init();
        parent::__construct($quoteAddressFactory, $assignBillingAddressToCart);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\GraphQl\Model\Query\ContextInterface $context, \Magento\Quote\Api\Data\CartInterface $cart, array $billingAddressInput) : void
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute($context, $cart, $billingAddressInput);
    }
}
