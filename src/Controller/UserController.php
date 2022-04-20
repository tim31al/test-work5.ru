<?php

namespace App\Controller;

use App\Model\User;
use App\Service\Interfaces\ContainerInterface;
use App\Utils\UserValidationException;

class UserController extends AbstractController
{
    private const TITLE = 'Профиль пользователя';

    private User $model;

    /**
     * @param \App\Service\Interfaces\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->model = $container->get(User::class);
    }

    public function profile()
    {
        $user = $this->getUser();

        if (!$user) {
            header('Location: /login');
        }


        $uri = $_SERVER['REQUEST_URI'];

        if (strpos($uri, 'change_data')) {
            $this->changeData($user);
            return;
        }

        if (strpos($uri, 'change_pass')) {
            $this->changePassword($user);
            return;
        }

        $this->render('profile.php', [
            'title' => static::TITLE,
            'user' => $user,
        ]);
    }

    private function changeData(array $userData)
    {
        if ($this->isPost()) {
            $data = $_POST;
            $data['email'] = $userData['email'];

            try {
                $user = $this->model->update($data);
                $this->setUser($user);

                header('Location: /profile');
            } catch (UserValidationException $e) {
                $error = $e->getMessage();
            }
        } else {
            $data = $userData;
        }

        $this->render('profile-change-data.php', [
            'title' => static::TITLE,
            'user' => $data,
            'error' => $error ?? null,
        ]);

    }

    private function changePassword(array $userData)
    {
        if ($this->isPost()) {
            $data = $_POST;
            $data['email'] = $userData['email'];

            try {
                if ($this->model->updatePassword($data)) {
                    header('Location: /profile');
                }
            } catch (UserValidationException $e) {
                $error = $e->getMessage();
            }
        }

        $this->render('profile-change-pass.php', [
            'title' => 'Сменить пароль',
            'error' => $error ?? null,
        ]);
    }
}
