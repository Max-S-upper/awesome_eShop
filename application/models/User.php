<?php


namespace application\models;

use application\exceptions\AuthorizationException;
use application\Session;

class User extends ActiveRecordEntity
{
    public function checkUser($email, $password)
    {
        $stmt = $this->db->connection->query("SELECT password FROM users WHERE email = $email");
        if ($stmt) {
            $userPassword = $stmt->fetchColumn();
            if ($this->isPassword($userPassword, $password)) {
                Session::set('email', $email);
                $user = new self();
                $user->email = $email;
                return $user;
            }

            else throw new AuthorizationException("Wrong password");
        }

        else throw new AuthorizationException("Account with this email doesn't exist");
    }

    public function isPassword($userPassword, $password)
    {
        return password_verify($userPassword, $password);
    }

    public function getTableName()
    {
        return 'users';
    }
}