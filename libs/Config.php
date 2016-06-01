<?php
namespace Libs;

/**
 * 配置文件基类
 * Class Config
 * @package Libs
 */

class Config
{
    /**
     * 是否加载过了
     * @var boolean
     */
    private static $isLoaded = false;

    //禁止外部实例化
    final protected function __construct(){}
    final protected function __clone(){}

    /**
     * 根据环境加载配置文件
     * @return null
     */
    public static function load()
    {
        if (self::$isLoaded) {
            //已经加载过了
            return;
        }
        //配置文件路径
        $configPath = ROOT_PATH.'/configs';
        $configDir = dir($configPath); 
        //遍历配置文件目录
        while(($fileName = $configDir->read()) !== false) {
            if (strpos(strrev($fileName), 'php.') === 0) { //是php文件
                $className = substr($fileName, 0, strlen($fileName) - 4);
                $class = "\\Configs\\{$className}";
                if (class_exists($class)) { //存在配置文件类名
                    $envConfigPath = ROOT_PATH.'/configs/'.RUN_MOD."/{$className}.php";
                    if (file_exists($envConfigPath)) { //存在指定环境配置文件
                        //通过反射获取配置的静态属性
                        $reflect = new \ReflectionClass($class);
                        $staticProperties = $reflect->getStaticProperties();
                        if (!empty($staticProperties)) {
                            $envConfig = require_once $envConfigPath;
                            foreach ($staticProperties as $propertyName => $propertyValue) {
                                if (isset($envConfig[$propertyName])) { //存在环境指定配置项
                                    //使用环境指定配置项覆盖配置项
                                    $class::$$propertyName = $envConfig[$propertyName];
                                }
                            }
                        }
                    }
                }
            }
        }
        self::$isLoaded = true;
        return;
    }
}