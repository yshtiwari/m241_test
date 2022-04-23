<?php namespace Mca\Suppliers\Model\ResourceModel;

class Suppliers extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected function _construct()
    {
        $this->_init('suppliers_items', 'id');
    }
}