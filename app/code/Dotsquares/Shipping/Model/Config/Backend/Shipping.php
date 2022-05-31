<?php
namespace Dotsquares\Shipping\Model\Config\Backend;

use Magento\Framework\Model\AbstractModel;

class Shipping extends \Magento\Framework\App\Config\Value
{
    protected $shippingFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Dotsquares\Shipping\Model\ResourceModel\Carrier\ShippingFactory $shippingFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->shippingFactory = $shippingFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function afterSave()
    {
        $shippingRate = $this->shippingFactory->create();
        $shippingRate->uploadAndImport($this);
        return parent::afterSave();
    }
}
