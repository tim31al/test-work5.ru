<?php

namespace App\Model;

use App\Utils\UserValidationException;
use App\Utils\UserValidator;
use PDO;

class User
{
    private const TABLE = 'users';

    private PDO $pdo;
    private UserValidator $validator;

    /**
     * @param \PDO $pdo
     */
    public function __construct(PDO $pdo, UserValidator $validator)
    {
        $this->pdo = $pdo;
        $this->validator = $validator;
    }


    /**
     * @throws \App\Utils\UserValidationException
     */
    public function create(array $data): bool
    {
        $this->validator->validate($data);

        $user = $this->findOne($data['email']);
        if ($user) {
            throw new UserValidationException('User exists');
        }

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
     * @throws \App\Utils\UserValidationException
     */
    public function getUser(array $data): ?array
    {
        $this->validator->validateLogin($data);

        $user = $this->findOne($data['email']);
        if (!password_verify($data['password'], $user['password'])) {
            throw new UserValidationException('Bad password');
        }

        return $user;
    }


    /**
     * @throws \App\Utils\UserValidationException
     */
    public function updatePassword(array $data): bool
    {
        $this->validator->validateUpdatePass($data);

        $user = $this->findOne($data['email']);
        if (!password_verify($data['password'], $user['password'])) {
            throw new UserValidationException('Bad old password');
        }

        $passwordHash = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $sql = 'UPDATE ' . static::TABLE . ' SET password = ?';
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
     * @throws \App\Utils\UserValidationException
     */
    public function update(array $data): ?array
    {
        $this->validator->validateUpdateData($data);

        $sql = 'UPDATE ' . static::TABLE . ' SET lastname = ?, firstname = ? WHERE email = ?';
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

    public function init()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . static::TABLE . '(' .
            'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ' .
            'lastname VARCHAR(50) NOT NULL, ' .
            'firstname VARCHAR(50) NOT NULL, ' .
            'email VARCHAR(50) NOT NULL UNIQUE, ' .
            'password VARCHAR(255) NOT NULL' .
            ')';

        $this->pdo->query($sql);

        try {
            $sql = 'CREATE INDEX idx_user_email ON ' . static::TABLE . '(email)';
            $this->pdo->query($sql);
        } catch (\Exception $e) {
        }
    }
}
