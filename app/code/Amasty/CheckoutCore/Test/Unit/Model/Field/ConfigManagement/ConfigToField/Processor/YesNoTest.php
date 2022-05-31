<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/

declare(strict_types=1);

namespace Amasty\CheckoutCore\Test\Unit\Model\Field\ConfigManagement\ConfigToField\Processor;

use Amasty\CheckoutCore\Model\Field\ConfigManagement\ConfigToField\Processor\YesNo;
use Amasty\CheckoutCore\Model\Field\ConfigManagement\UpdateDefaultField;
use Amasty\CheckoutCore\Model\Field\ConfigManagement\UpdateFieldsByWebsiteId;
use Amasty\CheckoutCore\Model\Field\ConfigManagement\YesNoOptions;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @see YesNo
 * @covers YesNo::execute
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class YesNoTest extends \PHPUnit\Framework\TestCase
{
    private const ATTRIBUTE_ID = 1;
    private const WEBSITE_ID = 1;

    /**
     * @var UpdateDefaultField|MockObject
     */
    private $updateDefaultFieldMock;

    /**
     * @var UpdateFieldsByWebsiteId|MockObject
     */
    private $updateFieldsByWebsiteIdMock;

    /**
     * @var YesNo
     */
    private $subject;

    protected function setUp(): void
    {
        $this->updateDefaultFieldMock = $this->createMock(UpdateDefaultField::class);
        $this->updateFieldsByWebsiteIdMock = $this->createMock(UpdateFieldsByWebsiteId::class);

        $this->subject = new YesNo(
            $this->updateDefaultFieldMock,
            $this->updateFieldsByWebsiteIdMock
        );
    }

    /**
     * @param int|null $websiteId
     * @dataProvider executeWithUnexpectedValueDataProvider
     */
    public function testExecuteWithUnexpectedValue(?int $websiteId): void
    {
        $value = 'unexpected_value';
        $this->updateDefaultFieldMock->expects($this->never())->method('execute');
        $this->updateFieldsByWebsiteIdMock->expects($this->never())->method('execute');
        $this->subject->execute(self::ATTRIBUTE_ID, $value, $websiteId);
    }

    /**
     * @param string $value
     * @param bool $expectedIsEnabled
     * @param bool $expectedIsRequired
     * @dataProvider executeDataProvider
     */
    public function testExecuteWithDefaultScope(
        string $value,
        bool $expectedIsEnabled,
        bool $expectedIsRequired
    ): void {
        $this->updateDefaultFieldMock
            ->expects($this->once())
            ->method('execute')
            ->with(self::ATTRIBUTE_ID, $expectedIsEnabled, $expectedIsRequired);

        $this->updateFieldsByWebsiteIdMock->expects($this->never())->method('execute');
        $this->subject->execute(self::ATTRIBUTE_ID, $value, null);
    }

    /**
     * @param string $value
     * @param bool $expectedIsEnabled
     * @param bool $expectedIsRequired
     * @dataProvider executeDataProvider
     */
    public function testExecuteWithWebsiteScope(
        string $value,
        bool $expectedIsEnabled,
        bool $expectedIsRequired
    ): void {
        $this->updateFieldsByWebsiteIdMock
            ->expects($this->once())
            ->method('execute')
            ->with(self::ATTRIBUTE_ID, self::WEBSITE_ID, $expectedIsEnabled, $expectedIsRequired);

        $this->updateDefaultFieldMock->expects($this->never())->method('execute');
        $this->subject->execute(self::ATTRIBUTE_ID, $value, self::WEBSITE_ID);
    }

    public function executeWithUnexpectedValueDataProvider(): array
    {
        return [[null], [self::WEBSITE_ID]];
    }

    public function executeDataProvider(): array
    {
        return [
            [YesNoOptions::VALUE_NO, false, false],
            [YesNoOptions::VALUE_YES, true, false]
        ];
    }
}
