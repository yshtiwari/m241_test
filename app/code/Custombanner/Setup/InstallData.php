<?php

namespace Dotsquares\Custombanner\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        if (version_compare($context->getVersion(), '1.0.0') < 0){





		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'startdate');

		
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'startdate', [
                        'type' => 'datetime',
                        'label' => 'Start Date',
                        'input' => 'date',
                        'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
						'required' => false,
                        'sort_order' => 160,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                        'group' => 'General Information',
						"default" => "",
						"class"    => "",
						"note"       => "Please select start Date"
			]
			);
					

	

		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'enddate');

		
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'enddate', [
                        'type' => 'datetime',
                        'label' => 'End Date',
                        'input' => 'date',
                        'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
						'required' => false,
                        'sort_order' => 161,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                        'group' => 'General Information',
						"default" => "",
						"class"    => "",
						"note"       => "Please select end date"
			]
			);
					

	



		}

    }
}