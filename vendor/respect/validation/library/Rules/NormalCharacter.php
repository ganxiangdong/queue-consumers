<?php
namespace Respect\Validation\Rules;

/**
 * 正常字符 （字母数字汉字）
 */
class NormalCharacter extends AbstractRule
{
    public function validate($input)
    {
        if (strlen($input) == 0) {
            return false;
        }
        if (preg_match("/^[A-Za-z0-9\x{4e00}-\x{9fa5}]+$/u", $input)) {
            return true;
        }
        return false;
    }
}
