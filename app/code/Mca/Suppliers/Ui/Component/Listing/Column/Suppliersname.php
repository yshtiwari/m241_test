<?php namespace Mca\Suppliers\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Shows product name in admin grids instead of product id
 */
class Suppliersname extends Column
{
    /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;

    /**
     * System store
     *
     * @var SystemStore
     */
    protected $systemStore;

    protected $productFactory;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
        \Magento\Eav\Model\Config $eavConfig,
        array $components = [],
        array $data = []
    ) {
        $this->_eavConfig = $eavConfig;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
			    $suppliers_name = $item['suppliers_name'];
			    $suppliername = $this->getOptionArray($suppliers_name);
				$item['suppliers_name'] = $suppliername;
            }
        }

        return $dataSource;
    }
	public function getOptionArray($suppliers_name)
    {
        $attributeCode = "manufacturer";
        $attribute = $this->_eavConfig->getAttribute('catalog_product', $attributeCode);
        $options = $attribute->getSource()->getAllOptions();
    	$option_arr = [];
        foreach ($options as $option) {
            if ($option['value'] == $suppliers_name) {
                return $option['label'];
            }
        }
    }
}