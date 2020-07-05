<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class TopicHit extends Model
{


    protected $table = 'topic_hit';


    protected $fillable = ['uid','is','topic_id'];

    // 关联用户表
    public function userItem()
    {
        return $this->belongsTo(UserItems::class, 'uid', 'id');
    }


}