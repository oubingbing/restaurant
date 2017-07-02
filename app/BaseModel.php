<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2017/6/25
 * Time: 11:43
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;
}