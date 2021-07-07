<?php

namespace Demo\Controller;

use Demo\Database\DB;
use Demo\Exceptions\NotFoundException;
use Demo\Model\Pin;
use Demo\Validate\IsCorrectLength;
use Demo\Validate\IsUnique;
use Demo\Validate\IsNotObvious;

final class PinController
{
    public function handleRequest(): string
    {
        $valid = false;
        $attempts = 0;
    
        do {
            $pin = new Pin(DB::get());

            $pin->setPin($pin->generate());

            $valid = $pin->validate(
                [
                    new IsCorrectLength(),
                    new IsUnique(),
                    new IsNotObvious(),
                ]
            );
            $attempts++;
        } while ($attempts <= 100 && $valid === false);

        if ($valid === false) {
            throw new NotFoundException();
        }

        $pin->store();
        return $pin;
    }
}
