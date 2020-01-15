<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndexPrice extends Model
{
public $primaryKey='pid';
protected $guarded = [];
/**
* 关联到模型的数据表
*
* @var string
*/
protected $table = 'index_price';

/**
* 表明模型是否应该被打上时间戳
*
* @var bool
*/
public $timestamps = false;
}
