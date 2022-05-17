<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Student extends BaseController
{
    public function __construct()
    {
        if(session()->user['type'] != 'student'){
            dd('galima tik studentui');
        }
    }

    public function index()
    {
        return view('users/student/student');
    }
}