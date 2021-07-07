<?php

namespace Demo\Tests\Unit\Validate;

use PHPUnit\Framework\TestCase;
use Demo\Model\Pin;
use Demo\Validate\IsNotObvious;

final class IsNotObviousTest extends TestCase
{
    private IsNotObvious $subject;

    protected function setUp(): void
    {
        $this->subject = new IsNotObvious();
    }

    /**
     * @dataProvider param_provider
     *
     * @return void
     */
    public function testValidatesPinIsNotObvious(int $number, bool $expects): void
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
            '1456 is invalid as 456 is in forward sequence' => [
                1456,
                false,
            ],
            '9919 is invalid as not enough unique digits' => [
                9919,
                false,
            ],
            '9999 is invalid as not enough unique digits' => [
                9999,
                false,
            ],
            '1376 is valid' => [
                1376,
                true,
            ],
            '9876 is not valid as it is in reverse sequence' => [
                9876,
                false,
            ],
            '3210 is not valid as it is in reverse sequence' => [
                3210,
                false,
            ],

        ];
    }
}
