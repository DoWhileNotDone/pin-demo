<?php

namespace Demo\Tests\Unit\Validate;

use PHPUnit\Framework\TestCase;
use Demo\Model\Pin;
use Demo\Validate\IsCorrectLength;

final class IsCorrectLengthTest extends TestCase
{
    private IsCorrectLength $subject;

    protected function setUp(): void
    {
        $this->subject = new IsCorrectLength();
    }

    /**
     * @dataProvider param_provider
     *
     * @return void
     */
    public function testValidatesPinIsCorrectLength(int $number, bool $expects): void
    {
        $pin = $this->createMock(Pin::class);

        $pin->expects($this->once())
            ->method('getPin')
            ->willReturn($number);

        $this->assertEquals(
            $this->subject->validate($pin),
            $expects,
        );
    }

    public function param_provider(): array
    {
        return [
            '3 is not good' => [
                123,
                false,
            ],
            '4 is good' => [
                1234,
                true,
            ],
            '5 is not good' => [
                12345,
                false,
            ],
        ];
    }
}
