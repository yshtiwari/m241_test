<?php

namespace Dotsquares\Shipping\Model\ResourceModel\Carrier;

use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DirectoryList;

class Shippingmethod extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Psr\Log\LoggerInterface $logger,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->logger = $logger;
    }
	
	protected function _construct()
    {
        $this->_init('dotsquares_shipping', 'id');
    }
  
    public function getshippingrules(\Magento\Quote\Model\Quote\Address\RateRequest $request)
    {
        $adapter = $this->getConnection();
        $shippingRules=[];
		$postcode = $request->getDestPostcode();
        $zipSearchString = " AND :postcode LIKE dest_zip ";
        for ($j=0; $j<8; $j++) {
            $select = $adapter->select()->from(
                $this->getMainTable()
            )->where(
                'website_id = :website_id'
            )->order(
                ['dest_country_id DESC', 'dest_region_id DESC', 'dest_zip DESC', 'condition_from_value DESC']
            );
            $shippingzoneWhere='';
            $bind=[];
            switch ($j) {
                case 0:
                   $shippingzoneWhere =  "dest_country_id = :country_id AND dest_region_id = :region_id AND STRCMP(LOWER(dest_city),LOWER(:city))= 0 " .$zipSearchString;
				   $bind = [
                        ':country_id' => $request->getDestCountryId(),
                        ':region_id' => (int)$request->getDestRegionId(),
                        ':city' => $request->getDestCity(),
                        ':postcode' => $request->getDestPostcode(),
                    ];
                    break;
                case 1:
                    $shippingzoneWhere =  "dest_country_id = :country_id AND dest_region_id = :region_id AND dest_city='' "
                        .$zipSearchString;
                    $bind = [
                        ':country_id' => $request->getDestCountryId(),
                        ':region_id' => (int)$request->getDestRegionId(),
                        ':postcode' => $request->getDestPostcode(),
                    ];
                    break;
                case 2:
                    $shippingzoneWhere = "dest_country_id = :country_id AND dest_region_id = :region_id AND STRCMP(LOWER(dest_city),LOWER(:city))= 0 AND dest_zip ='*'";
                    $bind = [
                        ':country_id' => $request->getDestCountryId(),
                        ':region_id' => (int)$request->getDestRegionId(),
                        ':city' => $request->getDestCity(),
                    ];
                    break;
                case 3:
                    $shippingzoneWhere =  "dest_country_id = :country_id AND dest_region_id = '0' AND STRCMP(LOWER(dest_city),LOWER(:city))= 0 AND dest_zip ='*'";
                    $bind = [
                        ':country_id' => $request->getDestCountryId(),
                        ':city' => $request->getDestCity(),
                    ];
                    break;
                case 4:
                    $shippingzoneWhere =  "dest_country_id = :country_id AND dest_region_id = '0' AND dest_city ='*' "
                        .$zipSearchString;
                    $bind = [
                        ':country_id' => $request->getDestCountryId(),
                        ':postcode' => $request->getDestPostcode(),
                    ];
                    break;
                case 5: // country, region
                    $shippingzoneWhere =  "dest_country_id = :country_id AND dest_region_id = :region_id  AND dest_city ='*' AND dest_zip ='*'";
                    $bind = [
                        ':country_id' => $request->getDestCountryId(),
                        ':region_id' => (int)$request->getDestRegionId(),
                    ];
                    break;
                case 6: // country
                    $shippingzoneWhere =  "dest_country_id = :country_id AND dest_region_id = '0' AND dest_city ='*' AND dest_zip ='*'";
                    $bind = [
                        ':country_id' => $request->getDestCountryId(),
                    ];
                    break;
                case 7: // nothing
                    $shippingzoneWhere =  "dest_country_id = '0' AND dest_region_id = '0' AND dest_city ='*' AND dest_zip ='*'";
                    break;
            }
            $select->where($shippingzoneWhere);
            $bind[':website_id'] = (int)$request->getWebsiteId();
            $bind[':condition_name'] = $request->getConditionMRName();
            $bind[':condition_value'] = $request->getData($request->getConditionMRName());
            $select->where('condition_name = :condition_name');
            $select->where('condition_from_value < :condition_value');
            $select->where('condition_to_value >= :condition_value');

			$this->logger->debug('SQL Select: ', $select->getPart('where'));
            $this->logger->debug('Bindings: ', $bind);		
            $results = $adapter->fetchAll($select, $bind);
			if (!empty($results)) {
                $this->logger->debug('SQL Results: ', $results);
                foreach ($results as $data) {
                    $shippingRules[]=$data;
                }
                break;
            }
        }
	    return $shippingRules;
    }
}