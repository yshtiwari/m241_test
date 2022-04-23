<?php
namespace Magento\QuoteGraphQl\Model\Cart\SetShippingAddressesOnCart;

/**
 * Interceptor class for @see \Magento\QuoteGraphQl\Model\Cart\SetShippingAddressesOnCart
 */
class Interceptor extends \Magento\QuoteGraphQl\Model\Cart\SetShippingAddressesOnCart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Quote\Model\QuoteIdToMaskedQuoteIdInterface $quoteIdToMaskedQuoteId, \Magento\QuoteGraphQl\Model\Cart\GetCartForUser $getCartForUser, \Magento\QuoteGraphQl\Model\Cart\AssignShippingAddressToCart $assignShippingAddressToCart, \Magento\QuoteGraphQl\Model\Cart\GetShippingAddress $getShippingAddress, ?\Magento\Quote\Model\QuoteRepository $quoteRepository = null)
    {
        $this->___init();
        parent::__construct($quoteIdToMaskedQuoteId, $getCartForUser, $assignShippingAddressToCart, $getShippingAddress, $quoteRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\GraphQl\Model\Query\ContextInterface $context, \Magento\Quote\Api\Data\CartInterface $cart, array $shippingAddressesInput) : void
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute($context, $cart, $shippingAddressesInput);
    }
}
