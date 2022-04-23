<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/

declare(strict_types=1);

namespace Amasty\CheckoutCore\Model\Field\ConfigManagement\ConfigToAttribute\Processor;

use Amasty\CheckoutCore\Model\Field\ConfigManagement\CustomerAttributes\UpdateAttribute;
use Magento\Config\Model\Config\Source\Nooptreq;
use Magento\Customer\Model\Attribute;

class NoOptionalRequired implements ProcessorInterface
{
    /**
     * @var UpdateAttribute
     */
    private $updateAttribute;

    public function __construct(UpdateAttribute $updateAttribute)
    {
        $this->updateAttribute = $updateAttribute;
    }

    public function execute(Attribute $attribute, string $value, int $websiteId): void
    {
        $this->updateAttribute->execute(
            $attribute,
            $value !== Nooptreq::VALUE_NO,
            $value === Nooptreq::VALUE_REQUIRED,
            $websiteId
        );
    }
}
