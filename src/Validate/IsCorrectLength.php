<?php

namespace Demo\Validate;

use Demo\Model\Pin;

class IsCorrectLength implements Validation
{
    public function validate(Pin $pin): bool
    {
        return strlen((string) $pin->getPin()) === 4;
    }
}
