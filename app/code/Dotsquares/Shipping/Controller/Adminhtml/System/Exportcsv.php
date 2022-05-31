<?php namespace Dotsquares\Shipping\Controller\Adminhtml\System;

use Magento\Framework\App\ResponseInterface;
use Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker;
use Magento\Framework\App\Filesystem\DirectoryList;

class Exportcsv extends \Magento\Config\Controller\Adminhtml\System\AbstractConfig
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Config\Model\Config\Structure $configStructure,
        ConfigSectionChecker $sectionChecker,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_fileFactory = $fileFactory;
        parent::__construct($context, $configStructure, $sectionChecker);
    }

    public function execute()
    {
        $fileName = 'dotsquares_shipping.csv';
        $block = $this->_view->getLayout()->createBlock(
            'Dotsquares\Shipping\Block\Adminhtml\Carrier\Shipping\Csvformat'
        );
        $website = $this->_storeManager->getWebsite($this->getRequest()->getParam('website'));
        if ($this->getRequest()->getParam('conditiontype')) {
            $condition_type = $this->getRequest()->getParam('conditiontype');
        } else {
            $condition_type = $website->getConfig('carriers/dotsquares/condition_type');
        }
        $block->setWebsiteId($website->getId())->setConditionName($condition_type);
        $content = $block->getCsvFile();
        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}