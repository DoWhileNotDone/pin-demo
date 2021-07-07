<?php

namespace Demo\Validate;

use Demo\Model\Pin;

interface Validation
{
    public function validate(Pin $pin): bool;
}
