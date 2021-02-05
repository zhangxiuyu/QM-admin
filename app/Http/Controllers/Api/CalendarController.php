<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use com\nlf\calendar\Lunar;

class CalendarController extends Controller
{


    // 获取日历信息
    public function getCalendar()
    {
        $year = request('year');
        $month = (int)request('month');
        $day = (int)request('day');

        $lunar = Lunar::fromYmd($year, $month, $day);
        $yi  =  $ji  = $js = $xs = '';
        foreach ($lunar->getDayYi() as $va){
            $yi .= $va . ' ';
        }
        foreach ($lunar->getDayJi() as $va){
            $ji .= $va  . ' ';
        }
        foreach ($lunar->getDayJiShen() as $va){
            $js .= $va  . ' ';
        }
        foreach ($lunar->getDayXiongSha() as $va){
        $xs .= $va  . ' ';
        }
        $jiuxing = $lunar->getDayNineStar();
        $data = [
            [
                'name' => '农历',
                'hobby' => $lunar->getYearInChinese() . '年' . $lunar->getMonthInChinese() . '月' . $lunar->getDayInChinese() . ('阴历')
            ],[
                'name' => '年',
                'hobby' => $lunar->getYearInGanZhi() . '年 属' .$lunar->getYearShengXiao() . '  ' . $lunar->getYearNaYin()
            ],[
                'name' => '月',
                'hobby' => $lunar->getMonthInGanZhi() . '月  属'.$lunar->getMonthShengXiao() . '  ' . $lunar->getMonthNaYin()
            ],[
                'name' => '日',
                'hobby' => $lunar->getDayInGanZhi() . '日 属'.$lunar->getDayShengXiao() .  '  ' . $lunar->getDayNaYin()
            ],[
                'name' => '纳音',
                'hobby' => $lunar->getYearNaYin() . '   '.$lunar->getMonthNaYin() . '   '.$lunar->getDayNaYin() . '   '.$lunar->getTimeNaYin()
            ],[
                'name' => '星期',
                'hobby' => $lunar->getWeekInChinese()
            ],[
                'name' => '位',
                'hobby' => $lunar->getGong() . '方' . $lunar->getShou()
            ],[
                'name' => '星宿',
                'hobby' => $lunar->getXiu() .  $lunar->getZheng() . $lunar->getAnimal() . '(' .$lunar->getXiuLuck().')'
            ],[
                'name' => '彭祖百忌',
                'hobby' => $lunar->getPengZuGan() .'  '. $lunar->getPengZuZhi()
            ],[
                'name' => '喜神方位',
                'hobby' => $lunar->getDayPositionXi() .'  ('. $lunar->getDayPositionXiDesc() .')'
            ],[
                'name' => '阳贵神方位',
                'hobby' => $lunar->getDayPositionYangGui() .'  ('. $lunar->getDayPositionYangGuiDesc() .')'
            ],[
                'name' => '阴贵神方位',
                'hobby' => $lunar->getDayPositionYinGui() .'  ('. $lunar->getDayPositionYinGuiDesc() .')'
            ],[
                'name' => '阳贵神方位',
                'hobby' => $lunar->getDayPositionYinGui() .'  ('. $lunar->getDayPositionYinGuiDesc() .')'
            ],[
                'name' => '福神方位',
                'hobby' => $lunar->getDayPositionFu() .'  ('. $lunar->getDayPositionFuDesc() .')'
            ],[
                'name' => '财神方位',
                'hobby' => $lunar->getDayPositionCai() .'  ('. $lunar->getDayPositionCaiDesc() .')'
            ],[
                'name' => '冲',
                'hobby' => $lunar->getChongDesc()
            ],[
                'name' => '煞',
                'hobby' => $lunar->getSha()
            ],[
                'name' => '物候',
                'hobby' => $lunar->getWuHou()
            ],[
                'name' => '六曜',
                'hobby' => $lunar->getLiuYao()
            ],[
                'name' => '宜',
                'hobby' => $yi
            ],[
                'name' => '忌',
                'hobby' => $ji
            ],[
                'name' => '吉神宜趋',
                'hobby' => $js
            ],[
                'name' => '相冲',
                'hobby' => $lunar->getDayShengXiao() . '日 冲' . $lunar->getChongDesc()
            ],[
                'name' => '值星',
                'hobby' => $lunar->getZhiXing()
            ],[
                'name' => '星宿歌诀',
                'hobby' => $lunar->getXiuSong()
            ],[
                'name' => '十二天神',
                'hobby' => $lunar->getDayTianShen(). '('.$lunar->getDayTianShenType() .') '.$lunar->getDayTianShenLuck()
            ],[
                'name' => '九星',
                'hobby' => $jiuxing->getNumber(). $jiuxing->getColor().' - '.$jiuxing->getNameInTaiYi().'星('.$jiuxing->getWuXing().') - '.$jiuxing->getTypeInTaiYi()
            ],[
                'name' => '九星歌诀',
                'hobby' => $jiuxing->getSongInTaiYi()
            ]
        ];




        return api_success('', $data);


    }
}
