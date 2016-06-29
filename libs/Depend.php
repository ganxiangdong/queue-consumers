<?php
namespace Libs;

use Monolog\Logger;
use \Configs\LogMails;

/**
 * 依赖注入，向IOC容器注入依赖的对象
 */
class Depend
{
    /**
     * 注入服务
     */
    public static function inject()
    {
        /* ==== 注入monolog默认的日志对象 ==== */
        \Libs\Ioc::bind('logDefault', function () {
            static $logger = null;
            if ($logger == null) {
                $logger = new \Monolog\Logger('logs');
                $logFile = ROOT_PATH.'/log/default.log';
                //按天记录debug日志
                $rotatingHandler = new \Monolog\Handler\RotatingFileHandler($logFile, 1, Logger::DEBUG);
                //实时发送邮箱
                $sendUserName = LogMails::$sendConfig['userName'];
                $transport = \Swift_SmtpTransport::newInstance()
                                ->setHost(LogMails::$sendConfig['host'])
                                ->setPort(LogMails::$sendConfig['port'])
                                ->setUsername(LogMails::$sendConfig['userName'])
                                ->setPassword(LogMails::$sendConfig['password']);
                $mailer = new \Swift_Mailer($transport);
                $swiftMessage = (new \Swift_Message(LogMails::$sendConfig['subject']))
                                ->setFrom(array("{$sendUserName}" => LogMails::$sendConfig['from']))
                                ->setTo(\Configs\LogMails::$mails);
                $swiftMailerHandler = new \Monolog\Handler\SwiftMailerHandler($mailer, $swiftMessage, Logger::WARNING);
                $logger->pushHandler($rotatingHandler);
                $logger->pushHandler($swiftMailerHandler);
            }
            return $logger;
        });
        
    }
}
