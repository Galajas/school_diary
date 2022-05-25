<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;
use App\Models\TeacherModel;
use App\Models\StudentModel;
use App\Models\UserModel;


class Director extends BaseController
{
    protected $lessonModel;
    protected $classModel;
    protected $teacherModel;
    protected $studentModel;
    protected $userModel;

    public function __construct()
    {
        if (isset(session()->user)) {
            if (session()->user['type'] != 'director') {
                dd('galima tik direktoriui');
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
        $data = [
            'classes' => $this->classModel->findAll(),
            'lessons' => $this->lessonModel->findAll(),
            'teachers' => $this->teacherModel->findAllWithRelations(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];


        return view('users/director/home', $data);
    }

    public function teacherSettings()
    {
        $data = [
            'classes' => $this->classModel->findAll(),
            'lessons' => $this->lessonModel->findAll(),
            'teachers' => $this->teacherModel->findAllWithRelations(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];

        return view('users/director/teacher_settings', $data);
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

            return redirect()->to(base_url('/director/teacherSettings'))->with('success', 'Mokytojas sėkimingai sukurtas');
        } else {
            return redirect()->to(base_url('/director/teacherSettings'))->with('errors', $this->validator->listErrors());
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

        return redirect()->to(base_url('/director/teacherSettings'))->with('errors', 'mokytojas nerastas');
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

                return redirect()->to(base_url('/director/teacherSettings'))->with('success', 'Mokytojas sėkimingai atnaujintas');
            }
        }

        return redirect()->to(base_url('/director/teacherSettings'))->with('errors', 'mokytojas nerastas');
    }

    public function deleteTeacher($id)
    {
        $teacher = $this->teacherModel->find($id);
        if ($teacher) {
            $this->userModel->delete($teacher['user_id']);
            $this->teacherModel->delete($teacher['id']);

            return redirect()->to(base_url('/director/teacherSettings'))->with('success', 'Mokytojas sėkimingai ištrintas');
        }
        return redirect()->to(base_url('/director/teacherSettings'))->with('errors', 'Mokytojas nerastas');
    }

    public function studentSettings($id = null)
    {
        $data = [
            'classes' => $this->classModel->findAll(),
            'students' => $this->studentModel->getWithRelations(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];

        if ($id != null) {
            $data['student'] = $this->studentModel->getWithRelations($id);
        }

        return view('users/director/student_settings', $data);
    }

    public function createStudent()
    {
        if ($this->validate([
            'password' => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'firstname' => 'required|min_length[2]|max_length[60]',
            'lastname' => 'required|min_length[2]|max_length[60]',
            'class_id' => 'permit_empty|is_not_unique[classes.id]',
        ])) {
            $user_data = [
                'email' => $this->request->getVar('email'),
                'password' => md5($this->request->getVar('password')),
                'firstname' => $this->request->getVar('firstname'),
                'lastname' => $this->request->getVar('lastname'),
                'type' => 'student'
            ];
            $user_id = $this->userModel->insert($user_data);

            $student_data = [
                'user_id' => $user_id,
                'class_id' => $this->request->getVar('class_id') ?? null,
            ];
            $this->studentModel->insert($student_data);

            return redirect()->to(base_url('/director/studentSettings'))->with('success', 'Studentas sėkimingai sukurtas');
        } else {
            return redirect()->to(base_url('/director/studentSettings'))->with('errors', $this->validator->listErrors());
        }
    }

    public function updateStudent(int $id)
    {
        $student = $this->studentModel->getWithRelations($id);

        if ($student) {
            if ($this->validate([
                'password' => 'permit_empty|min_length[2]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $student['user_id'] . ']',
                'firstname' => 'required|min_length[2]|max_length[60]',
                'lastname' => 'required|min_length[2]|max_length[60]',
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

                $this->userModel->update($student['user_id'], $userData);

                $this->studentModel->update($id, [
                    'class_id' => $this->request->getVar('class_id') ?? null,
                ]);

                return redirect()->to(base_url('/director/studentSettings'))->with('success', 'Studentas sėkimingai atnaujintas');
            }
        }

        return redirect()->to(base_url('/director/studentSettings'))->with('errors', 'Studentas nerastas');
    }

    public function deleteStudent($id)
    {
        $student = $this->studentModel->find($id);
        if ($student) {
            $this->userModel->delete($student['user_id']);
            $this->studentModel->delete($student['id']);

            return redirect()->to(base_url('/director/studentSettings'))->with('success', 'Moksleivis sėkimingai ištrintas');
        }
        return redirect()->to(base_url('/director/studentSettings'))->with('errors', 'Moksleivis nerastas');
    }

    public function lessons($id = null)
    {
        $data = [
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
            'lessons' => $this->lessonModel->findAll()
        ];

        if ($id != null) {
            $data['lesson'] = $this->lessonModel->find($id);
        }

        return view('users/director/lessons', $data);
    }

    public function createLesson()
    {
        if ($this->validate([
            'lesson' => 'required|min_length[2]|max_length[60]|is_unique[lessons.title]',
        ])) {
            $lesson = [
                'title' => $this->request->getVar('lesson'),
            ];

            $this->lessonModel->insert($lesson);

            return redirect()->to(base_url('/director/lessons'))->with('success', 'Pamoka sėkimingai sukurta');
        } else {
            return redirect()->to(base_url('/director/lessons'))->with('errors', $this->validator->listErrors());
        }
    }

    public function updateLesson(int $id)
    {
        $lesson = $this->lessonModel->find($id);

        if ($lesson) {
            if ($this->validate([
                'lesson' => 'required|min_length[2]|max_length[60]|is_unique[lessons.title,id,' . $id . ']',
            ])) {
                $lesson_title = [
                    'title' => $this->request->getVar('lesson'),
                ];

                $this->lessonModel->update($lesson['id'], $lesson_title);

                return redirect()->to(base_url('/director/lessons'))->with('success', 'Pamoka sėkimingai atnaujinta');
            } else {
                $errors = $this->validator->listErrors();
            }
        } else {
            $errors = 'Klaida';
        }
        return redirect()->to(base_url('/director/lessons'))->with('errors', $errors);
    }

    public function deleteLesson($id)
    {
        $lesson = $this->lessonModel->find($id);
        if ($lesson) {
                $this->lessonModel->delete($lesson['id']);
                $this->teacherModel->set('lesson_id', 0, false)->where('lesson_id', $lesson['id'])->update();

                return redirect()->to(base_url('/director/lessons'))->with('success', 'Pamoka sėkimingai ištrinta');
        } else {
            $errors = 'Klaida';
        }
        return redirect()->to(base_url('/director/lessons'))->with('errors', $errors);
    }

    public function classes($id = null)
    {
        $data = [
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
            'classes' => $this->classModel->findAll(),
        ];

        if ($id != null) {
            $data['class'] = $this->classModel->find($id);
        }

        return view('users/director/classes', $data);
    }

    public function createClass() {
        if ($this->validate([
            'title' => 'required|exact_length[2,3]|is_unique[classes.title]',
            'max_week_lessons' => 'required|integer|exact_length[1,2]'
        ])) {
            $class_data = [
                'title' => $this->request->getVar('title'),
                'max_week_lessons' => $this->request->getVar('max_week_lessons'),
            ];

            $this->classModel->insert($class_data);

            return redirect()->to(base_url('/director/classes'))->with('success', 'Klasė sėkimingai sukurta');
        } else {
            return redirect()->to(base_url('/director/classes'))->with('errors', $this->validator->listErrors());
        }
    }

    public function updateClass(int $id)
    {
        $class = $this->classModel->find($id);

        if ($class) {
            if ($this->validate([
                'title' => 'required|min_length[2]|max_length[60]|is_unique[classes.title,id,' . $id . ']',
                'max_week_lessons' => 'required|min_length[2]|max_length[60]'
            ])) {
                $class_data = [
                    'title' => $this->request->getVar('title'),
                    'max_week_lessons' => $this->request->getVar('max_week_lessons'),
                ];

                $this->classModel->update($class['id'], $class_data);

                return redirect()->to(base_url('/director/classes'))->with('success', 'Klasė sėkimingai atnaujinta');
            } else {
                $errors = $this->validator->listErrors();
            }
        } else {
            $errors = 'Klaida';
        }
        return redirect()->to(base_url('/director/classes'))->with('errors', $errors);
    }

    public function deleteClass($id)
    {
        $class = $this->classModel->find($id);
        if ($class) {
            $this->classModel->delete($class['id']);
            $this->teacherModel->set('class_id', 0, false)->where('class_id', $class['id'])->update();
            $this->studentModel->set('class_id', 0, false)->where('class_id', $class['id'])->update();

            return redirect()->to(base_url('/director/classes'))->with('success', 'Klasė sėkimingai ištrinta');
        } else {
            $errors = 'Klaida';
        }
        return redirect()->to(base_url('/director/classes'))->with('errors', $errors);
    }

}
