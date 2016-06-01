<?php
namespace Configs;

/**
 * RMQ队列配置文件
 * @package Configs
 */
class Rmq
{
    /**
     * 连接RMQ参数
     * @var array
     */
    public static $connect = [
        'addr' => '127.0.0.1',
        'port' => 5672,
        'user' => 'guest',
        'password' => 'guest',
        'vhost' => '/'
    ];
}