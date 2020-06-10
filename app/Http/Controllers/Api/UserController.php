<?php

namespace App\Http\Controllers\Api;


class UserController extends Controller
{
    public function userCode()
    {
        $code = require('code');
        if (empty($code)) {
          //  return api_
        } else {
            // code...
        }
        
    }
}