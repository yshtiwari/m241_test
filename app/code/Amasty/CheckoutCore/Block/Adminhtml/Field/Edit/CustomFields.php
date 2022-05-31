<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/


namespace Amasty\CheckoutCore\Block\Adminhtml\Field\Edit;

use Magento\Customer\Model\Indexer\Address\AttributeProvider;
use Amasty\CheckoutCore\Api\Data\CustomFieldsConfigInterface;
use Magento\Customer\Api\Data\AttributeMetadataInterface;
use Magento\Store\Model\ScopeInterface;
use Amasty\CheckoutCore\Model\Field;
use Amasty\CheckoutCore\Model\ModuleEnable;
use Magento\Eav\Setup\EavSetup;
use Magento\Backend\Block\Template\Context;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory;
use Amasty\CheckoutCore\Block\Adminhtml\Renderer\Template;

class CustomFields extends Template
{
    /**
     * @var ModuleEnable
     */
    private $moduleEnable;

    /**
     * @var EavSetup
     */
    private $eavSetup;

    /**
     * @var CollectionFactory
     */
    private $eavCollectionFactory;

    public function __construct(
        Context $context,
        ModuleEnable $moduleEnable,
        EavSetup $eavSetup,
        CollectionFactory $eavCollectionFactory,
        array $data = []
    ) {
        $this->moduleEnable = $moduleEnable;
        $this->eavSetup = $eavSetup;
        $this->eavCollectionFactory = $eavCollectionFactory;

        parent::__construct($context, $data);
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    public function isExistField($index)
    {
        return (bool)$this->eavSetup->getAttribute(AttributeProvider::ENTITY, 'custom_field_' . $index);
    }

    /**
     * @return bool
     */
    public function isExistOrderAttributesExt()
    {
        return $this->moduleEnable->isOrderAttributesEnable();
    }

    /**
     * @return bool
     */
    public function isAllCustomFieldsAdded()
    {
        /** @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $eavCollection */
        $eavCollection =  $this->eavCollectionFactory->create();
        $eavCollection->addFieldToFilter(
            [
                AttributeMetadataInterface::ATTRIBUTE_CODE,
                AttributeMetadataInterface::ATTRIBUTE_CODE,
                AttributeMetadataInterface::ATTRIBUTE_CODE
            ],
            [
                ['eq' => CustomFieldsConfigInterface::CUSTOM_FIELD_1_CODE],
                ['eq' => CustomFieldsConfigInterface::CUSTOM_FIELD_2_CODE],
                ['eq' => CustomFieldsConfigInterface::CUSTOM_FIELD_3_CODE]
            ]
        );

        if ($eavCollection->getSize() == CustomFieldsConfigInterface::COUNT_OF_CUSTOM_FIELDS) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getCurrentStoreId()
    {
        return $this->_request->getParam(ScopeInterface::SCOPE_STORE, Field::DEFAULT_STORE_ID);
    }
}
