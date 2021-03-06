<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\InventorySales\Model\ResourceModel\IsStockItemSalableCondition;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Select;
use Magento\Framework\Exception\LocalizedException;

/**
 * Chain of stock item salable conditions.
 */
class IsStockItemSalableConditionChain implements GetIsStockItemSalableConditionInterface
{
    /**
     * @var GetIsStockItemSalableConditionInterface[]
     */
    private $conditions = [];

    /**
     * @var GetIsStockItemSalableConditionInterface[]
     */
    private $requiredConditions = [];

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
     * @param array $conditions
     * @param array $requiredConditions
     * @throws LocalizedException
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        array $conditions = [],
        array $requiredConditions = []
    ) {
        foreach ($conditions as $getIsSalableCondition) {
            if (!$getIsSalableCondition instanceof GetIsStockItemSalableConditionInterface) {
                throw new LocalizedException(
                    __('Condition must implement %1', GetIsStockItemSalableConditionInterface::class)
                );
            }
        }
        foreach ($requiredConditions as $getIsSalableCondition) {
            if (!$getIsSalableCondition instanceof GetIsStockItemSalableConditionInterface) {
                throw new LocalizedException(
                    __('Condition must implement %1', GetIsStockItemSalableConditionInterface::class)
                );
            }
        }
        $this->resourceConnection = $resourceConnection;
        $this->conditions = $conditions;
        $this->requiredConditions = $requiredConditions;
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(Select $select): string
    {
        if (empty($this->conditions)) {
            return '1';
        }

        $conditionStrings = [];
        foreach ($this->conditions as $condition) {
            $conditionString = $condition->execute($select);
            if ('' !== trim($conditionString)) {
                $conditionStrings[] = $conditionString;
            }
        }

        if (empty($this->requiredConditions)) {
            $isSalableString = '(' . implode(') OR (', $conditionStrings) . ')';
        } else {
            $requiredConditionsStrings = [];
            foreach ($this->requiredConditions as $requiredCondition) {
                $requiredConditionString = $requiredCondition->execute($select);
                if ('' !== trim($requiredConditionString)) {
                    $requiredConditionsStrings[] = $requiredConditionString;
                }
            }
            $isSalableString = '(' . implode(') AND (', $requiredConditionsStrings) . ')'
                . ' AND ((' . implode(') OR (', $conditionStrings) . '))';
        }

        return (string)$this->resourceConnection->getConnection()->getCheckSql($isSalableString, 1, 0);
    }
}
