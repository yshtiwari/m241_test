<?php namespace Mca\Suppliers\Model;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Suppliersname implements OptionSourceInterface{
    public function __construct(
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->_eavConfig = $eavConfig;
        $this->_objectManager = $objectManager;
    }
    public function getOptionArray()
    {
        $attributeCode = "manufacturer";
        $attribute = $this->_eavConfig->getAttribute('catalog_product', $attributeCode);
        $options = $attribute->getSource()->getAllOptions();
    	$option_arr = [];
        foreach ($options as $option) {
            if ($option['value'] > 0) {
                $option_arr[] = $option;
            }
        }
        return $option_arr;
    }
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }
    
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}