<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Teacher extends BaseController
{
    public function __construct()
    {
        if (session()->user['type'] != 'teacher') {
            dd('galima tik mokytojui');
        }
    }

    public function index()
    {
        return view('users/teacher/teacher');
    }
}
