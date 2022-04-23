<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * CatalogRule data helper
 */
namespace Codazon\Shopbybrandpro\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_objectManager;
    protected $_scopeConfig;
    protected $_urlBuilder;
    protected $_imageHelper;
    protected $_brandFactory;
    protected $_storeManager;
    protected $_storeId;
    protected $_attributeCode;
    
    protected $_brandProducts = [];
    protected $_brandProductCount = [];
    protected $_blockFilter;
    protected $_viewRoute;
    protected $_wisibleInCatalogIds;
    protected $_coreHelper;
    protected $brandAttrId;
    protected $_allRoutes;
    protected $_customRoutesData;
    protected $_currentAttributeData;
    
    
    const CURRENT_ATTR_PARAM = 'shopby_attribute';
    const ATTR_CODE_CONFIG_PATH = 'codazon_shopbybrand/general/attribute_code';
    const ROUTE_NAME_CONFIG_PATH = 'codazon_shopbybrand/general/view_route_name';
    
    protected $attributeToSelect = ['brand_title', 'brand_url_key', 'brand_description', 'brand_content', 'brand_thumbnail', 'brand_cover', 'brand_is_featured', 'brand_meta_title', 'brand_meta_description', 'brand_meta_keyword'];
    
    protected $attributesInList = ['brand_thumbnail', 'brand_is_featured', 'brand_description', 'brand_url_key'];
    
    protected $_currentAttributeCode;
    
	public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Codazon\Shopbybrandpro\Helper\Image $imageHelper,
        \Codazon\Shopbybrandpro\Model\BrandFactory $brandFactory,
        \Codazon\Core\Helper\Data $coreHelper
    ) {
        parent::__construct($context);
        $this->_coreHelper = $coreHelper;
        $this->_objectManager = $coreHelper->getObjectManager();
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_urlBuilder = $context->getUrlBuilder();
        $this->_imageHelper = $imageHelper;
        $this->_brandFactory = $brandFactory;
        $this->_storeManager = $this->_coreHelper->getStoreManager();
        $this->_storeId = $this->_storeManager->getStore()->getId();
        $this->_attributeCode = $this->_scopeConfig->getValue(static::ATTR_CODE_CONFIG_PATH, 'store', $this->_storeId);
        $this->_viewRoute = $this->_scopeConfig->getValue(static::ROUTE_NAME_CONFIG_PATH, 'store', $this->_storeId);
    }
    
    public function getCoreHelper()
    {
        return $this->_coreHelper;
    }
    
    public function getAttributesInList()
    {
        return $this->attributesInList;
    }
    
    /* public function getViewRoute()
    {
        return $this->_viewRoute;
    } */
    
    public function getScopeConfig()
    {
        return $this->_scopeConfig;
    }
    
    public function getStoreManager()
    {
        return $this->_storeManager;
    }
    
    public function getStoreBrandCode() 
    {
        return $this->_attributeCode;
    }
    
    public function getCurrentAttributeCode()
    {
        /* if ($this->_currentAttributeCode === null) {
            $this->_currentAttributeCode = $this->_coreHelper->getRequest()->getParam(static::CURRENT_ATTR_PARAM);
        }
        return $this->_currentAttributeCode; */
        return $this->_coreHelper->getRequest()->getParam(static::CURRENT_ATTR_PARAM, null);
    }
    
    
    public function getImageHelper()
    {
        return $this->_imageHelper;
    }
    
    public function getUrl($path, $params = [])
    {
        return $this->_urlBuilder->getUrl($path, $params);
    }
    
    public function getBrandImage($brand, $type = 'brand_thumbnail', $options = [])
    {
        $brandThumb = $brand->getData($type);
        if ($type == 'brand_thumbnail') {
            if (!$brandThumb) {
                $brandThumb = 'codazon/brand/placeholder_thumbnail.jpg';
            }
        }
		if ($brandThumb) {
			if (isset($options['width']) || isset($options['height'])) {
				if(!isset($options['width'])) {
					$options['width'] = null;
                }
				if(!isset($options['height'])) {
					$options['height'] = null;
                }
				return $this->_imageHelper->init($brandThumb)
                    ->resize($options['width'], $options['height'])->__toString();
			} else {
				return $this->_mediaUrl.$brand->getData($type);
			}
		}else{
			return '';
		}
	}
    
    public function getCustomRoutesData()
    {
        if ($this->_customRoutesData === null) {
            $customRoutes = $this->_scopeConfig->getValue('codazon_shopbybrand/shop_by_attribute/route', 'store');
            $this->_customRoutesData = [];
            if ($customRoutes) {
                $customRoutes = json_decode($customRoutes, true);
                foreach ($customRoutes as $route) {
                    $this->_customRoutesData[$route['code']] = $route;
                }
            }
        }
        return $this->_customRoutesData;
    }
    
    public function getCurrentAttributeData()
    {
        if ($this->_currentAttributeData === null) {
            $code = $this->getCurrentAttributeCode() ? : $this->_attributeCode;
            $routeData = $this->getCustomRoutesData();
            $route = $this->getViewRoute($code);
            $desc = '';
            if (!isset($routeData[$code])) {
                $routeData[$code] = [];
            }
            if (isset($routeData[$code], $routeData[$code]['desc_identifier'])) {
                $descId = $routeData[$code]['desc_identifier'];
                $cmsBlock = $this->_objectManager->create(\Magento\Cms\Model\Block::class)->setStore($this->_storeId)->load($descId, 'identifier');
                if ($cmsBlock->getId()) {
                    $desc = $this->_coreHelper->htmlFilter($cmsBlock->getContent());
                }
            }
            $this->_currentAttributeData = array_replace($routeData[$code], [
                'code'  => $code,
                'title' => isset($routeData[$code]['title']) ? __($routeData[$code]['title']) : __('Brands'),
                'route' => $route,
                'url' => $this->getUrl('', ['_direct' => $route]),
                'description' => $desc,
                'featured_title' => isset($routeData[$code]['featured_title']) ? (string)__($routeData[$code]['featured_title']) : '',
                'all_title' => isset($routeData[$code]['all_title']) ? (string)__($routeData[$code]['all_title']) : ''
            ]);
        }
        return $this->_currentAttributeData;
    }
    
    
    public function getAllRoutes()
    {
        if ($this->_allRoutes === null) {
            $this->_allRoutes = [$this->_attributeCode => $this->_viewRoute];
            foreach ($this->getCustomRoutesData() as $route) {
                $this->_allRoutes[$route['code']] = $route['route'];
            }
            $this->_allRoutes = array_unique($this->_allRoutes);
        }
        return $this->_allRoutes;
    }
    
    public function getViewRoute($attributeCode = null) {
        if (!$attributeCode) {
            return $this->_viewRoute;
        } else {
            $allRoutes = $this->getAllRoutes();
            return $allRoutes[$attributeCode];
        }
    }
    
    public function getBrandPageUrl($brandModel, $code = null)
    {
        $viewRoute = $this->getViewRoute($code);
		if ($brandModel->getData('brand_url_key')) {
            return $this->getUrl($viewRoute, ['_nosid' => true]) . (string)$brandModel->getData('brand_url_key');
        } else {
            return $this->getUrl($viewRoute, ['_nosid' => true]) . urlencode(str_replace([' ',"'"],['-','-'], strtolower(trim((string)$brandModel->getData('brand_label')))));
        }
	}
    
    public function getBrandUrl($brandModel, $code = null)
    {
        $viewRoute = $this->getViewRoute($code);
		if ($brandModel->getData('brand_url_key')) {
            return $this->getUrl('', ['_direct' => $viewRoute . '/' . $brandModel->getData('brand_url_key')]);
        } else {
            return $this->getUrl('', ['_direct' => $viewRoute . '/' . 
                urlencode(str_replace([' ',"'"],['-','-'], strtolower(trim($brandModel->getData('name')))))
            ]);
        }
	}
    
    public function getVisibleInCatalogIds()
    {
        if ($this->_wisibleInCatalogIds === null) {
            $this->_wisibleInCatalogIds = $this->_objectManager->get(\Magento\Catalog\Model\Product\Visibility::class)->getVisibleInCatalogIds();
        }
        return $this->_wisibleInCatalogIds;
    }
    
    public function getProductCount($attributeCode, $optionId)
    {
        if ($attributeCode === null) {
            $attributeCode = $this->getCurrentAttributeCode() ? : $this->_attributeCode;
        }
        $key = $attributeCode.'_'.$optionId;
        if (!isset($this->_brandProductCount[$key])) {
            $collection = $this->_objectManager->get(\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory::class)->create();
            $collection->addStoreFilter()->setVisibility($this->getVisibleInCatalogIds())
                ->addAttributeToFilter($attributeCode, $optionId);
            $this->_brandProductCount[$key] = $collection->getSize();
        }
        return $this->_brandProductCount[$key];
    }
    
    
    public function getBrandByProduct($product, $attributeCode)
    {
        $attrValue = (int)$product->getData($attributeCode);
        if (!isset($this->_brandProducts[$attrValue])) {
            $brandModel = $this->_brandFactory->create()->setStoreId($this->_storeId)
                ->setOptionId($attrValue)
                ->load(null);
            $brandModel->setUrl($this->getBrandPageUrl($brandModel));
            $brandModel->setThumbnail($this->getBrandImage($brandModel, 'brand_thumbnail', ['width' => 150]));
            $this->_brandProducts[$attrValue] = $brandModel;
        }
		return $this->_brandProducts[$attrValue];
	}
    
    public function htmlFilter($content)
    {
        return $this->_coreHelper->htmlFilter((string)$content);
    }
    
    public function getBrandLinkHtml($product)
    {
        $brand = $this->getBrandByProduct($product, $this->_attributeCode);
        return $brand->getOptionId() ? "<a href=\"{$brand->getUrl()}\" class=\"product-item-brand\">{$brand->getBrandLabel()}</a>" : "";
    }
    
    public function getBrandAttributeCode()
    {
        if ($this->brandAttrCode === null) {
            $this->brandAttrCode = $this->getConfig(self::CONFIG_BRAND_CODE);
        }
        return $this->brandAttrCode;
    }
    
    public function getAttributeIdByCode($code)
    {
        return $this->_objectManager
                ->get(\Magento\Eav\Model\ResourceModel\Entity\Attribute::class)
                ->getIdByCode('catalog_product', $code);
    }
    
    public function getAttributeId()
    {
        if ($this->brandAttrId === null) {
            $this->brandAttrId = $this->_objectManager
                ->get(\Magento\Eav\Model\ResourceModel\Entity\Attribute::class)
                ->getIdByCode('catalog_product', $this->_attributeCode);
        }
        return $this->brandAttrId;
    }
    
    public function getBrandCollection($storeId = null, $brandAttrId = null, $attributeToSelect = null)
    {
        if ($storeId === null) {
            $storeId = $this->_storeId;
        }
        if ($brandAttrId === null) {
            $brandAttrId = $this->getAttributeId();
        }
        if ($attributeToSelect === null) {
            $attributeToSelect = $this->attributeToSelect;
        }
        $collection = $this->_objectManager->get(\Codazon\Shopbybrandpro\Model\ResourceModel\Option\CollectionFactory::class)->create();
        $collection = $this->joinExtraAttributesToOptionCollection($collection, $storeId, $brandAttrId, $attributeToSelect);
        return $collection;
    }
    
    public function joinExtraAttributesToOptionCollection($collection, $storeId = null, $brandAttrId = null, $attributeToSelect = null)
    {
        if ($storeId === null) {
            $storeId = $this->_storeId;
        }
        if ($brandAttrId === null) {
            $brandAttrId = $this->getAttributeId();
        }
        if ($attributeToSelect === null) {
            $attributeToSelect = $this->attributeToSelect;
        }
        $collection->addFieldToFilter('main_table.attribute_id', $brandAttrId);
        $connection = $collection->getConnection();
        $defaultStoreId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
        $optionValueSelect = $connection->select()->from(
            ["eaov_default" => 
                $connection->select()->from(["eaov_default" => $collection->getTable("eav_attribute_option_value")])
                    ->where("eaov_default.store_id = {$defaultStoreId}")
            ]
        )->joinLeft(
            ["eaov" => 
                $connection->select()->from(["eaov" => $collection->getTable("eav_attribute_option_value")])
                    ->where("eaov.store_id = {$storeId}")
            ],
            "eaov_default.option_id = eaov.option_id"
        )->reset(\Zend_Db_Select::COLUMNS)->columns([
            "eaov_default.option_id AS option_id",
            "IF(eaov.value_id > 0, eaov.value, eaov_default.value) AS name",
        ]);
        $collection->getSelect()->joinInner(
            ["eaov_all" =>  $optionValueSelect],
            "main_table.option_id = eaov_all.option_id",
            ["name" => "eaov_all.name"]
        );
        $brandCol = $this->_objectManager->get(\Codazon\Shopbybrandpro\Model\ResourceModel\BrandEntity\CollectionFactory::class)->create();
        $brandCol->setStore($storeId)->addAttributeToSelect($attributeToSelect);
        foreach ($attributeToSelect as $attrCode) {
            $brandCol->addAttributeJoin($attrCode, 'left');
        }
        $collection->addFieldToFilter('brand.is_active', ['neq' => 0])->getSelect()->joinLeft(
            ['brand' => $brandCol->getSelect()],
            "main_table.option_id = brand.option_id",
            $attributeToSelect
        );
        
        return $collection;
    }
}
