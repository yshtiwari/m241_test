<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_Base
*/

declare(strict_types=1);

namespace Amasty\Base\Console\Command;

use Amasty\Base\Model\SysInfo\Command\LicenceService\SendSysInfo as CommandSendSysInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendSysInfo extends Command
{
    /**
     * @var CommandSendSysInfo
     */
    private $sendSysInfo;

    public function __construct(
        CommandSendSysInfo $sendSysInfo,
        string $name = null
    ) {
        parent::__construct($name);
        $this->sendSysInfo = $sendSysInfo;
    }

    protected function configure()
    {
        $this->setName('amasty-base:licence:send-sys-info');
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->sendSysInfo->execute();
    }
}
