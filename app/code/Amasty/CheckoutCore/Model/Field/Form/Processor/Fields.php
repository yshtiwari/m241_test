<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/

declare(strict_types=1);

namespace Amasty\CheckoutCore\Model\Field\Form\Processor;

use Amasty\CheckoutCore\Model\Field;
use Amasty\CheckoutCore\Model\Field\Form\SaveField;
use Amasty\CheckoutCore\Model\Field\UpdateTelephoneAttribute;
use Amasty\CheckoutCore\Model\ResourceModel\Field\CollectionFactory;
use Amasty\CheckoutCore\Model\ResourceModel\GetCustomerAddressAttributeById;
use Magento\Customer\Api\Data\AddressInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Fields implements ProcessorInterface
{
    /**
     * @var CollectionFactory
     */
    private $fieldCollectionFactory;

    /**
     * @var SaveField
     */
    private $saveField;

    /**
     * @var GetCustomerAddressAttributeById
     */
    private $getCustomerAddressAttributeById;

    /**
     * @var UpdateTelephoneAttribute
     */
    private $updateTelephoneAttribute;

    public function __construct(
        CollectionFactory $fieldCollectionFactory,
        SaveField $saveField,
        GetCustomerAddressAttributeById $getCustomerAddressAttributeById,
        UpdateTelephoneAttribute $updateTelephoneAttribute
    ) {
        $this->fieldCollectionFactory = $fieldCollectionFactory;
        $this->saveField = $saveField;
        $this->getCustomerAddressAttributeById = $getCustomerAddressAttributeById;
        $this->updateTelephoneAttribute = $updateTelephoneAttribute;
    }

    public function process(array $fields, int $storeId): array
    {
        if (empty($fields)) {
            return [];
        }

        if ($storeId !== Field::DEFAULT_STORE_ID) {
            return $fields;
        }

        $fieldCollection = $this->fieldCollectionFactory->create();
        $fieldCollection->addFilterByStoreId($storeId);

        foreach ($fields as $attributeId => $fieldData) {
            $field = $fieldCollection->getItemByColumnValue(Field::ATTRIBUTE_ID, (string) $attributeId);

            $isEnabled = (int) $fieldData[Field::ENABLED] === 1;
            $fieldData[Field::REQUIRED] = $isEnabled && isset($fieldData[Field::REQUIRED]);
            $fieldData[Field::ATTRIBUTE_ID] = $fieldData[Field::ATTRIBUTE_ID] ?? $attributeId;
            $fieldData[Field::STORE_ID] = $storeId;

            $this->saveField->execute($field, $fieldData);

            if (!$isEnabled) {
                $attribute = $this->getCustomerAddressAttributeById->execute($attributeId);
                if ($attribute && $attribute->getAttributeCode() === AddressInterface::TELEPHONE) {
                    $this->updateTelephoneAttribute->execute($attribute);
                }
            }

            unset($fields[$attributeId]);
        }

        return $fields;
    }
}
