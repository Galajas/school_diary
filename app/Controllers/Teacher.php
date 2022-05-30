<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;
use App\Models\TeacherModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\ScheduleModel;
use App\Models\GradeModel;
use App\Models\AttendanceModel;
use App\Models\NoticeModel;


class Teacher extends BaseController
{
    protected $lessonModel;
    protected $classModel;
    protected $teacherModel;
    protected $studentModel;
    protected $userModel;
    protected $scheduleModel;
    protected $gradeModel;
    protected $attendanceModel;
    protected $noticeModel;


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
        $this->gradeModel = new GradeModel();
        $this->attendanceModel = new AttendanceModel();
        $this->noticeModel = new NoticeModel();
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

    public function teacherSchedule(string $date = null, string $show_class = null)
    {
        $teacher = $this->teacherModel->where('user_id', session()->user['id'])->first();

        $data = [
            'teacher_schedule' => $this->scheduleModel->getTeacherLessons($teacher['id'], $date),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];

        if ($date != null) {
            $data['date'] = $date;
        }

        if ($show_class != null) {
            $data['show_class'] = $this->classModel->getStudents($show_class);
        }

        return view('users/teacher/teacher_schedule', $data);
    }

    public function showLessons()
    {
        if ($this->validate([
            'selected_date' => 'required|valid_date[Y-m-d]',
        ])) {
            $selected_date = $this->request->getVar('selected_date');
            return redirect()->to(base_url('/teacher/teacherSchedule/' . $selected_date));
        }
        return redirect()->to(base_url('/teacher/teacherSchedule'))->with('errors', 'Bloga data');
    }

    public function studentAction(string $date = null, string $show_class = null, string $student_id = null)
    {
        $teacher = $this->teacherModel->where('user_id', session()->user['id'])->first();

        if ($this->validate([
            'student_action' => 'required',
        ])) {
            $student_action = $this->request->getVar('student_action');

            $grades = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            $attendance_status = ['n', 'p'];
            $positive = ['geras', 'šaunuolis', 'puikus', 'ger', 'blog', 'šaun', 'aktyvus', 'klusnus','pavyzdingas', 'aktyv', 'pavyzd'];
            $positive = implode('|', $positive);

            $negative = ['blogas', 'neklauso', 'blog', 'nekla', 'tingus', 'tingi'];
            $negative = implode('|', $negative);

            switch ($student_action) {
                case in_array($student_action, $grades):
                    $grade_data = [
                        'lesson_id' => $teacher['lesson_id'],
                        'teacher_id' => $teacher['id'],
                        'student_id' => $student_id,
                        'grade' => $student_action,
                        'created_at' => $date
                    ];
                    $this->gradeModel->insert($grade_data);
                    return redirect()->to(base_url('/teacher/teacherSchedule/' . $date . '/' . $show_class))->with('success', 'Pažymys sėkimingai įrašytas');
                    break;
                case in_array($student_action, $attendance_status):
                    $attendance_data = [
                        'lesson_id' => $teacher['lesson_id'],
                        'teacher_id' => $teacher['id'],
                        'student_id' => $student_id,
                        'status' => $student_action,
                        'created_at' => $date,
                    ];
                    $this->attendanceModel->insert($attendance_data);
                    return redirect()->to(base_url('/teacher/teacherSchedule/' . $date . '/' . $show_class))->with('success', 'Lankomumas sėkimingai įrašyta');
                    break;
                case (preg_match('/'. $positive .'/', strtolower($student_action), $matches)):
                    $positive_data = [
                        'lesson_id' => $teacher['lesson_id'],
                        'teacher_id' => $teacher['id'],
                        'student_id' => $student_id,
                        'message' => $student_action,
                        'status' => 'positive',
                        'created_at' => $date,
                    ];
                    $this->noticeModel->insert($positive_data);
                    return redirect()->to(base_url('/teacher/teacherSchedule/' . $date . '/' . $show_class))->with('success', 'Pastaba sėkimingai įrašyta');
                    break;
                case (preg_match('/'. $negative .'/', strtolower($student_action), $matches)):
                    $negative_data = [
                        'lesson_id' => $teacher['lesson_id'],
                        'teacher_id' => $teacher['id'],
                        'student_id' => $student_id,
                        'message' => $student_action,
                        'status' => 'negative',
                        'created_at' => $date,
                    ];
                    $this->noticeModel->insert($negative_data);
                    return redirect()->to(base_url('/teacher/teacherSchedule/' . $date . '/' . $show_class))->with('success', 'Pastaba sėkimingai įrašyta');
                    break;
                default:
                    $other_data = [
                        'lesson_id' => $teacher['lesson_id'],
                        'teacher_id' => $teacher['id'],
                        'student_id' => $student_id,
                        'message' => $student_action,
                        'status' => 'other',
                        'created_at' => $date,
                    ];
                    $this->noticeModel->insert($other_data);
                    return redirect()->to(base_url('/teacher/teacherSchedule/' . $date . '/' . $show_class))->with('success', 'Pastaba sėkimingai įrašyta');
                    break;
            }


        }
        return redirect()->to(base_url('/teacher/teacherSchedule'))->with('errors', 'Neatpažintas veiksmas');
    }


}
