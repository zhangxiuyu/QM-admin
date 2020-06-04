<?php


namespace App\Admin\Ations;


use Encore\Admin\Actions\RowAction;

class GoodsTypeEdit extends RowAction
{
    public $name = '编辑';

    public function href()
    {
        return "/admin/editType/" . $this->getKey() . '/' . request('name');
    }
}
