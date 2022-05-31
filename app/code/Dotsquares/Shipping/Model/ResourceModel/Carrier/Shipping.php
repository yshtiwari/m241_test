<?php
namespace Dotsquares\Shipping\Model\ResourceModel\Carrier;

use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DirectoryList;

class Shipping 
{
    public function __construct(
        \Dotsquares\Shipping\Model\ResourceModel\Carrier\Shippingmethod $shippingmethod,
        \Dotsquares\Shipping\Model\ResourceModel\Carrier\Shippingruleimports $shippingruleimports
    ) {
        $this->shippingmethod = $shippingmethod;
        $this->shippingruleimports = $shippingruleimports;
    }

    
    public function Shippingrates($request)
    {
        return $this->shippingmethod->getshippingrules($request);   
    }
	
    public function Import(\Magento\Framework\DataObject $object)
    {
       $this->shippingruleimports->imports($object);
    }
}
