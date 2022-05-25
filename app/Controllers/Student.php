<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;
use App\Models\StudentModel;
use App\Models\TeacherModel;
use App\Models\UserModel;

class Student extends BaseController
{
    public function __construct()
    {
        if (isset(session()->user)) {
            if (session()->user['type'] != 'student') {
                dd('galima tik studentui');
            }
        } else {
            dd('Prasome prisijungti');
        }

        $this->classModel = new ClassModel();
        $this->lessonModel = new LessonModel();
        $this->teacherModel = new TeacherModel();
        $this->studentModel = new StudentModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $logged_in_student = $this->studentModel->where('user_id', session()->user['id'])->first();
        $student_data =  $this->studentModel->getWithRelations($logged_in_student['id']);
        $teacher = $this->teacherModel->where('class_id', $student_data['class_id'])->first();
        $teacher_data = $this->teacherModel->getWithRelations($teacher['id']);

        $data = [
            'student' => $student_data,
            'teacher' =>$teacher_data
        ];


        return view('users/student/student', $data);
    }
}