<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/

declare(strict_types=1);

namespace Amasty\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\Processor;

use Amasty\CheckoutCore\Model\Field;
use Amasty\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\SaveConfigValue;
use Amasty\CheckoutCore\Model\Field\ConfigManagement\YesNoOptions;

class YesNo implements ProcessorInterface
{
    /**
     * @var SaveConfigValue
     */
    private $saveConfigValue;

    public function __construct(SaveConfigValue $saveConfigValue)
    {
        $this->saveConfigValue = $saveConfigValue;
    }

    public function execute(Field $field, string $configPath): void
    {
        $this->saveConfigValue->execute(
            $configPath,
            $field->isEnabled() ? YesNoOptions::VALUE_YES : YesNoOptions::VALUE_NO
        );
    }
}
