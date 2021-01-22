<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\Toutiao;

class ReptileController extends Controller
{



    public function index()
    {
        return Toutiao::Start();
    }








}
