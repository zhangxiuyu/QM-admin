<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\Diary
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string|null $html
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Diary onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Diary whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Diary withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Diary withoutTrashed()
 * @mixin \Eloquent
 */
class Diary extends Model
{

    use SoftDeletes;

    protected $table = 'diary';

}
