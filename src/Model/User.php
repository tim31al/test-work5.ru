<?php

namespace App\Model;

use PDO;

class User
{
    private const TABLE = 'users';
    private const REQUIRED_FIELDS = ['lastname', 'firstname', 'email', 'password'];
    private const PATTERN_NAME = '/^[A-zА-я]{3,50}$/u';
    private const PATTERN_PASSWORD = '/^[A-z\d]{6,50}$/';

    private PDO $pdo;

    /**
     * @param \PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws \App\Model\UserValidationException
     */
    public function create(array $data): bool
    {
        $this->validate($data);

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO ' . static::TABLE . ' (lastname, firstname, email, password) ' .
            'VALUES (?, ?, ?, ?)';
        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(1, $data['lastname']);
        $smtp->bindParam(2, $data['firstname']);
        $smtp->bindParam(3, $data['email']);
        $smtp->bindParam(4, $passwordHash);

        try {
            $smtp->execute();
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * @throws \App\Model\UserValidationException
     */
    public function getUser(array $data): ?array
    {
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new UserValidationException('Bad email');
        }

        if (!isset($data['password'])) {
            throw new UserValidationException('Password required');
        }

        $user = $this->findOne($data['email']);
        if (!password_verify($data['password'], $user['password'])) {
            throw new UserValidationException('Bad password');
        }

        return $user;
    }

    /**
     * @throws \App\Model\UserValidationException
     */
    public function updatePassword(array $data): bool
    {
        if (!$data['email'] || !$data['password'] || !$data['new_password']) {
            throw new UserValidationException('password, new_password required');
        }

        if (!preg_match(static::PATTERN_PASSWORD, $data['new_password'])) {
            throw new UserValidationException('Bad password');
        }

        $user = $this->findOne($data['email']);
        if (!password_verify($data['password'], $user['password'])) {
            throw new UserValidationException('Bad old password');
        }

        $passwordHash = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $sql = 'UPDATE '.static::TABLE. ' SET password = ?';
        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(1, $passwordHash);

        try {
            $smtp->execute();
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * @throws \App\Model\UserValidationException
     */
    public function update(array $data): ?array
    {
        if (!$data['email'] || !$data['lastname'] || !$data['firstname']) {
            throw new UserValidationException('lastname, firstname required');
        }
        $this->validateUpdate($data);

        $sql = 'UPDATE '.static::TABLE. ' SET lastname = ?, firstname = ? WHERE email = ?';
        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(1, $data['lastname']);
        $smtp->bindParam(2, $data['firstname']);
        $smtp->bindParam(3, $data['email']);

        try {
            $smtp->execute();
            return $this->findOne($data['email']);
        } catch (\PDOException $e) {
            return null;
        }
    }

    private function findOne(string $email): ?array
    {
        $sql = 'SELECT * FROM ' . static::TABLE . ' WHERE email = ? LIMIT 1';
        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(1, $email);
        $smtp->execute();
        $user = $smtp->fetch();
        if (!$user) {
            return null;
        }

        return $user;
    }

    /**
     * @throws \App\Model\UserValidationException
     */
    private function validateUpdate(array $data) {
        if (!preg_match(static::PATTERN_NAME, $data['lastname'])) {
            throw new UserValidationException('Bad lastname');
        }


        if (!preg_match(static::PATTERN_NAME, $data['firstname'])) {
            throw new UserValidationException('Bad firstname');
        }
    }

    /**
     * @throws \App\Model\UserValidationException
     */
    private function validate(array $data)
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

        $user = $this->findOne($data['email']);
        if ($user) {
            throw new UserValidationException('User exists');
        }
    }

    public function init()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . static::TABLE . '(' .
            'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ' .
            'lastname VARCHAR(50) NOT NULL, ' .
            'firstname VARCHAR(50) NOT NULL, ' .
            'email VARCHAR(50) NOT NULL, ' .
            'password VARCHAR(255) NOT NULL' .
            ')';

        $this->pdo->query($sql);
    }


}
