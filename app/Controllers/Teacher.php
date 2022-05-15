<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Teacher extends BaseController
{
    public function __construct()
    {

    }

    public function index()
    {
        if($this->user['type'] != 'teacher'){
            dd('klaida');
        }

        return view('users/teacher');
    }
}
