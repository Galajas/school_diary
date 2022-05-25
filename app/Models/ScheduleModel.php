<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    const WEEK_DAY_MONDAY = ['monday', 'Pirmadienis'];
    const WEEK_DAY_TUESDAY= ['tuesday', 'Antradienis'];
    const WEEK_DAY_WEDNESDAY = ['wednesday', 'Trečiadienis'];
    const WEEK_DAY_THURSDAY= ['thursday', 'Ketvirtadienis'];
    const WEEK_DAY_FRIDAY = ['friday', 'Penktadienis'];

    const WEEK_DAYS = [
        self::WEEK_DAY_MONDAY,
        self::WEEK_DAY_TUESDAY,
        self::WEEK_DAY_WEDNESDAY,
        self::WEEK_DAY_THURSDAY,
        self::WEEK_DAY_FRIDAY
    ];

    protected $DBGroup          = 'default';
    protected $table            = 'schedules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_id',
        'lesson_number',
        'lesson_id',
        'teacher_id',
        'cabinet',
        'week_day',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    static public function getLessons(int $class_id)
    {
        $response = [];
        foreach (self::WEEK_DAYS as $week_day) {
            $response[$week_day[0]] = (new self())
                ->select('schedules.id, schedules.lesson_number, lessons.title')
                ->join('lessons', 'lessons.id = schedules.lesson_id', 'left')
                ->where('class_id', $class_id)
                ->where('week_day', $week_day[0])
                ->orderBy('lesson_number', 'ASC')
                ->findAll();
        }

        return $response;
    }
}
