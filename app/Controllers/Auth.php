<?php

namespace App\Controllers;

use App\Models\UserAccountModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn') === true) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Enter both your username and password.');
        }

        $user = (new UserAccountModel())
            ->where('username', $username)
            ->first();

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid username or password.');
        }

        session()->regenerate();

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'username'   => $user['username'],
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')
            ->with('success', 'You have been logged out.');
    }
}