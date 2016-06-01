<?php
namespace Configs;

/**
 * 数据库配置
 * @package Configs
 */
class Db
{
    /**
     * MySQL 连接配置
     * @var array
     */
    public static $mysql = [
        'driver' => 'mysql',
        'host' => '192.168.11.46',
        'database' => 'haiou',
        'username' => 'root',
        'password' => 'haiootest&!#*!$',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => 'haiou_',
    ];
}