<?php
namespace Libs;

/**
 * RMQ 交换机、队列统一声明类
 */
class RmqDeclare
{
    /**
     * 交换机类型
     * @var array
     */
    public static $exchangeType = [
        'direct' => 'direct',//处理路由键
        'fanout' => 'fanout',//不处理路由键（广播）
        'topic'  => 'topic' //将路由键和某模式进行匹配
    ];
    
    /**
     * 声明sample业务
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     * @return string 队列名称
     */
    public static function sample(\PhpAmqpLib\Channel\AMQPChannel $channel)
    {
        //声明交换机
        $exchangeName = 'sample';
        $channel->exchange_declare($exchangeName, self::$exchangeType['direct'], false, true, false);
        //声明队列
        $queueName = 'sample';
        $channel->queue_declare($queueName, false, true, false, false, false, ['x-max-priority' => ['I', 10]]);
        //绑定routingKey
        $routingKey = 'sample';
        $channel->queue_bind($queueName, $exchangeName, $routingKey);
        //表示不采用轮询分配，采用公平分配，即谁处理完了分配给谁，要使用优先级消息必须这样，否则不生效
        $channel->basic_qos(null, 1, null);
        return $queueName;
    }
}