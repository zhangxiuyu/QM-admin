<?php


namespace App\Admin\Controllers;


use App\Model\Goods;
use App\Model\GoodsType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsController extends AdminController
{


    protected $title = '商品列表';

    protected function grid()
    {
        $grid = new Grid(new Goods());
        $grid->model()->where([
            'status'=>1
        ])->orderBy('sort','DESC');
        $grid->column('id', 'ID');
        $grid->column('pictures', '商品图片')->image();
        $grid->column('name', '商品名称')->editable();
        $grid->column('sort','排序')->editable()->sortable();
        $GoodsType = new GoodsType();
        $type = $GoodsType->where([
            'status'=>1,
        ])->whereNotNull('pid')->select('name','id')->get();
        $list = [];
        foreach ($type as $value){
            $list[$value->id] = $value->name;
        }
        $grid->column('type','商品分类')->select($list);


        $grid->filter(function($filter){

            // 表单左右结构
            $filter->column('0.5',function($filter){
                $filter->like('name','商品名称');
                //  select 定值查询

                $GoodsType = new GoodsType();
                $type = $GoodsType->where([
                    'status'=>1,
                ])->whereNotNull('pid')->select('name','id')->get();
                $type_list = [];
                foreach ($type as $value){
                    $type_list[$value->id] = $value->name;
                }
                $filter->equal('type','商品分类')->select($type_list);

            });

        });


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

        $form->multipleImage('pictures', '图片')->removable()->sortable()->uniqueName()->thumbnail('small', $width = 300, $height = 300);;
        $list = [];
        $GoodsType = new GoodsType();
        $type = $GoodsType->where([
            'status'=>1,
            'pid' => null
        ])->select('name','id')->get();
        foreach ($type as $value){
            $list[$value->id] = $value->name;
        }

        if ($form->isEditing()){
            $id = request()->route()->parameters();
            $model = $form->model()->find($id['good']);
            $lists = [];
            $types = $GoodsType->where([
                'status'=>1,
                'pid' => $model->ftype
            ])->select('name','id')->get();
            $one = [];
            foreach ($types as $va){
                if ($va->id == $model->type){
                    $one['id'] = $va->id;
                    $one['name'] = $va->name;
                }else{
                    $lists[$va->id] = $va->name;
                }
            }

            $lists[$one['id']] = $one['name'];

            $form->select('ftype','分类')->options($list)->load('type','/admin/goodsTypeXiao');
            $form->select('type','商品分类')->options($lists);
        }else{
            $form->select('ftype','分类')->options($list)->load('type','/admin/goodsTypeXiao');
            $form->select('type','商品分类');
        }


        $form->UEditor('div','详情');

        //保存前回调
        $form->saving(function (Form $form) {
            if (!$form->isEditing()){
                $goods_type = new GoodsType();
                $form->type = $goods_type->where('name',$form->type)->value('id');
            }
        });


        return $form;
    }

    public function goodsTypeXiao(GoodsType $goodsType)
    {

        $GoodsType = new GoodsType();
        $type = $GoodsType->where([
            'status'=>1,
            'pid' => request('q')
        ])->select('name','id')->get();
        $list = [];
        foreach ($type as $value){
            $list[$value->id] = $value->name;
        }
        return $list;
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
