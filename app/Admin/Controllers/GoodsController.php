<?php


namespace App\Admin\Controllers;


use App\Model\ConfigImg;
use App\Model\Goods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsController extends AdminController
{


    protected $title = '首页banner图';

    protected function grid()
    {
        $grid = new Grid(new Goods());
        $grid->model()->where([
            'status'=>1
        ])->orderBy('sort','DESC');
        $grid->column('id', 'ID');
        $grid->column('name', '商品名称')->editable();
        $grid->column('sort','排序')->editable()->sortable();
        $ConfigImg = new ConfigImg();
        $type = $ConfigImg->where([
            'status'=>1,
            'type' =>2
        ])->select('name','id')->get();
        $list = [];
        foreach ($type as $value){
            $list[$value->id] = $value->name;
        }
        $grid->column('type','商品分类')->select($list);
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Goods());

        $form->text('name', '商品名称');
        $form->number('sort', '排序');
        $form->currency('prices', '价格');
        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
        ];

        $form->switch('top', '首页是否展示')->states($states);

        $form->multipleImage('pictures', '图片')->removable()->sortable();
        $list = [];
        $ConfigImg = new ConfigImg();
        $type = $ConfigImg->where([
            'status'=>1,
            'type' =>2
        ])->select('name','id')->get();
        foreach ($type as $value){
            $list[$value->id] = $value->name;
        }

        $form->select('type','商品分类')->options($list);

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(Goods::findOrFail($id));
        $show->field('name',"名称");
        $show->field('sort',"排序");
        $show->field('img',"图片")->image();
        $show->field('created_at',"创建时间");
        $show->field('updated_at',"创建时间");

        return $show;
    }
}
