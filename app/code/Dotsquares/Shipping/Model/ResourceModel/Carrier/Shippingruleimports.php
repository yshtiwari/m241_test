<?php
namespace Dotsquares\Shipping\Model\ResourceModel\Carrier;

use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DirectoryList;

class Shippingruleimports extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $importWebsiteId = 0;
    protected $importErrors = [];
    protected $importedRows = 0;
    protected $importUniqueHash = [];
    protected $importIso2Countries;
    protected $importIso3Countries;
    protected $importRegions;
    protected $importConditionName;
	protected $conditionFullNames = [];
    protected $coreConfig;
	protected $logger;
    protected $storeManager;
    protected $conditiontype;
    protected $countryCollectionFactory;
    protected $regionCollectionFactory;
    private $readFactory;
    protected $filesystem;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\Config\ScopeConfigInterface $coreConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Dotsquares\Shipping\Model\Carrier\Condition $conditiontype,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory,
        \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory,
        \Magento\Framework\Filesystem $filesystem,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->coreConfig = $coreConfig;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->conditiontype = $conditiontype;
        $this->countryCollectionFactory = $countryCollectionFactory;
        $this->regionCollectionFactory = $regionCollectionFactory;
        $this->readFactory = $readFactory;
        $this->filesystem = $filesystem;
    }

    protected function _construct()
    {
        $this->_init('dotsquares_shipping', 'id');
    }
	
    public function imports($object)
    {
		$importcsv_FieldData = $object->getFieldsetDataValue('import');
        if (empty($importcsv_FieldData['tmp_name'])) {
            return $this;
        }
        $website = $this->storeManager->getWebsite($object->getScopeId());
        $csvFile = $importcsv_FieldData['tmp_name'];
		$this->import_WebsiteId = (int)$website->getId();
        $this->csvimport_UniqueHash = [];
        $this->importcsv_Errors = [];
        $this->importedRows = 0;

        $tmpDirectory = ini_get('upload_tmp_dir')? $this->readFactory->create(ini_get('upload_tmp_dir'))
            : $this->filesystem->getDirectoryRead(DirectoryList::SYS_TMP);
		$path = $tmpDirectory->getRelativePath($csvFile);
        $csvdata = $tmpDirectory->openFile($path);
		$headers = $csvdata->readCsv();
		if ($headers === false || count($headers) < 5) {
            $csvdata->close();
            throw new \Magento\Framework\Exception\LocalizedException(__('Please Correct Shipping Rates File Format.'));
        }

        if ($object->getData('groups/dotsquares/fields/condition_type/inherit') == '1') {
            $conditionName = (string)$this->coreConfig->getValue('carriers/dotsquares/condition_type', 'default');
        } else {
            $conditionName = $object->getData('groups/dotsquares/fields/condition_type/value');
        }
		
        $this->importConditionName = $conditionName;
		
        $connection = $this->getConnection();
        $connection->beginTransaction();
		try {
            $rowNumber = 1;
            $importData = [];

            $this->_loadDirectoryCountries();
            $this->_loadDirectoryRegions();

            $condition = [
                'website_id = ?' => $this->import_WebsiteId,
                'condition_name = ?' => $this->importConditionName,
            ];
            $connection->delete($this->getMainTable(), $condition);

            while (false !== ($csvLine = $csvdata->readCsv())) {
                
				$rowNumber++;

                if (empty($csvLine)) {
                    continue;
                }
				
				$row = $this->_getImportRow($csvLine, $rowNumber);
				
				if ($row !== false) {
                    $importData[] = $row;
                }

                if (count($importData) == 1000) {
                    $this->_saveImportData($importData);
                    $importData = [];
                }
            }
			$check_data = $this->_duplication($importData);
			$this->_saveImportData($importData);
            $csvdata->close();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $connection->rollback();
            $csvdata->close();
            throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
        } catch (\Exception $e) {
            $connection->rollback();
            $csvdata->close();
            $this->logger->critical($e);
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Something went wrong while importing matrix rates.')
            );
        }
        $connection->commit();
        if ($this->importcsv_Errors) {
            $error = __(
                'We couldn\'t import this file because of these errors: %1',
                implode(" \n", $this->importcsv_Errors)
            );
            throw new \Magento\Framework\Exception\LocalizedException($error);
        }
        return $this;
    }

    protected function _duplication($importrows)
    {
		$check = array();
		$i = 1;
		foreach($importrows as $row){
			$key = $row[1].'-'.$row[2].'-'.$row[3].'-'.$row[4].'-'.$row[5].'-'.$row[6].'-'.$row[7].'-'.$row[8];
			if(array_key_exists($key, $check)){
				throw new \Magento\Framework\Exception\LocalizedException(__("Please don't use duplicate values."));
			}else{
				$check[$key] = $i;
				$i++;
			}
		}
	}
	
    protected function _loadDirectoryCountries()
    {
        if ($this->importIso2Countries !== null && $this->importIso3Countries !== null) {
            return $this;
        }

        $this->importIso2Countries = [];
        $this->importIso3Countries = [];

        $collection = $this->countryCollectionFactory->create();
        foreach ($collection->getData() as $row) {
            $this->importIso2Countries[$row['iso2_code']] = $row['country_id'];
            $this->importIso3Countries[$row['iso3_code']] = $row['country_id'];
        }

        return $this;
    }

    protected function _loadDirectoryRegions()
    {
        if ($this->importRegions !== null) {
            return $this;
        }

        $this->importRegions = [];

        $collection = $this->regionCollectionFactory->create();
        foreach ($collection->getData() as $row) {
            $this->importRegions[$row['country_id']][$row['code']] = (int)$row['region_id'];
        }

        return $this;
    }

    protected function getConditionFullName($conditionName)
    {
        if (!isset($this->conditionFullNames[$conditionName])) {
            $name = $this->conditiontype->getCode('condition_name', $conditionName);
            $this->conditionFullNames[$conditionName] = $name;
        }

        return $this->conditionFullNames[$conditionName];
    }

    protected function _getImportRow($row, $rowNumber = 0)
    {
		if (count($row) < 9) {
            $this->importcsv_Errors[] =
                __('Please correct Matrix Rates format in Row #%1. Invalid Number of Rows', $rowNumber);
            return false;
        }
        foreach ($row as $k => $v) {
            $row[$k] = trim($v);
        }
		
        if (isset($this->importIso2Countries[$row[0]])) {
            $countryId = $this->importIso2Countries[$row[0]];
        } elseif (isset($this->importIso3Countries[$row[0]])) {
            $countryId = $this->importIso3Countries[$row[0]];
        } elseif ($row[0] == '*' || $row[0] == '') {
            $countryId = '0';
        } else {
            $this->importcsv_Errors[] = __('Please correct Country "%1" in Row #%2.', $row[0], $rowNumber);
            return false;
        }
		

        if ($countryId != '0' && isset($this->importRegions[$countryId][$row[1]])) {
            $regionId = $this->importRegions[$countryId][$row[1]];
        } elseif ($row[1] == '*' || $row[1] == '') {
            $regionId = 0;
        } else {
            $this->importcsv_Errors[] = __('Please correct Region/State "%1" in Row #%2.', $row[1], $rowNumber);
            return false;
        }

        if ($row[2] == '*' || $row[2] == '') {
            $city = '*';
        } else {
            $city = $row[2];
        }

        if ($row[3] == '*' || $row[3] == '') {
            $zipCode = '*';
        } else {
            $zipCode = $row[3];
        }

        if ($row[4] == '*' || $row[4] == '') {
            $zip_to = '*';
        } else {
            $zip_to = $row[4];
        }
		
		$valueFrom = $row[5] == '*' ? -1 : $this->_DecimalValue($row[5]);
        if ($valueFrom === false) {
            $this->importcsv_Errors[] = __(
                'Please correct %1 From "%2" in Row #%3.',
                $this->getConditionFullName($this->importConditionName),
                $row[5],
                $rowNumber
            );
            return false;
        }
		
		$valueTo = $row[6] == '*' ? $row[6] :$this->_DecimalValue($row[6]);
		
		if ($valueTo === false) {
            $this->importcsv_Errors[] = __(
                'Please correct %1 To "%2" in Row #%3.',
                $this->getConditionFullName($this->importConditionName),
                $row[6],
                $rowNumber
            );
            return false;
        }

        $price = $this->_DecimalValue($row[7]);
        if ($price === false) {
            $this->importcsv_Errors[] = __('Please correct Shipping Price "%1" in Row #%2.', $row[7], $rowNumber);
            return false;
        }

        if ($row[8] == '*' || $row[8] == '') {
            $this->importcsv_Errors[] = __('Please correct Shipping Method "%1" in Row #%2.', $row[8], $rowNumber);
            return false;
        } else {
            $shippingMethod = $row[8];
        }

        $unique_hash = sprintf(
            "%s-%d-%s-%s-%F-%F-%s",
            $countryId,
            $city,
            $regionId,
            $zipCode,
            $valueFrom,
            $valueTo,
            $shippingMethod
        );
		if (isset($this->csvimport_UniqueHash[$unique_hash])) {
			$this->importcsv_Errors[] = __(
                'Duplicate Row #%1 (Country "%2", Region/State "%3", City "%4", Zip from "%5", Zip to "%6", From Value "%7", To Value "%8", and Shipping Method "%9")',
                $rowNumber,
                $row[0],
                $row[1],
                $city,
                $zipCode,
                $zip_to,
                $valueFrom,
                $valueTo,
                $shippingMethod
            );
            return false;
        }
        $this->csvimport_UniqueHash[$unique_hash] = true;
		
		return [
            $this->import_WebsiteId,    
            $countryId,
            $regionId,
            $city,
            $zipCode,
            $zip_to,
            $this->importConditionName,
            $valueFrom,
            $valueTo,
            $price,
            $shippingMethod
        ];
    }

    protected function _saveImportData(array $data)
    {
		if (!empty($data)) {
            $columns = [
                'website_id',
                'dest_country_id',
                'dest_region_id',
                'dest_city',
                'dest_zip',
                'dest_zip_to',
                'condition_name',
                'condition_from_value',
                'condition_to_value',
                'price',
                'shipping_method',
            ];
            $this->getConnection()->insertArray($this->getMainTable(), $columns, $data);
            $this->importedRows += count($data);
        }

        return $this;
    }

    protected function _DecimalValue($value)
    {
        if (!is_numeric($value)) {
            return false;
        }
        $value = (double)sprintf('%.4F', $value);
        if ($value < 0.0000) {
            return false;
        }
        return $value;
    }
}
