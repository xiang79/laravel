<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegLogin extends Model
{
    public $primaryKey='reg_id';
    protected $guarded = [];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'reg_login';

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
