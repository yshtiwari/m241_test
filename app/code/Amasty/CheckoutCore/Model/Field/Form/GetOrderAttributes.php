<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/

declare(strict_types=1);

namespace Amasty\CheckoutCore\Model\Field\Form;

use Amasty\CheckoutCore\Model\Field;
use Amasty\Orderattr\Model\ResourceModel\Attribute\Collection;
use Amasty\Orderattr\Model\ResourceModel\Attribute\CollectionFactory;
use Magento\Eav\Model\Attribute;
use Magento\Framework\ObjectManagerInterface;

class GetOrderAttributes
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param int $storeId
     * @return Attribute[]
     */
    public function execute(int $storeId): array
    {
        $collectionFactory = $this->objectManager->get(CollectionFactory::class);

        /** @var Collection $collection */
        $collection = $collectionFactory->create();

        if ($storeId !== Field::DEFAULT_STORE_ID) {
            $collection->addStoreFilter($storeId);
        }

        return $collection->getItems();
    }
}
