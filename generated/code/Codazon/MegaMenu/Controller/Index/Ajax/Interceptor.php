<?php
namespace Codazon\MegaMenu\Controller\Index\Ajax;

/**
 * Interceptor class for @see \Codazon\MegaMenu\Controller\Index\Ajax
 */
class Interceptor extends \Codazon\MegaMenu\Controller\Index\Ajax implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Codazon\MegaMenu\Block\Widget\Megamenu $menu)
    {
        $this->___init();
        parent::__construct($context, $menu);
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
