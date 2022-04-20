<?php

namespace App\Utils;

use App\Utils\UserValidationException;


class UserValidator
{
    private const REQUIRED_FIELDS = ['lastname', 'firstname', 'email', 'password'];
    private const PATTERN_NAME = '/^[A-zА-я]{3,50}$/u';
    private const PATTERN_PASSWORD = '/^[A-z\d]{6,50}$/';

    /**
     * @throws \App\Utils\UserValidationException
     */
    public function validateLogin(array $data): void
    {
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new UserValidationException('Bad email');
        }

        if (!isset($data['password'])) {
            throw new UserValidationException('Password required');
        }
    }

    /**
     * @throws \App\Utils\UserValidationException
     */
    public function validateUpdatePass(array $data): void
    {
        if (!$data['email'] || !$data['password'] || !$data['new_password']) {
            throw new UserValidationException('password, new_password required');
        }

        if (!preg_match(static::PATTERN_PASSWORD, $data['new_password'])) {
            throw new UserValidationException('Bad password');
        }
    }

    /**
     * @throws \App\Utils\UserValidationException
     */
    public function validateUpdateData(array $data): void
    {
        if (!$data['email'] || !$data['lastname'] || !$data['firstname']) {
            throw new UserValidationException('lastname, firstname required');
        }

        $this->validateUpdate($data);
    }

    /**
     * @throws \App\Utils\UserValidationException
     */
    public function validate(array $data): void
    {
        if (count(array_diff_key(array_flip(static::REQUIRED_FIELDS), $data))) {
            $message = 'fields: ' . (implode(',', static::REQUIRED_FIELDS)) . ' required';
            throw new UserValidationException($message);
        }

        $this->validateUpdate($data);

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new UserValidationException('Bad email');
        }

        if (!preg_match(static::PATTERN_PASSWORD, $data['password'])) {
            throw new UserValidationException('Bad password');
        }
    }


    /**
     * @throws \App\Utils\UserValidationException
     */
    private function validateUpdate(array $data): void
    {
        if (!preg_match(static::PATTERN_NAME, $data['lastname'])) {
            throw new UserValidationException('Bad lastname');
        }


        if (!preg_match(static::PATTERN_NAME, $data['firstname'])) {
            throw new UserValidationException('Bad firstname');
        }
    }

}
