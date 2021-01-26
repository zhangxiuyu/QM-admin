<?php


namespace App\Services;


use App\Model\Articles;
use QL\QueryList;

class Guanchao
{
    private static $url = 'https://guanchao.site';

    private static $p_url = 'https://guanchao.site/index/index/articlelist';

    private static $article = 'https://guanchao.site/index/article/articledetail.html?artid=';

    public static function encode($_str)
    {
        $staticchars = "PXhw7UT1B0a9kQDKZsjIASmOezxYG4CHo5Jyfg2b8FLpEvRr3WtVnlqMidu6cN";
        $staticchars = str_split($staticchars);
        $_str = str_split($_str);
        $encodechars = "";
        for ($i = 0; $i < count($_str); $i++) {
            $num0 = array_keys($staticchars,$_str[$i])[0];

            if (empty($num0)) {
                $code = $_str[$i];
            } else {
                $code = $staticchars[($num0 + 3) % 62];
            }

            $num1 = intval(0.12 * 62, 10);
            $num2 = intval(0.13 * 62, 10);
            $encodechars .= $staticchars[$num1] . $code . $staticchars[$num2];
        }
        return $encodechars;
    }

    public static function Start()
    {
        $articleNum = 36;

        for ($i=1;$i<=$articleNum;$i++){
            $http  = new \GuzzleHttp\Client;
            $response = $http->request('POST',self::$p_url,[
                'headers' =>  [
                    'X-Requested-With'=>'XMLHttpRequest'
                ],
                'form_params' => [
                    'page' => $i
                ]
            ]);
            $data =  json_decode((string)$response->getBody(),true);
            foreach ($data['articleShow'] as $datum){
                $code = self::encode($datum['id']);
                $article_url = self::$article . $code;
                $com = QueryList::get($article_url)->rules([
                    'title' => array('.panel>.panel-body>.c_titile', 'text'),
                    'com' => array('.panel>.panel-body>.infos', 'html'),
                ])->query()->getData();
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
            }
        }





    }

}
