<?php


namespace App\Admin\Controllers;


use App\Admin\Ations\GoodsTypeEdit;
use Encore\Admin\Controllers\AdminController;
use App\Model\GoodsType;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\UploadedFile;

class GoodsTypeController extends AdminController
{
    protected $title = '子分类';


    public function goodsType(Content $content)
    {
        $courseId = request('pid');

        $name = request('name');

        $this->course_id = $courseId;

        return $content
            ->title($this->title)
            ->body($this->grid($courseId,$name));
    }


    protected function grid($courseId,$name)
    {
        $grid = new Grid(new GoodsType());
        $grid->model()->where([
            'status'=>1,
            'pid' => $courseId
        ])->orderBy('sort','DESC');
        $grid->column('id', 'ID');
        $grid->column('name', '名称');
        $grid->column('img','图片')->image();
        $grid->column('sort','排序')->sortable();
        $grid->tools(function (Grid\Tools $tools)use($courseId,$name) {
            //  禁用批量删除
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
            $tools->append("<a href='/admin/{$name}' class='report-posts btn btn-sm btn-default'><i class='fa fa-info-circle'></i>返回主分类</a>");

            $tools->append("<a href='/admin/createType/{$courseId}/{$name}' class='btn btn-sm btn-success'><i class='fa fa fa-plus'></i>新增</a>");
        });
        $grid->actions(function ($actions) {
            // 去掉删除
//            $actions->disableDelete();

            //  去掉查看
            $actions->disableView();

            //  去除编辑
            $actions->disableEdit();

//            //  自定义删除
//            $actions->add(new CommonDelete());
//
//            //  自定义编辑
            $actions->add(new GoodsTypeEdit());
        });

        $grid->disableCreateButton();

        return $grid;
    }


    public function createType($pid,$name, Content $content)
    {
        return $content
            ->title($this->title)
            ->body($this->form($pid,$name));
    }

    public function editType($id,$name, Content $content)
    {
        $goodsType = GoodsType::find($id);
//        return $content
//            ->title($this->title)
//            ->body($this->form($goodsType->pid,$name,$id))->edit($id);


        return $content
            ->title($this->title)
            ->body($this->form($goodsType->pid, $name, $id)->edit($id));
    }


    protected function form($pid,$name,$id='')
    {
        $form = new Form(new GoodsType());
        $form->setAction('/admin/handleCreate/' . $pid . '/' . $name);
        $form->text('name', '名称');
        $form->text('sort', '排序');
        $form->image('img', '图片');
        if (!empty($id)) {
            $form->hidden('id')->default($id);
        }

        $form->tools(function (Form\Tools $tools) use($pid, $name) {
            $tools->disableList();

            $tools->add("<a href='/admin/goodsType?pid={$pid}&name={$name}' class='btn btn-sm btn-default'><i class='fa fa-list'></i>&nbsp;&nbsp;列表</a>");
        });

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



    /**
     *  @author zhenhong~
     *  @description 处理 新增/修改请求
     */
    public function handleCreate($course_id, $jump)
    {
        //  新增
        if (request()->method() == 'POST') {

            $data = request()->all();

            $file = request()->file('img');
            $folder_name = "upload/images/avatars/" . date("Ym/d", time());
            $upload_path = public_path() . '/' . $folder_name;
            $extension  =  strtolower($file->getClientOriginalExtension())  ?:  'png';
            $filename = time() . '.' .  $extension;
            $file->move($upload_path, $filename);
            $path = substr($upload_path,strripos($upload_path,"upload")+6);
            $goodsType = new GoodsType();
            $goodsType->name = $data['name'];
            $goodsType->pid = $course_id;
            $goodsType->sort = $data['sort'];
            $goodsType->img = $path.'/'.$filename;

            $bool = $goodsType->save();

            if ($bool) {
                admin_toastr('新增成功', 'success', ['timeOut' => 3000]);

                return response()->redirectTo("/admin/goodsType?pid={$course_id}&name={$jump}");
            }else {
                admin_toastr('新增失败', 'error', ['timeOut' => 3000]);

                return back()->withinput();
            }
        }
        //  修改
        if ( request()->method() == 'PUT' ) {
            $data = request()->all();
            $GoodsType = GoodsType::find($data['id']);

            if (isset($data['img'])) {
                $file = request()->file('img');
                $folder_name = "upload/images/avatars/" . date("Ym/d", time());
                $upload_path = public_path() . '/' . $folder_name;
                $extension  =  strtolower($file->getClientOriginalExtension())  ?:  'png';
                $filename = time() . '.' .  $extension;
                $file->move($upload_path, $filename);
                $path = substr($upload_path,strripos($upload_path,"public")+6);
                $GoodsType->img = $path.'/'.$filename;
            }

            $GoodsType->name = $data['name'];
            $GoodsType->sort = $data['sort'];

            $bool = $GoodsType->update();

            if ($bool) {
                admin_toastr('修改成功', 'success', ['timeOut' => 3000]);

                return response()->redirectTo("/admin/goodsType?pid={$course_id}&name={$jump}");
            }else {
                admin_toastr('修改失败', 'error', ['timeOut' => 3000]);

                return back()->withinput();
            }
        }
    }
}
