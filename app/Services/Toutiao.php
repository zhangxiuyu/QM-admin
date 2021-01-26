<?php


namespace App\Services;


use App\Model\Articles;
use QL\QueryList;

class Toutiao
{

    private static $urls = [
        "https://toutiao.io/subjects/25390?",
        "https://toutiao.io/subjects/25390?page=1",
        "https://toutiao.io/subjects/25390?page=2",
        "https://toutiao.io/subjects/25390?page=3",
        "https://toutiao.io/subjects/25390?page=4",
        "https://toutiao.io/subjects/25390?page=5",
        "https://toutiao.io/subjects/25390?page=6",
        "https://toutiao.io/subjects/25390?page=7",
        "https://toutiao.io/subjects/25390?page=8",
        "https://toutiao.io/subjects/25390?page=9",
        "https://toutiao.io/subjects/25390?page=10",
        "https://toutiao.io/subjects/25390?page=11",
        "https://toutiao.io/subjects/25390?page=12"
    ];

    private static $url = "http://toutiao.io";

    public static function Start()
    {
        foreach (self::$urls as $url) {
            $returnData = QueryList::get($url)->rules([
                'title' => array('.content>.title>a', 'texts'),
                'link' => array('.content>.title>a', 'attrs(href)'),
            ])->query()->getData();

            foreach ($returnData['link'] as $datum){
                try {
                    $headers = get_headers(self::$url . $datum,1);
                    if ($headers && $headers['Location'][1]){
                        $com = QueryList::get($headers['Location'][1])->rules([
                            'title' => array('#main>.post-content>.entry-header>h1', 'text'),
                            'time' => array('#main>.post-content>.entry-header>.entry-meta>.entry-date>a>time', 'datetime'),
                            'com' => array('#main>.post-content>.entry-content', 'html'),
                        ])->queryData();
                        if (!empty($com['title']) && !empty($com['com'])){
                            $a = new Articles();
                            $a->category_id = 1;
                            $a->author = '秀才';
                            $a->title = $com['title'];
                            $a->description = $com['title'];
                            $a->markdown = $com['title'];
                            $a->cover = '/uploads/article/default.jpg';
                            $a->keywords = $com['title'];
                            $a->html = $com['com'];
                            $a->save();
                        }
                    }else{
                        \Log::info('错误'.$datum,[$headers]);
                    }
                    sleep(5);
                }catch (\Exception $e){
                    \Log::info('错误'.$datum,[$e->getMessage()]);
                    continue;
                }
            }
        }
        return "完成";
    }


}
