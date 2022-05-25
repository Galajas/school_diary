<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{

    public function index()
    {
        return view('login');
    }

    public function login()
    {
        if ($this->validate([
            'password' => 'required|min_length[2]',
            'email' => 'required|valid_email',
        ])) {
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $user = (new UserModel())->where('email', $email)->where('password', md5($password))->first();
            if (!$user) {
                $this->validator->setError('email', 'Bad password');
            } else {
                unset($user['password']);
                $this->session->set('user', $user);
                switch ($user['type']) {
                    case 'director':

                        $route = '/director/index';
                        break;
                    case 'teacher':
                        $route = '/teacher/index';
                        break;
                    case 'student':
                        $route = '/student/index';
                        break;
                }
                return redirect()->to(base_url($route));
            }
        }
        return view('login', ['errors' => $this->validator->listErrors()]);
    }

    public function logout() {

        $this->session->remove('user');

        return redirect()->to(base_url('/'));
    }
}
