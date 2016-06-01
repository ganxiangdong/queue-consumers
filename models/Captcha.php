<?php
namespace Models;

/**
 * 验证码表
 */
class Captcha extends \Libs\BaseModel
{
    protected $table = 'captcha';
    
    /**
     * 测试
     */
    public static function test()
    {
        $record = self::orderBy('id', 'desc')->first();
        $info = [];
        if (!is_null($record)) {
            $info = $record->toArray();
        }
        return $info;
    }
}