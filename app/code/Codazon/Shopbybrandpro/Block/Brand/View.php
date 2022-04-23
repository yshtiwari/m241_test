<?php
/**
 * Copyright © 2022 Codazon, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Codazon\Shopbybrandpro\Block\Brand;

class View extends \Magento\Framework\View\Element\Template implements \Magento\Framework\DataObject\IdentityInterface
{
    protected $_coreRegistry;

    protected $_helper;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Codazon\Shopbybrandpro\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_helper = $helper;
        $this->_coreRegistry = $registry;
    }
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $brand = $this->getBrand();
		if ($brand) {
			$title = $brand->getBrandLabel();
            $metaTitle = $brand->getBrandMetaTitle()?:$title;
			$this->pageConfig->getTitle()->set($metaTitle);
            
			$description = $brand->getBrandMetaDescription()?:$brand->getBrandDescription();
			if ($description) {
                $this->pageConfig->setDescription($description);
            }
			$keywords = $brand->getBrandMetaKeyword();
			if ($keywords) {
				$this->pageConfig->setKeywords($keywords);
			}
						
			$pageMainTitle = $this->getLayout()->getBlock('page.main.title');
			if ($pageMainTitle) {
                $pageMainTitle->setPageTitle($title);
            }
            
            $this->pageConfig->addRemotePageAsset($brand->getUrl(),
                'canonical', 
                ['attributes' => ['rel' => 'canonical']]
            );
            /* facebook meta tag */
            $this->pageConfig->setMetadata('og:url', $brand->getUrl());
            $this->pageConfig->setMetadata('og:type', 'article');
            $this->pageConfig->setMetadata('og:title', $metaTitle);
            $this->pageConfig->setMetadata('og:description', $description);
            $this->pageConfig->setMetadata('og:image', $brand->getThumbnail());
            
            $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
            if ($breadcrumbsBlock) {
                $attributeData = $this->_helper->getCurrentAttributeData();
                $breadcrumbsBlock->addCrumb(
                    'home',
                    [
                        'label' => __('Home'),
                        'title' => __('Go to Home Page'),
                        'link' => $this->_storeManager->getStore()->getBaseUrl()
                    ]
                );
                $breadcrumbsBlock->addCrumb(
                    'brands',
                    [
                        'label' => $attributeData['title'],
                        'title' => $attributeData['title'],
                        'link'  => $attributeData['url']
                    ]
                );
                $breadcrumbsBlock->addCrumb(
                    'brand',
                    [
                        'label' => $title,
                        'title' => $title
                    ]
                );
            }
            
            if (class_exists('\Magento\LayeredNavigation\ViewModel\Layer\Filter')) {
                if ($catalogNav = $this->getLayout()->getBlock('catalog.navigation.renderer')) {
                    $catalogNav->setData('product_layer_view_model', \Magento\Framework\App\ObjectManager::getInstance()
                        ->create(\Magento\LayeredNavigation\ViewModel\Layer\Filter::class));
                }
            }
		}
        return $this;
    }
	
	public function getBrand()
    {
        if (!$this->hasData('brand')) {
            $this->setData('brand', $this->_coreRegistry->registry('current_brand'));
        }
        return $this->getData('brand');
    }
	
	public function getProductListHtml()
    {
        return $this->getChildHtml('product_list');
    }
	public function getIdentities(){
		return [$this->getBrand()->getOptionId()];
	}
	
}