<?php

namespace Demo\Validate;

use Demo\Model\Pin;

class IsUnique implements Validation
{
    public function validate(Pin $pin): bool
    {
        return $pin->isUnique();
    }
}
