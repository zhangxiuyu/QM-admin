<?php


namespace App\Admin\Controllers;

use App\Model\ConfigImg;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HomeImgController extends AdminController
{
    protected $title = '首页banner图';

    protected function grid()
    {
        $grid = new Grid(new ConfigImg());
        $grid->model()->where([
            'status'=>1,
            'type' =>1
        ])->orderBy('sort','DESC');
        $grid->column('id', 'ID');
        $grid->column('name', '名称')->editable();
        $grid->column('img','图片')->image();
        $grid->column('sort','排序')->editable()->sortable();
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new ConfigImg());

        $form->text('name', '名称');
        $form->text('sort', '排序');
        $form->image('img', '图片');

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(ConfigImg::findOrFail($id));
        $show->field('name',"名称");
        $show->field('sort',"排序");
        $show->field('img',"图片")->image();
        $show->field('created_at',"创建时间");
        $show->field('updated_at',"创建时间");

        return $show;
    }
}
