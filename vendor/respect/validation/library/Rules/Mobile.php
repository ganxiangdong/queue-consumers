<?php
namespace Respect\Validation\Rules;

class Mobile extends AbstractRule
{
    public function validate($mobile)
    {
        return  ctype_digit($mobile) && preg_match('/^1[3|4|5|7|8][0-9]\d{8}$/',$mobile);
    }
}
