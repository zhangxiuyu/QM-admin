<?php


namespace App\Admin\Controllers;


use App\Model\Config;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ConfigController extends AdminController
{

    protected $title = '首页banner图';

    protected function grid()
    {
        $grid = new Grid(new Config());

        $grid->column('id', 'ID');
        $grid->column('name', '名称')->editable();
        $grid->column('der', '说明')->editable();
        $grid->column('value', '参数')->editable();
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Config());

        $form->text('name', '名称');
        $form->text('der', '说明');
        $form->text('value', '参数');

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(Config::findOrFail($id));
        $show->field('name',"名称");
        $show->field('der',"说明");
        $show->field('value',"参数");
        $show->field('created_at',"创建时间");
        $show->field('updated_at',"创建时间");

        return $show;
    }

}
