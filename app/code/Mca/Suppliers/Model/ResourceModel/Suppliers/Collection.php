<?php
namespace Mca\Suppliers\Model\ResourceModel\Suppliers;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mca\Suppliers\Model\Suppliers', 'Mca\Suppliers\Model\ResourceModel\Suppliers');
    }
}