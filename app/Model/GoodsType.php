<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\GoodsType
 *
 * @property int $id
 * @property int|null $pid
 * @property string|null $name
 * @property string|null $img
 * @property int|null $sort
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\GoodsType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoodsType extends Model
{


    protected $table = 'goods_type';



}
