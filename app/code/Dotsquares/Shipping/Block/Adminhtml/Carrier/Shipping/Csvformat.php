<?php
namespace Dotsquares\Shipping\Block\Adminhtml\Carrier\Shipping;

class Csvformat extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $websiteId; 

	protected $conditionName;

	protected $conditiontype;

	protected $collectionFactory;

    
	public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Dotsquares\Shipping\Model\ResourceModel\Carrier\Shipping\CollectionFactory $collectionFactory,
        \Dotsquares\Shipping\Model\Config\Source\Conditiontype $conditiontype,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->conditiontype = $conditiontype;
        parent::__construct($context, $backendHelper, $data);
    }

	protected function _construct()
    {
        parent::_construct();
        $this->setId('customshippingGrid');
        $this->_exportPageSize = 1000;
    }

    public function setWebsiteId($websiteId)
    {
        $this->websiteId = $this->_storeManager->getWebsite($websiteId)->getId();
        return $this;
    }

    public function getWebsiteId()
    {
        if ($this->websiteId === null) {
            $this->websiteId = $this->_storeManager->getWebsite()->getId();
        }
        return $this->websiteId;
    }

    public function setConditionName($name)
    {
        $this->conditionName = $name;
        return $this;
    }

    public function getConditionName()
    {
        if($this->conditionName){
			return $this->conditionName;
		}else{
			return 'package_weight';
		}
    }

    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->setConditionFilter($this->getConditionName())->setWebsiteFilter($this->getWebsiteId());

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
		$this->addColumn(
            'dest_country',
            ['header' => __('Country'), 'index' => 'dest_country', 'default' => '*']
        );

        $this->addColumn(
            'dest_region',
            ['header' => __('Region/State'), 'index' => 'dest_region', 'default' => '*']
        );
        $this->addColumn(
            'dest_city',
            ['header' => __('City'), 'index' => 'dest_city', 'default' => '*']
        );
        $this->addColumn(
            'dest_zip',
            ['header' => __('Zip/Postal Code From'), 'index' => 'dest_zip', 'default' => '*']
        );
        $this->addColumn(
            'dest_zip_to',
            ['header' => __('Zip/Postal Code To'), 'index' => 'dest_zip_to', 'default' => '*']
        );
        $label = $this->conditiontype->getCode('condition_name_short', $this->getConditionName());
        $this->addColumn(
            'condition_from_value',
            ['header' => $label.__('>'), 'index' => 'condition_from_value']
        );
        $this->addColumn(
            'condition_to_value',
            ['header' => $label.__('<='), 'index' => 'condition_to_value']
        );
        $this->addColumn('price', ['header' => __('Shipping Price'), 'index' => 'price']);
        $this->addColumn(
            'shipping_method',
            ['header' => __('Shipping Method'), 'index' => 'shipping_method']
        );
        return parent::_prepareColumns();
    }
}
