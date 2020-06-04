<?php


namespace App\Admin\Ations;


use Encore\Admin\Actions\RowAction;

class GoodsTypeE extends RowAction
{
    public $name = '下级分类';

    /**
     * @return string
     */
    public function href()
    {
        $reourcePath = strstr($this->getResource(),'admin/');

        $name = str_replace('admin/','',$reourcePath);

        return '/admin/goodsType?pid='. $this->getKey(). '&name='. $name;
    }
}
