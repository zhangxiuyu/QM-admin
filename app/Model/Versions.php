<?php
/**
 *  @author zhenhong~
 *  @description 项目版本模型
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Versions
 *
 * @property int $id
 * @property string|null $title 项目名称
 * @property string|null $version_num 版本号
 * @property string|null $forceUpdate 1 强制更新 0
 * @property string|null $url 下载地址
 * @property string|null $hot_num 热更新号
 * @property string|null $content 更新说明
 * @property string|null $image_url 广告图片
 * @property string|null $jump_url 广告跳转地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\VersionLogs[] $versionLogs
 * @property-read int|null $version_logs_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereForceUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereHotNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereJumpUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Versions whereVersionNum($value)
 * @mixin \Eloquent
 */
class Versions extends Model
{
    protected $table = 'versions';

    protected $fillable = [
        'title',
        'version_num',
        'url',
        'hot_num',
        'content',
    ];

    public function versionLogs()
    {
        return $this->hasMany(VersionLogs::class, 'versions_id', 'id');
    }

    public function getUrlAttribute($value)
    {
        return imgAllUrl($value);
    }
}
