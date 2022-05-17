<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\UserModel;

class StudentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'user_id',
        'class_id',
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

    public function getFullData(int $id)
    {
        $student = $this->find($id);
        if ($student) {
            $user = (new UserModel())->find($student['user_id']);
            if ($user) {
                return array_merge($user, $student);
            }
        }
        return false;
    }

    public function getWithRelations(int $id = null)
    {
        $data = $this
            ->select('students.id, users.email, users.firstname, users.lastname, classes.title as class, students.class_id, students.user_id')
            ->join('users', 'users.id = students.user_id')
            ->join('classes', 'classes.id = students.class_id', 'left');

        if ($id != null) {
            return $data->find($id);
        } else {
            return $data->findAll();
        }
    }
}
