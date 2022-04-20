<?php

namespace App\Controller;


use App\Service\Interfaces\ContainerInterface;
use App\Service\Interfaces\SessionInterface;

abstract class AbstractController
{
    const SESSION_KEY = 'user';

    protected SessionInterface $session;

    private string $templatesDir;
    private string $layout;

    public function __construct(ContainerInterface $container)
    {
        $this->templatesDir = $container->get('templates_dir');
        $this->layout = $container->get('layout');
        $this->session = $container->get(SessionInterface::class);
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function setUser(array $user)
    {
        unset($user['password']);
        $userData = json_encode($user);
        $this->session->set(static::SESSION_KEY, $userData);
    }

    protected function getUser(): ?array
    {
       $data = $this->session->get(static::SESSION_KEY);

       return $data ? json_decode($data, true) : null;
    }


    /**
     * Render page
     *
     * @param string $template
     * @param array $args
     * @return void
     */
    protected function render(string $template, array $args)
    {
        extract($args);

        ob_start();
        require $this->templatesDir . $template;

        $content = ob_get_clean();
        $user = $this->getUser();

        include $this->templatesDir . $this->layout;
    }
}
