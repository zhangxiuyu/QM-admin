<?php
/**
 *  @author zhenhong~
 *  @description 项目列表
 */
namespace App\Admin\Controllers;

use App\Model\VersionLogs;
use App\Model\Versions;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Cache;

class VersionsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'APP版本更新';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Versions());


        $grid->column('version_num', '版本号');
        $grid->column('url', '下载地址')->downloadable();
        $grid->column('content', '更新说明');
        $grid->column('created_at', '新增时间');
        $grid->column('updated_at', '更新时间');
        $grid->disableCreateButton();
        $grid->disableFilter();
        $grid->disableRowSelector();

        $grid->actions(function($actions){
            $actions->disableDelete();

            $actions->disableView();

        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Versions());


        $form->text('version_num', '版本号')->required();

        $form->textarea('content', '更新说明')->required();
        $form->file('url', '上传包')->required();

        $form->saving(function (Form $form) {
            if ($form->forceUpdate == 'off'){
                $form->forceUpdate = '0';
            }
            if ($form->forceUpdate == 'on'){
                $form->forceUpdate = '1';
            }
            // 清除下载二维码图片的缓存
            Cache::pull('version_code_img');

        });

        return $form;
    }

    //  编辑
    public function edit($id, Content $content)
    {
        $grid = new Grid(new VersionLogs());

        $grid->model()->where('versions_id', $id)->latest('created_at');
        $grid->column('action', '操作行为');
        $grid->column('version_num', '版本号')->display(function(){
            return json_decode($this->data_info, true)['version_num'];
        });

        $grid->column('content', '更新说明')->display(function(){
            return json_decode($this->data_info, true)['content'];
        });
        $grid->column('created_at', '操作时间');
        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->disableFilter();
        $grid->disableBatchActions();

        //  form
        $form = new Form(Versions::findOrFail($id));
        $form->text('version_num', '版本号')->required();
        $form->textarea('content', '更新说明')->required();
        $form->file('url', '上传包')->required();



        return $content->title('APP版本更新')
                ->row($form->edit($id))
                ->row($grid);
    }
}
