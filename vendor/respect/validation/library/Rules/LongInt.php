<?php
namespace Respect\Validation\Rules;

class LongInt extends AbstractRule
{
    public function validate($input)
    {
        if (is_numeric($input) && $input > 0 && !strpos((string)$input,'.')) {
            return true;
        }
        return false;
    }
}
