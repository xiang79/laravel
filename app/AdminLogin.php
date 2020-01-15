<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class AdminLogin extends Model
{
public $primaryKey='admin_id';
protected $guarded = [];
/**
* 关联到模型的数据表
*
* @var string
*/
protected $table = 'admin_login';

/**
* 表明模型是否应该被打上时间戳
*
* @var bool
*/
public $timestamps = false;
}
