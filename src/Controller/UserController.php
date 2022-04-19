<?php

namespace App\Controller;

use App\Model\User;
use App\Model\UserValidationException;
use App\Service\Session;

class UserController extends AbstractController
{
    private const SESSION_KEY = 'user';

    private User $model;
    private Session $session;

    /**
     * @param \App\Model\User $model
     */
    public function __construct(string $templateDir, User $model, Session $session)
    {
        parent::__construct($templateDir);
        $this->model = $model;
        $this->session = $session;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $data = [
                'firstname' => '',
                'lastname' => '',
                'email' => '',
                'password' => ''
            ];

        } else {
            $data = $_POST;
            try {
                $isRegister = $this->model->create($data);
            } catch (UserValidationException $e) {
                $error = $e->getMessage();
            }
        }


        $title = 'Регистрация';
        include $this->templatesDir . 'register.php';
    }

    public function logout()
    {
        $this->session->remove(static::SESSION_KEY);
        header('Location: /');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $data = [
                'email' => '',
                'password' => ''
            ];
        } else {
            $data = $_POST;
            try {
                $user = $this->model->getUser($data);
                $this->setUser($user);

                header('Location: /profile');

            } catch (UserValidationException $e) {
                $error = $e->getMessage();
            }
        }

        $title = 'Вход';
        include $this->templatesDir . 'login.php';
    }

    public function profile()
    {
        $userStored = $this->session->get(static::SESSION_KEY);

        if (!$userStored) {
            header('Location: /login');
        }

        $title = 'Профиль пользователя';
        $user = json_decode($userStored, true);

        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, 'change_data')) {
            $this->changeData($user);
        } elseif (strpos($uri, 'change_pass')) {
            $this->changePassword($user);
        } else {
            include $this->templatesDir . 'profile.php';
        }
    }

    private function changeData(array $userData)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['email'] = $userData['email'];

            try {
                $user = $this->model->update($data);
                $this->setUser($user);

                header('Location: /profile');
            } catch (UserValidationException $e) {
                $user = $data;
                $error = $e->getMessage();
                include $this->templatesDir . 'profile-change-data.php';
            }
        } else {
            $user = $userData;
            include $this->templatesDir . 'profile-change-data.php';
        }
    }

    private function changePassword(array $userData)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['email'] = $userData['email'];

            try {
                if($this->model->updatePassword($data)) {
                    header('Location: /profile');
                }
            } catch (UserValidationException $e) {
                $error = $e->getMessage();
            }
        }

        include $this->templatesDir . 'profile-change-pass.php';
    }

    private function setUser(array $user)
    {
        unset($user['password']);
        $userData = json_encode($user);
        $this->session->set(static::SESSION_KEY, $userData);
    }

}
