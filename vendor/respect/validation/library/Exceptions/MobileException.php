<?php
namespace Respect\Validation\Exceptions;

class MobileException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} must be a right mobile number',
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} must not be a right mobile number',
        ),
    );
}
