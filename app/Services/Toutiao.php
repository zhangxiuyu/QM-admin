<?php


namespace App\Services;




use QL\QueryList;

class Toutiao
{

    private static $urls = [
        "https://toutiao.io/subjects/25390",
    ];

    public static function Start()
    {
        foreach (self::$urls as $url) {
            $returnData = QueryList::get($url)->rules([
                'title' => array('.content>.title>a', 'texts'),
                'link' => array('.content>.title>a', 'attrs(href)'),
            ])->query()->getData();
            return $returnData->all();
        }
    }


}
