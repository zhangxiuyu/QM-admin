<?php
/**
 *  @author zhenhong~
 *  @description 版本操作日志
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\VersionLogs
 *
 * @property int $id
 * @property int|null $versions_id 关联版本表ID
 * @property string|null $action 动作名
 * @property int $admin_id 操作人ID
 * @property string|null $data_info 操作后数据
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\AdminUser $adminUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs whereDataInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VersionLogs whereVersionsId($value)
 * @mixin \Eloquent
 */
class VersionLogs extends Model
{
    protected $table = 'version_logs';

    protected $fillable = [
        'versions_id',
        'action',
        'admin_id',
        'data_info'
    ];


    public function getActionAttribute($value)
    {
        return $value == 'create' ? '新增' : '修改';
    }
}
