<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;


class Director extends BaseController
{
    protected $lessonModel;
    protected $classModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->lessonModel = new LessonModel();
    }

    public function index()
    {
        if($this->user['type'] != 'director'){
            dd('klaida');
        }

        $data = [
            'classes' => $this->classModel->findAll(),
            'lessons' => $this->lessonModel->findAll()
        ];


        return view('users/director', $data);
    }
}
