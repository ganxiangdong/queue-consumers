<?php
namespace Libs;

/**
 * 制定运行模式
 * 定义运行环境常量 RUN_MOD，如果没匹配到规则，则默认为default
 */
class RunMod
{
    /**
     * 标记运行模式
     */
    public static function mark()
    {
        //引入配置文件，此时
        $envConfig = \Configs\Env::$rule;
        $hostname = gethostname();
        $runMod = '';
        foreach ($envConfig as $k => $v) {
            if (preg_match($k, $hostname)) {
                //配置到了主机
                $runMod = $v;
                break;
            }
        }
        if ($runMod == '') {
            //没有匹配到主机，则默认当前环境为default
            $runMod = 'default';
        }
        define('RUN_MOD', $runMod);
    }
}