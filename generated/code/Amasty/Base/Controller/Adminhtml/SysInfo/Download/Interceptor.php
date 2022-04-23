<?php
namespace Amasty\Base\Controller\Adminhtml\SysInfo\Download;

/**
 * Interceptor class for @see \Amasty\Base\Controller\Adminhtml\SysInfo\Download
 */
class Interceptor extends \Amasty\Base\Controller\Adminhtml\SysInfo\Download implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Filesystem\Directory\WriteFactory $writeFactory, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Amasty\Base\Model\SysInfo\Command\SysInfoService\Download $downloadCommand)
    {
        $this->___init();
        parent::__construct($context, $filesystem, $writeFactory, $fileFactory, $downloadCommand);
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
