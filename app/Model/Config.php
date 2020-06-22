<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Config
 *
 * @property int $id
 * @property string $der
 * @property string $name
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config whereDer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Config whereValue($value)
 * @mixin \Eloquent
 */
class Config extends Model
{

}
