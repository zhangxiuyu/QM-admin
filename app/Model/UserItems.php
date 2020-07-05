<?php


namespace App\Model;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Model\UserItems
 *
 * @property int $id
 * @property string|null $openid
 * @property string|null $username
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserItems whereUsername($value)
 * @mixin \Eloquent
 */
class UserItems  extends Authenticatable implements JWTSubject
{

    use Notifiable;

    protected $table = 'user_items';

    protected $guarded=[];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    // 关联日记
    public function LiveChat()
    {
        return $this->hasMany(Diary::class, "user_id", "id");
    }


    // 关联评论表
    public function Topic()
    {
        return $this->hasMany(Topic::class, "uid", "id");
    }

    // 关联评论点赞表
    public function TopicHit()
    {
        return $this->hasMany(TopicHit::class, "uid", "id");
    }

}
