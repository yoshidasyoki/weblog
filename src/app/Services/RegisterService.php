<?php

namespace App\Services;

use App\Models\RegisterModel;

class RegisterService
{
    private const MAX_USERNAME_LENGTH = 20;
    private const MIN_PASSWORD_LENGTH = 8;
    private const MAX_PASSWORD_LENGTH = 50;

    public function __construct(private RegisterModel $registerModel)
    {
    }

    public function register(string $username, string $email, string $password)
    {
        $errors = $this->validateInput($email, $password, $username);
        if (!empty($errors)) {
            return ['flag' => false, 'errors' => $errors];
        }

        if ($this->hasRegisterEmail($email)) {
            $errormsg = ['email' => 'このメールアドレスは既に登録されています'];
            return ['flag' => false, 'errors' => $errormsg];
        }

        $this->registerModel->insertUser($username, $email, $password);
    }

    private function validateInput(string $email, string $password, string $username): array
    {
        $errors = [];

        $errors += $this->validateEmail($email, $errors);
        $errors += $this->validateUsername($username, $errors);
        $errors += $this->validatePassword($password, $errors);

        return $errors;
    }

    private function validateEmail(string $email, array $errors): array
    {
        if (empty($email)) {
            $errors['email'] = 'メールアドレスを入力してください';
            return $errors;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'メールアドレスの形式が正しくありません';
            return $errors;
        }

        return $errors;
    }

    private function validateUsername(string $username, array $errors): array
    {
        if (empty($username)) {
            $errors['username'] = 'ユーザー名を入力してください';
            return $errors;
        }

        if (mb_strlen($username) > self::MAX_USERNAME_LENGTH) {
            $errors['username'] = 'ユーザー名は20文字以下で設定してください';
            return $errors;
        }

        return $errors;
    }

    private function validatePassword(string $password, array $errors): array
    {
        if (mb_strlen($password) < self::MIN_PASSWORD_LENGTH) {
            $errors['password'] = 'パスワードは8文字以上で設定してください';
            return $errors;
        }

        if (mb_strlen($password) > self::MAX_PASSWORD_LENGTH) {
            $errors['password'] = 'パスワードは50文字以下で設定してください';
            return $errors;
        }

        return $errors;
    }

    private function hasRegisterEmail(string $email)
    {
        return !empty($this->registerModel->findEmail($email));
    }
}
