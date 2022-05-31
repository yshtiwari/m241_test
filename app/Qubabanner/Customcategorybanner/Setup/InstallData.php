<?php

namespace Qubabanner\Customcategorybanner\Setup;

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
        if (version_compare($context->getVersion(), '1.0.1') < 0){
		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'bannerstartdate');
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'bannerstartdate', [
                'type' => 'datetime',
                'label' => 'Banner Start Date',
                'input' => 'date',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
				'required' => false,
                'sort_order' => 110,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General Information',
                'user_defined' => true,
				'class' => 'validate-date',
				"default" => "",
				"note" => ""
			]);						
		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'bannerenddate');		
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'bannerenddate', [
                'type' => 'datetime',
                'label' => 'Banner End Date',
                'input' => 'date',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
				'required' => false,
                'sort_order' => 120,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General Information',
                'user_defined' => true,
				'class' => 'validate-date',
				"default" => "",
				"note" => ""
			]);					
		}
    }
}