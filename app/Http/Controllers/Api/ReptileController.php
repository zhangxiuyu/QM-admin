<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Articles;
use App\Model\ArticleTags;
use App\Model\Tags;
use App\Services\BaiYinYao;
use App\Services\Guanchao;
use App\Services\Toutiao;

class ReptileController extends Controller
{



    public function index()
    {
//        return Toutiao::Start();
//        return Guanchao::Start();
//        return BaiYinYao::Start();
//        $s = strpos($str,$tags);
        // 处理添加标签
        $tags = Tags::query()->select('id','name')->get();
        $tags_data = [];
        foreach ($tags as $va){
            $tags_data[$va['id']] = $va['name'];
        }

        $articles = Articles::query()->whereRaw("id not in(select article_id from bjy_article_tags)")->get();
        foreach ($articles as $article){
//            $data[] = $article->title;
////
            $tags_id = $this->TagsData($article->title,$tags_data);
            $articleTags = new ArticleTags();
            $articleTags->article_id = $article->id;
            $articleTags->tag_id = $tags_id;
            $articleTags->save();
            $article->category_id = 4;
            $article->save();


        }

    }

    public function TagsData($str,$tags_data)
    {
        foreach ($tags_data as $id => $tags){
            $s = strpos($str,$tags);
            if ($s !== false){
                return $id;
            }
        }
        return 14;
    }








}
