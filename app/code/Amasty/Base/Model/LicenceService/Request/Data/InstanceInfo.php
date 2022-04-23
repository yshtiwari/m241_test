<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_Base
*/

declare(strict_types=1);

namespace Amasty\Base\Model\LicenceService\Request\Data;

use Amasty\Base\Model\LicenceService\Request\Data\InstanceInfo\Platform;
use Amasty\Base\Model\SimpleDataObject;
use Magento\Framework\Api\ExtensibleDataInterface;

class InstanceInfo extends SimpleDataObject implements ExtensibleDataInterface
{
    public const SYSTEM_INSTANCE_KEY = 'system_instance_key';
    public const MODULES = 'modules';
    public const DOMAINS = 'domains';
    public const PLATFORM = 'platform';

    /**
     * @param string|null $systemInstanceKey
     * @return $this
     */
    public function setSystemInstanceKey(?string $systemInstanceKey): self
    {
        return $this->setData(self::SYSTEM_INSTANCE_KEY, $systemInstanceKey);
    }

    /**
     * @return string|null
     */
    public function getSystemInstanceKey(): ?string
    {
        return $this->getData(self::SYSTEM_INSTANCE_KEY);
    }

    /**
     * @param \Amasty\Base\Model\LicenceService\Request\Data\InstanceInfo\Module[]|null $modules
     * @return $this
     */
    public function setModules(array $modules): self
    {
        return $this->setData(self::MODULES, $modules);
    }

    /**
     * @return \Amasty\Base\Model\LicenceService\Request\Data\InstanceInfo\Module[]|null
     */
    public function getModules(): ?array
    {
        return $this->getData(self::MODULES);
    }

    /**
     * @param \Amasty\Base\Model\LicenceService\Request\Data\InstanceInfo\Domain[]|null $domains
     * @return $this
     */
    public function setDomains(array $domains): self
    {
        return $this->setData(self::DOMAINS, $domains);
    }

    /**
     * @return \Amasty\Base\Model\LicenceService\Request\Data\InstanceInfo\Domain[]|null
     */
    public function getDomains(): ?array
    {
        return $this->getData(self::DOMAINS);
    }

    /**
     * @param \Amasty\Base\Model\LicenceService\Request\Data\InstanceInfo\Platform $platform
     * @return $this
     */
    public function setPlatform(Platform $platform): self
    {
        return $this->setData(self::PLATFORM, $platform);
    }

    /**
     * @return \Amasty\Base\Model\LicenceService\Request\Data\InstanceInfo\Platform
     */
    public function getPlatform(): Platform
    {
        return $this->getData(self::PLATFORM);
    }
}
