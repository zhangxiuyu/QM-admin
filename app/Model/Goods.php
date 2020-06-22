<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\ConfigImg
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $img
 * @property int|null $type 1:首页nanner图 2：小图标
 * @property int|null $sort
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\ConfigImg onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ConfigImg whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\ConfigImg withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\ConfigImg withoutTrashed()
 * @mixin \Eloquent
 * @property string $pictures
 * @property float $prices
 * @property int $top
 * @property string|null $div
 * @property int|null $ftype
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Goods whereDiv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Goods whereFtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Goods wherePictures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Goods wherePrices($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Goods whereTop($value)
 */
class Goods extends Model
{
    use SoftDeletes;


    protected $table = 'goods';



    public function setPicturesAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['pictures'] = json_encode($pictures);
        }
    }

    public function getPicturesAttribute($pictures)
    {
        return json_decode($pictures, true);
    }

}
