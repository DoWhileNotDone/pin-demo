<?php

namespace Demo\Tests\Unit\Validate;

use PHPUnit\Framework\TestCase;
use Demo\Model\Pin;
use Demo\Validate\IsUnique;

final class IsUniqueTest extends TestCase
{
    private IsUnique $subject;

    protected function setUp(): void
    {
        $this->subject = new IsUnique();
    }

    /**
     * @dataProvider param_provider
     *
     * @return void
     */
    public function testValidatesPinUnique(bool $expects): void
    {
        $pin = $this->createMock(Pin::class);

        $pin->expects($this->once())
            ->method('isUnique')
            ->willReturn($expects);

        $this->assertEquals(
            $this->subject->validate($pin),
            $expects,
        );
    }

    public function param_provider(): array
    {
        return [
            'truthy' => [
                true,
            ],
            'falsy' => [
                false,
            ],
        ];
    }
}
