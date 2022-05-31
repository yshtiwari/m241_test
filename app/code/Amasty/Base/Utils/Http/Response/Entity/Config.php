<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_Base
*/

declare(strict_types=1);

namespace Amasty\Base\Utils\Http\Response\Entity;

use Magento\Framework\DataObject;

class Config extends DataObject
{
    public const CLASS_NAME = 'class_name';
    public const TYPE = 'type';
    public const DATA_PROCESSOR = 'data_processor';

    public function getClassName(): string
    {
        return $this->getData(self::CLASS_NAME);
    }

    public function getType(): ?string
    {
        return $this->getData(self::TYPE);
    }

    public function getDataProcessor(): ?DataProcessorInterface
    {
        return $this->getData(self::DATA_PROCESSOR);
    }
}
