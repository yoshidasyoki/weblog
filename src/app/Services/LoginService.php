<?php

namespace App\Services;

use App\Core\DatabaseManager;
use App\Models\UserModel;

class LoginService
{
    private UserModel $userModel;

    public function __construct(private DatabaseManager $databaseManager)
    {
        $this->userModel = $this->databaseManager->getModel('UserModel');
    }

    public function auth(string $email, string $password)
    {
        $errors = [];
        $errors = $this->validateEmail($email, $errors);
        $errors = $this->validatePassword($password, $errors);

        if (!empty($errors)) {
            return ['flag' => false, 'errors' => $errors];
        }

        $user = $this->userModel->findUserInfo($email);
        if (!$user || !$this->passAuth($password, $user['password'])) {
            $errors[] = 'メールアドレスまたはパスワードが正しくありません';
        }

        return (!empty($errors))
            ? ['flag' => false, 'errors' => $errors]
            : ['flag' => true, 'user' => $user];
    }

    private function validateEmail(string $email, array $errors): array
    {
        if (empty($email)) {
            $errors[] = 'メールアドレスを入力してください';
        }

        return $errors;
    }

    private function validatePassword(string $password, array $errors): array
    {
        if (empty($password)) {
            $errors[] = 'パスワードを入力してください';
        }

        return $errors;
    }

    private function passAuth(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
