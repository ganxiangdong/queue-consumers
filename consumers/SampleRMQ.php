<?php
require __DIR__.'/../init.php';
class SampleRMQ extends \Libs\BaseConsumer
{
    //使用RMQ封装的特性
    use \Libs\QueueRmq;
    
    /**
     * 运行消费者
     */
    public function run()
    {
        //获取连接通道
        $channel = $this->getChannel();
        //声明sample业务交换机和队列
        $queueName = \Libs\RmqDeclare::sample($channel);
        
        //三种轮询回调方法的注册方式示例：
        
        //回调示例1
//         $this->polling($queueName, function($msg){
//             echo '回调1:我在处理业务...'.$msg;
//             //处理完成必须要返回true,否则此消费不会被确认为已消费
//             return true;
//         });
        
        //回调示例2
//         $this->polling($queueName, [$this, 'callBack2']);

        //回调示例3
        $this->polling($queueName, ['SampleRMQ', 'callBack3']);
    }
    
    //回调示例2
    public function callBack2($msg)
    {
        echo '回调2:我在处理业务...'.$msg;
        //处理完成必须要返回true,否则此消费不会被确认为已消费
        return true;
    }
    
    //回调示例3
    public static function callBack3($msg)
    {
        $info = \Models\Captcha::test();
        print_r($info);
        echo '回调3:我在处理业务...'.$msg;
        //处理完成必须要返回true,否则此消费不会被确认为已消费
        return true;
    }
}

$sampleConsumer = new SampleRMQ();
$consumerManager = \Xd\QueueConsumersManager\Manager::getInstance($sampleConsumer);
$consumerManager->receivedMax = 1000;//设置每个consumer最多请求多少次消息后重启,默认为1000
$consumerManager->run();
