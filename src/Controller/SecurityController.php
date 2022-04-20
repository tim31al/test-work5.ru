<?php

namespace App\Controller;

use App\Model\User;
use App\Service\Interfaces\ContainerInterface;
use App\Utils\UserValidationException;

class SecurityController extends AbstractController
{
    private User $model;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->model = $container->get(User::class);
    }

    public function register()
    {
        if ($this->isPost()) {
            $data = $_POST;
            try {
                $isRegister = $this->model->create($data);
            } catch (UserValidationException $e) {
                $error = $e->getMessage();
            }
        } else {
            $data = [
                'firstname' => '',
                'lastname' => '',
                'email' => '',
            ];
        }


        $this->render('register.php', [
            'title' => 'Регистрация',
            'data' => $data,
            'isRegister' => $isRegister ?? false,
            'error' => $error ?? null,
        ]);
    }

    public function logout()
    {
        $this->session->remove(static::SESSION_KEY);
        header('Location: /');
    }

    public function login()
    {
        if ($this->isPost()) {
            $data = $_POST;
            try {
                $user = $this->model->getUser($data);
                $this->setUser($user);

                header('Location: /profile');

            } catch (UserValidationException $e) {
                $error = $e->getMessage();
            }
        } else {
            $data = [
                'email' => '',
                'password' => ''
            ];
        }

        $title = 'Вход';
        $this->render('login.php', [
            'title' => $title,
            'data' => $data,
            'error' => $error ?? null,
        ]);
    }
}
