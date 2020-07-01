<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DateController extends Controller
{

    /**
     * 写日记的日历
     * @param Request $request
     */
    public function getDate(Request $request)
    {
        // 获取当前用户
        $user = $request->attributes->get('user_info');

        $y = request('y');
        $m = request('m');
        if (strlen($m) == 1){
            $m = '0' . $m;
        }
        $sql = "
            SELECT
                Date (created_at) as date
            FROM
                diary
            WHERE
                user_id = ".$user->id."
                AND deleted_at is null
                AND created_at LIKE '" . $y ."-" . $m ."%'

            GROUP BY
                date";
        $dateAll = DB::select($sql);
        $list = [];
        foreach ($dateAll as $value){
            $list[] = (int)substr($value->date,8,10);
        }
        $sumCount = DB::select("
             SELECT
                Date (created_at) as date
            FROM
                diary
            WHERE
                user_id = ".$user->id."
                AND deleted_at is null
            GROUP BY
                date
        ");
        $lists['lists'] = $list;
        $lists['sumCount'] = count($sumCount);

        return api_success('',$lists);
    }

}
