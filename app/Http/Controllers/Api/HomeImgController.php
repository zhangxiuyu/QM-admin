<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\ConfigImg;

class HomeImgController extends Controller
{

    public function banner(ConfigImg $configImg)
    {
        $data = $configImg->where([
            'status' => 1,
            'type' => 1,
        ])->orderBy('sort','desc')->select('img')->get();

        return api_success('',$data);
    }

}
