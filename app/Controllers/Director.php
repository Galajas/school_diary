<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;
use App\Models\TeacherModel;
use App\Models\UserModel;


class Director extends BaseController
{
    protected $lessonModel;
    protected $classModel;
    protected $teacherModel;
    protected $userModel;

    public function __construct()
    {
        if (session()->user['type'] != 'director') {
                dd('klaida');
            }

        $this->classModel = new ClassModel();
        $this->lessonModel = new LessonModel();
        $this->teacherModel = new TeacherModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'classes' => $this->classModel->findAll(),
            'lessons' => $this->lessonModel->findAll(),
            'teachers' => $this->teacherModel->findAll(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];


        return view('users/director', $data);
    }

    public function createTeacher()
    {
        if ($this->validate([
            'password' => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'firstname' => 'required|min_length[2]|max_length[60]',
            'lastname' => 'required|min_length[2]|max_length[60]',
            'lesson_id' => 'permit_empty|is_not_unique[lessons.id]',
            'class_id' => 'permit_empty|is_not_unique[classes.id]',
        ])) {
            $user_data = [
                'email' => $this->request->getVar('email'),
                'password' => md5($this->request->getVar('password')),
                'firstname' => $this->request->getVar('firstname'),
                'lastname' => $this->request->getVar('lastname'),
                'type' => 'teacher'
            ];
            $user_id = $this->userModel->insert($user_data);

            $teacher_data = [
                'user_id' => $user_id,
                'lesson_id' => $this->request->getVar('lesson_id') ?? null,
                'class_id' => $this->request->getVar('class_id') ?? null,
            ];
            $this->teacherModel->insert($teacher_data);

            return redirect()->to(base_url('/director/index'))->with('success', 'Mokytojas sėkimingai sukurtas');
        } else {
            return redirect()->to(base_url('/director/index'))->with('errors', $this->validator->listErrors());
        }
    }

    public function editTeacher(int $id)
    {
        $teacher = $this->teacherModel->getFullData($id);
        if ($teacher) {
            $data = [
                'lessons' => $this->lessonModel->findAll(),
                'classes' => $this->classModel->findAll(),
                'teacher' => $teacher
            ];

            return view('users/director/teacher_edit', $data);
        }

        return redirect()->to(base_url('/director/index'))->with('errors', 'mokytojas nerastas');
    }

    public function updateTeacher(int $id)
    {
        $teacher = $this->teacherModel->getFullData($id);
        if ($teacher) {
            if ($this->validate([
                'password' => 'permit_empty|min_length[2]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $teacher['user_id'] . ']',
                'firstname' => 'required|min_length[2]|max_length[60]',
                'lastname' => 'required|min_length[2]|max_length[60]',
                'lesson_id' => 'permit_empty|is_not_unique[lessons.id]',
                'class_id' => 'permit_empty|is_not_unique[classes.id]',
            ])) {
                $userData = [
                    'email' => $this->request->getVar('email'),
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                ];

                $password = $this->request->getVar('password') ?? null;
                if ($password != null) {
                    $userData['password'] = md5($this->request->getVar('password'));
                }

                $this->userModel->update($teacher['user_id'], $userData);

                $this->teacherModel->update($id, [
                    'lesson_id' => $this->request->getVar('lesson_id') ?? null,
                    'class_id' => $this->request->getVar('class_id') ?? null,
                ]);

                return redirect()->to(base_url('/director/index'))->with('success', 'Mokytojas sėkimingai atnaujintas');
            }
        }

        return redirect()->to(base_url('/director/index'))->with('errors', 'mokytojas nerastas');
    }
}
