<?php


namespace App\Services;


use App\Model\Articles;
use QL\QueryList;

class BaiYinYao
{


    private  static $urls = [
        'http://fengkui.net/search?wd='
    ];

    private static $url = 'http://blog.5858xy.xyz';


    public static function Start()
    {
        for ($i=1;$i<=16;$i++){
            $comOne = QueryList::get(self::$urls[0].$i)->rules([
                'title' => array('.b-oa-title', 'texts'),
                'href' => array('.b-oa-title', 'attrs(href)'),
            ])->query()->getData();

            foreach ($comOne['href'] as $ke => $url){
                $com = QueryList::get($url)->rules([
                    'title' => array('.b-article>.b-title', 'text'),
                    'com' => array('.b-article>.b-content-word', 'html'),
                ])->query()->getData();

                $com['com'] = substr($com['com'],0,strrpos($com['com'],"本文为冯奎原创文章"));
                $com['com'] = str_replace('/uploads/article','http://fengkui.net/uploads/article',$com['com']);
                if (!empty($com['title']) && !empty($com['com'])){
                        $a = new Articles();
                        $a->category_id = 1;
                        $a->author = '秀才';
                        $a->title = $com['title'];
                        $a->description = $com['title'];
                        $a->markdown = $com['com'];
                        $a->cover = '/uploads/article/default.jpg';
                        $a->keywords = $com['title'];
                        $a->html = $com['com'];
                        $a->save();
                }
            }
        }
    }

}
