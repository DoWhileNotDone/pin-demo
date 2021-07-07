<?php

namespace Demo\Validate;

use Demo\Model\Pin;

class IsNotObvious implements Validation
{
    public function validate(Pin $pin): bool
    {
        $digits = str_split($pin->getPin());
        //Need at least three unique digits
        if (count(array_unique($digits)) < 3) {
            return false;
        };
        //Forward sequences of three numbers are invalid, e.g 9123, 5670
        $forward_sequence_count = 1;
        //Reverse sequences of three numbers are invalid, e.g 9872, 4321
        $reverse_sequence_count = 1;
        $last_in_sequence = null;
        foreach ($digits as $digit) {
            //Digits are strings, so need to be cast
            $int = (int) $digit;
            if ($last_in_sequence !== null) {
                if ($int === ($last_in_sequence + 1)) {
                    $forward_sequence_count++;
                }
                if ($int === ($last_in_sequence - 1)) {
                    $reverse_sequence_count++;
                }
            }
            $last_in_sequence = $int;
        }

        if ($forward_sequence_count >= 3) {
            return false;
        }

        if ($reverse_sequence_count >= 3) {
            return false;
        }

        return true;
    }
}
