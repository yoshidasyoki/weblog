<?php

namespace App\Services;

use App\Models\LoginModel;

class LoginService
{
    // private const MAX_USERNAME_LENGTH = 20;
    // private const MIN_PASSWORD_LENGTH = 8;
    // private const MAX_PASSWORD_LENGTH = 50;

    public function __construct(private LoginModel $loginModel) {}

    public function auth(string $email, string $password)
    {
        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'メールアドレスを入力してください';
        }

        if (empty($password)) {
            $errors['password'] = 'パスワードを入力してください';
        }

        if (!empty($errors)) {
            return ['flag' => false, 'errors' => $errors];
        }

        $user = $this->loginModel->findUserInfo($email);
        if (!$user || !$this->passAuth($password, $user['password'])) {
            $errors['auth'] = 'メールアドレスまたはパスワードが正しくありません';
        }

        return (!empty($errors))
            ? ['flag' => false, 'errors' => $errors]
            : ['flag' => true, 'user' => $user];
    }

    // public function register(string $username, string $email, string $password)
    // {
    //     if (!$this->validateInput($email, $password, $username)) {
    //         return false;
    //     }

    //     $user = $this->loginModel->findUserInfo($email);
    //     if ($user) {
    //         return false;
    //     }

    //     $this->loginModel->insertUser($username, $email, $password);
    // }

    private function passAuth(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    // private function validateInput(string $email, string $password, string $username): array
    // {
    //     $errors = [];

    //     $this->validateEmail($email, $errors);
    //     $this->validateUsername($username, $errors);
    //     $this->validatePassword($password, $errors);

    //     return (empty($errors))
    //         ? ['flag' => true]
    //         : ['flag' => false, 'errors' => $errors];
    // }

    // private function validateEmail(string $email, array $errors): void
    // {
    //     if (empty($email)) {
    //         $errors['email'] = 'メールアドレスを入力してください';
    //         return;
    //     }

    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $errors['email'] = 'メールアドレスの形式が正しくありません';
    //     }
    // }

    // private function validateUsername(string $username, array $errors): void
    // {
    //     if (empty($username)) {
    //         $errors['username'] = 'ユーザー名を入力してください';
    //     }

    //     if (mb_strlen($username) > self::MAX_USERNAME_LENGTH) {
    //         $errors['username'] = 'ユーザー名は20文字以下で設定してください';
    //     }
    // }

    // private function validatePassword(string $password, array $errors): void
    // {
    //     if (mb_strlen($password) < self::MIN_PASSWORD_LENGTH) {
    //         $errors['password'] = 'パスワードは8文字以上で設定してください';
    //     }

    //     if (mb_strlen($password) > self::MAX_PASSWORD_LENGTH) {
    //         $errors['password'] = 'パスワードは50文字以下で設定してください';
    //     }
    // }
}
