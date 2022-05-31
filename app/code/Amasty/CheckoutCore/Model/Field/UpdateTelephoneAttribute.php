<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/

declare(strict_types=1);

namespace Amasty\CheckoutCore\Model\Field;

use Amasty\CheckoutCore\Model\Config;
use Magento\Customer\Model\Attribute;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as AttributeResource;
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class UpdateTelephoneAttribute
{
    /**
     * @var AttributeResource
     */
    private $attributeResource;

    /**
     * @var Config
     */
    private $configProvider;

    public function __construct(
        AttributeResource $attributeResource,
        Config $configProvider
    ) {
        $this->attributeResource = $attributeResource;
        $this->configProvider = $configProvider;
    }

    /**
     * @param Attribute $attribute
     * @throws AlreadyExistsException
     * @throws \Exception
     */
    public function execute(Attribute $attribute): void
    {
        $this->configProvider->saveTelephoneOption('');
        $attribute->setIsRequired(false);
        $this->attributeResource->save($attribute);
    }
}
