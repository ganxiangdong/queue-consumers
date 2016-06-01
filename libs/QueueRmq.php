<?php
namespace Libs;

/**
 * RMQ队列特性
 */
trait QueueRmq
{
    /**
     * RMQ 物理连接对象
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private static $connection = null;
    
    /**
     * RMQ 逻辑连接通道对象
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private static $channel = null;
    
    /**
     * 析构函数
     */
    public function __destruct()
    {
        $this->shutdown();
    }
    
    /**
     * 获取物理连接对象
     * @return \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    public function getConnection()
    {
        if (self::$connection === null) {
            self::$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
                \Configs\Rmq::$connect['addr'], 
                \Configs\Rmq::$connect['port'], 
                \Configs\Rmq::$connect['user'], 
                \Configs\Rmq::$connect['password'],
                \Configs\Rmq::$connect['vhost']
                );
        }
        return self::$connection;
    }
    
    /**
     * 获取逻辑连接通道
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel()
    {
        if (self::$channel === null) {
            self::$channel = $this->getConnection()->channel();
        }
        return self::$channel;
    }
    
    /**
     * 关闭consumer
     */
    public function shutdown()
    {
        if (self::$channel !== null) {
            self::$channel->close();
        }
        
        if (self::$connection !== null) {
            self::$connection->close();
        }
    }
    
    /**
     * 轮询获取消息
     * @param string $queueName
     * @param function $callBack 回调方法
     */
    public function polling($queueName, $callBack)
    {
        if (!is_callable($callBack)) {
            //回调方法不可调用
            throw new \Exception('回调方法不可调用');
        }
        
        while (true) {
            $msg = $this->getChannel()->basic_get($queueName);
            if ($msg != null) { //获取到了消息，处理业务
                //处理业务前先连接数据库
                \Libs\DbManager::connect();
                //调用业务处理方法
                $status = call_user_func_array($callBack, [$msg->body]);
                //处理完业务立马关闭数据库连接
                \Libs\DbManager::disconnect();
                if ($status === true) {
                    //确认消费已处理
                    $this->getChannel()->basic_ack($msg->delivery_info['delivery_tag']);
                }
            }
            
            //通知consumer管理者获并处理完成
            \Xd\QueueConsumersManager\Manager::noticeFetchedQueueMsg();
            
            if ($msg == null) {
                //没有消息，则休息一下，防止CPU爆表
                $sec = mt_rand(1,3);
                sleep($sec);
            }
        }
    }
}