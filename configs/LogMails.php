<?php
namespace Configs;

/**
 * 紧急日志通知邮箱
 * @package Configs
 */
class LogMails
{
    /**
     * 发送配置
     * @var unknown
     */
    public static $sendConfig = [
        'host' => '',
        'port' => 25,
        'userName' => '',
        'password' => '',
        'subject' => '',
        'from' => ''
    ];
    
    /**
     * 邮箱列表
     * @var array
     */
    public static $mails = [
        'xxxxx@xxx.xxx'
    ];
}