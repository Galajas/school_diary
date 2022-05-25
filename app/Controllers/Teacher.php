<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;
use App\Models\TeacherModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\ScheduleModel;

class Teacher extends BaseController
{
    protected $lessonModel;
    protected $classModel;
    protected $teacherModel;
    protected $studentModel;
    protected $userModel;
    protected $scheduleModel;


    public function __construct()
    {
        if (isset(session()->user)) {
            if (session()->user['type'] != 'teacher') {
                dd('galima tik mokytojui');
            }
        } else {
            dd('Prasome prisijungti');
        }

        $this->classModel = new ClassModel();
        $this->lessonModel = new LessonModel();
        $this->teacherModel = new TeacherModel();
        $this->studentModel = new StudentModel();
        $this->userModel = new UserModel();
        $this->scheduleModel = new ScheduleModel();
    }

    public function index()
    {
        $teacher = $this->teacherModel->where('user_id', session()->user['id'])->first();

        $data = [
            'students' => $this->classModel->getStudents($teacher['class_id']),
            'teacher' => $this->teacherModel->getWithRelations($teacher['id'])
        ];

        if ($teacher['class_id'] != null) {
            $data['class'] = $this->classModel->find($teacher['class_id']);
        }

        return view('users/teacher/home', $data);
    }

    public function schedulesSettings()
    {
        $teacher = $this->teacherModel->where('user_id', session()->user['id'])->first();

        $data = [
            'week_days' => ScheduleModel::WEEK_DAYS,
            'teachers' => $this->teacherModel
                ->select('teachers.id, users.email, users.firstname, users.lastname, lessons.title as lesson')
                ->join('users', 'users.id = teachers.user_id')
                ->join('lessons', 'lessons.id = teachers.lesson_id', 'left')
                ->where('lesson_id !=', 0)
                ->findAll(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
            'schedule' => ScheduleModel::getLessons($teacher['class_id']),
            'count_lessons' => count($this->scheduleModel->where('class_id', $teacher['class_id'])->findAll())
        ];

        if ($teacher['class_id'] != null) {
            $data['class'] = $this->classModel->find($teacher['class_id']);
        }


        return view('users/teacher/schedules_settings', $data);
    }

    public function addLesson()
    {
        if ($this->validate([
            'week_day' => 'required|in_list[' . implode(',', array_column(ScheduleModel::WEEK_DAYS, 0)) . ']',
            'lesson_number' => 'required|integer|exact_length[1]',
            'teacher_id' => 'required|is_not_unique[teachers.id]',
            'cabinet' => 'required|string|min_length[1]|max_length[30]',
        ])) {
            $teacher = $this->teacherModel->where('user_id', session()->user['id'])->first();

            $schedule = $this->scheduleModel
                ->where('class_id', $teacher['class_id'])
                ->where('week_day', $this->request->getVar('week_day'))
                ->where('lesson_number', $this->request->getVar('lesson_number'))
                ->first();

            if (!$schedule) {
                $user = $this->teacherModel->where('user_id', session()->user['id'])->first();
                $class_id = $user['class_id'];

                $teacher = $this->teacherModel->where('id', $this->request->getVar('teacher_id'))->first();
                $schedule_data = [
                    'class_id' => $class_id,
                    'lesson_number' => $this->request->getVar('lesson_number'),
                    'lesson_id' => $teacher['lesson_id'],
                    'teacher_id' => $teacher['id'],
                    'cabinet' => $this->request->getVar('cabinet'),
                    'week_day' => $this->request->getVar('week_day'),
                ];

                $this->scheduleModel->insert($schedule_data);

                return redirect()->to(base_url('/teacher/schedulesSettings'))->with('success', 'Pamoka sėkmingai pridėta prie tvarkaraščio');
            } else {
                $errors = 'Laikas užimtas';
            }
        } else {
            $errors = $this->validator->listErrors();
        }
        return redirect()->to(base_url('/teacher/schedulesSettings'))->with('errors', $errors);
    }

    public function deleteLesson()
    {
        if ($this->validate([
            'delete_lesson' => 'required|is_not_unique[schedules.id]',
        ])) {
            $lesson_id = $this->request->getVar('delete_lesson');
            $lesson = $this->scheduleModel->find($lesson_id);

            if ($lesson) {
                $this->scheduleModel->delete($lesson['id']);

                return redirect()->to(base_url('/teacher/schedulesSettings'))->with('success', 'Pamoka sėkimingai ištrinta');
            }
        } else {
            $errors = $this->validator->listErrors();
        }
        return redirect()->to(base_url('/teacher/schedulesSettings'))->with('errors', $errors);
    }

    public function teacherLessons() {


        $date = date('l', strtotime("2022-05-25"));

        $teacher = $this->teacherModel->where('user_id', session()->user['id'])->first();

        $teacher_lessons = $this->scheduleModel
            ->where('week_day', $date)
            ->where('teacher_id', $teacher['id'])
            ->findAll();

        dd($teacher_lessons);

//        $data = [
//            'date' => date("Y-m-d"),
//            'teacher_lessons' =>
//        ];



        return view('users/teacher/teacher_lessons', $data);
    }

    public function showLessons() {
        $selected_date = $this->request->getVar('selected_date');

        dd($selected_date);
    }

}
