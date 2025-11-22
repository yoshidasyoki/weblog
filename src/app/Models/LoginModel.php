<?php

namespace App\Models;

use App\Core\DatabaseModel;

class LoginModel extends DatabaseModel
{
    public function findUserInfo($email) {
        $sql = <<<EOT
            SELECT * FROM users
            WHERE email = :email AND deleted_at IS NULL
        EOT;

        $params = [
            ['placeholder' => ':email', 'value' => $email],
        ];

        return $this->fetchData($sql, $params, 'one');
    }

    // public function insertUser($username, $email, $password)
    // {
    //     $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    //     $sql = <<<EOT
    //         INSERT INTO users (username, email, password)
    //         VALUES (:username, :email, :password)
    //     EOT;

    //     $params = [
    //         ['placeholder' => ':username', 'value' => $username],
    //         ['placeholder' => ':email', 'value' => $email],
    //         ['placeholder' => ':password', 'value' => $passwordHash],
    //     ];

    //     return $this->executeQuery($sql, $params);
    // }
}
