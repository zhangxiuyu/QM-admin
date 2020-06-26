<?php


namespace App\Admin\Controllers;


use Encore\Admin\Controllers\AdminController;

class DiaryController extends AdminController
{

    public function test()
    {
        if (request('123')){

        }else{
            return 11;
        }

        
    }

}
