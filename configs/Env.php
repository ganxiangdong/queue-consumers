<?php
namespace Configs;

/**
 * 环境配置文件
 * 主机名称规则 key为正则，如果没匹配上，则当前主机名表示其运行环境
 * 如果是多台服务器，服务器名称最好是有规律的，直接用正则可搞定
 * 如有server-1,server-2,..，台服务是正式的，则直接配置 '/^server-\d+$/' => 'produce'
 * Class Env
 * @package Configs
 */
class Env
{
    public static $rule = [
        //生产环境
        '/^haioo-app\d+$/' => 'produce',
        
        //本地环境
        '/^dev$/' => 'dev',
        
        //测试环境
        '/^haioo_test$/' => 'test'
    ];
}