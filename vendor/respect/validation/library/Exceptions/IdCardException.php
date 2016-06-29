<?php
namespace Respect\Validation\Exceptions;

class IdCardException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} must be a right ID CARD',
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} must not be a right ID CARD',
        ),
    );
}
