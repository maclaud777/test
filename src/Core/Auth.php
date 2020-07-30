<?php

namespace Core;

use \App\Models\User;

/**
 * Class Auth
 * @package Core
 */
class Auth
{
    /**
     * @var User
     */
    public User $user;

    /**
     * @var bool
     */
    protected bool $isAuth = false;

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->isAuth;
    }

    /**
     *
     */
    public function init()
    {
        $userSession = App::$session->get('user', null);

        if (empty($userSession['id'])) {
            return;
        }

        /** @var User $user */
        $user = User::findById($userSession['id']);
        if (!$user) {
            return;
        }

        if (User::generateSessionHash($userSession['hash']) !== $user->sessionHash) {
            return;
        }

        $this->isAuth = true;
        $this->user = $user;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function auth($username, $password)
    {
        $userModel = User::findByUsername($username);
        if (!$userModel) {
            return false;
        }

        if (!$this->passwordVerify($password, $userModel->passwordHash)) {
            return false;
        }

        $hash = md5(time() . $userModel->id);

        $userModel->updateSessionHash(User::generateSessionHash($hash));

        App::$session->set('user', [
            'id'   => $userModel->id,
            'hash' => $hash,
        ]);

        return true;
    }

    /**
     * @param $password
     * @return false|string|null
     */
    private function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    private function passwordVerify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}