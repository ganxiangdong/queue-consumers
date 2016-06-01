<?php
/**
 * 初使化程序
 */

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//生成根目录路径常量
define('ROOT_PATH', __DIR__);

//引入composer自动加载 
$loader = require __DIR__.'/vendor/autoload.php';

//注册自动加载
$loader->setPsr4('Libs\\', __DIR__.'/libs');
$loader->setPsr4('Configs\\', __DIR__.'/configs');
$loader->setPsr4('Models\\', __DIR__.'/models');

//标记运行的环境
\Libs\RunMod::mark();

//加载指定环境的配置文件
\Libs\Config::load();
