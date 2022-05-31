<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/


namespace Amasty\CheckoutCore\Model\Utils;

use Magento\Framework\DataObject;

/**
 * Util for getting list of values from DataObject
 * and setting it back
 */
class DataObjectDataBackup
{
    /**
     * @param DataObject $object
     * @param array $keys
     * @return array
     */
    public function backupData($object, $keys)
    {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $object->getData($key);
        }

        return $data;
    }

    /**
     * @param DataObject $object
     * @param array $values
     */
    public function restoreData($object, $values)
    {
        $object->addData($values);
    }
}
