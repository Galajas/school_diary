<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;
use App\Models\TeacherModel;
use App\Models\StudentModel;
use App\Models\UserModel;

class Teacher extends BaseController
{
    protected $lessonModel;
    protected $classModel;
    protected $teacherModel;
    protected $studentModel;
    protected $userModel;


    public function __construct()
    {
        if (session()->user['type'] != 'teacher') {
            dd('galima tik mokytojui');
        }
        $this->classModel = new ClassModel();
        $this->lessonModel = new LessonModel();
        $this->teacherModel = new TeacherModel();
        $this->studentModel = new StudentModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $teacher = $this->teacherModel->where('user_id', session()->user['id'])->first();

        $data = [
            'students' => $this->classModel->getStudents($teacher['class_id']),
        ];

        if ($teacher['class_id'] != null) {
            $data['class'] = $this->classModel->find($teacher['class_id']);
        }

        return view('users/teacher/teacher', $data);
    }

}
