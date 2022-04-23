<?php

namespace Mca\Suppliers\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Suppliers extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Mca\Suppliers\Model\ResourceModel\Suppliers');
    }
}