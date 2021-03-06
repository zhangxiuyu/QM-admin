<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{


    protected $table = 'topic';


    // 关联用户表
    public function userItem()
    {
        return $this->belongsTo(UserItems::class, 'uid', 'id');
    }


}
