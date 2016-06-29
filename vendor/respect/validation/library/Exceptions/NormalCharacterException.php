<?php
namespace Respect\Validation\Exceptions;

class NormalCharacterException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} must be a right normal character',
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} must not be a right normal character',
        ),
    );
}
