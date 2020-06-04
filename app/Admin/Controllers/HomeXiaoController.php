<?php


namespace App\Admin\Controllers;

use App\Admin\Ations\GoodsTypeE;
use App\Model\GoodsType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HomeXiaoController extends AdminController
{
    protected $title = '首页小图标';

    protected function grid()
    {
        $grid = new Grid(new GoodsType());
        $grid->model()->where([
            'status'=>1,
            'pid' => null
        ])->orderBy('sort','DESC');
        $grid->column('id', 'ID');
        $grid->column('name', '名称')->editable();
        $grid->column('img','图片')->image();
        $grid->column('sort','排序')->editable()->sortable();

        $grid->actions(function ($actions) {

            //  去掉删除
            $actions->disableDelete();
            //  下级分类
            $actions->add(new GoodsTypeE());
        });
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new GoodsType());

        $form->text('name', '名称');
        $form->text('sort', '排序');
        $form->image('img', '图片');

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(GoodsType::findOrFail($id));
        $show->field('name',"名称");
        $show->field('sort',"排序");
        $show->field('img',"图片")->image();
        $show->field('created_at',"创建时间");
        $show->field('updated_at',"创建时间");

        return $show;
    }
}
