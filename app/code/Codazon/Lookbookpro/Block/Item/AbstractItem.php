<?php
/**
 * Copyright © 2018 Codazon, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Codazon\Lookbookpro\Block\Item;

use Magento\Framework\View\Element\Template;
use Codazon\Lookbookpro\Model\LookbookItem;

class AbstractItem extends \Magento\Framework\View\Element\Template
{
    protected $_context;
    protected $_httpContext;
    protected $_mediaUrl;
    protected $_objectManager;
    protected $_imageHelper;
    protected $_coreRegistry;
    protected $_copeConfig;
    protected $_helper;
    protected $_cacheTag = LookbookItem::CACHE_TAG;
    
    public function __construct(
		Template\Context $context,
		\Magento\Framework\App\Http\Context $httpContext,
        \Magento\Framework\Registry $coreRegistry,
        \Codazon\Lookbookpro\Helper\Data $helper,
        array $data = []
	){
        parent::__construct($context, $data);
        $this->_httpContext = $httpContext;
        $this->_context = $context;
        $this->_storeManager = $context->getStoreManager();
        $this->_mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $this->_objectManager = $helper->getObjectManager();
        $this->_assetRepository = $context->getAssetRepository();
        $this->_helper = $helper;
        $this->_coreRegistry = $coreRegistry;
        $this->_copeConfig = $context->getScopeConfig();
    }
}