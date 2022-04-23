<?php
namespace Codazon\AjaxCartPro\Controller\Product\Wishlist\UpdateItemOptions;

/**
 * Interceptor class for @see \Codazon\AjaxCartPro\Controller\Product\Wishlist\UpdateItemOptions
 */
class Interceptor extends \Codazon\AjaxCartPro\Controller\Product\Wishlist\UpdateItemOptions implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Wishlist\Controller\WishlistProviderInterface $wishlistProvider, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $wishlistProvider, $productRepository, $formKeyValidator);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
