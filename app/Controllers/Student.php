<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Student extends BaseController
{
    public function __construct()
    {

    }

    public function index()
    {
        if($this->user['type'] != 'student'){
            dd('klaida');
        }

        return view('users/student');
    }
}
