<?php
namespace Libs;

use \Illuminate\Database\Eloquent\Model as EqtModel;

/**
 * 模型基类
 * Class BaseModel
 * @package Libs\BaseModel
 */
class BaseModel extends EqtModel
{
    /**
     * 自动维护数据库表的 created_at 和 updated_at 字段
     */
    public $timestamps = false;
    
    /**
     * 默认允许批量赋值
     * @var array
     */
    protected $guarded = [];
    
    /** 包装一个预载入模型方法，主要为了方便书写自定义字段
     * @param unknown $relation
     * @param arrat $columns
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function withOnly($relation, $columns)
    {
        return self::with([$relation => function ($query) use ($columns){
            $query->select($columns);
        }]);
    }
}