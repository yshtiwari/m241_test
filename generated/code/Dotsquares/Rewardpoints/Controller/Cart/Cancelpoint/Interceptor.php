<?php
namespace Dotsquares\Rewardpoints\Controller\Cart\Cancelpoint;

/**
 * Interceptor class for @see \Dotsquares\Rewardpoints\Controller\Cart\Cancelpoint
 */
class Interceptor extends \Dotsquares\Rewardpoints\Controller\Cart\Cancelpoint implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Cart $cart, \Dotsquares\Rewardpoints\Helper\Data $helper, \Magento\Framework\Json\Helper\Data $jsonHelper, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Customer\Model\Session $customerSession, \Dotsquares\Rewardpoints\Model\Items $rewardcollection)
    {
        $this->___init();
        parent::__construct($context, $cart, $helper, $jsonHelper, $resultJsonFactory, $customerSession, $rewardcollection);
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
