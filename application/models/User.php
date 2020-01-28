<?php


namespace application\models;

use application\components\exceptions\AuthorizationException;
use application\components\exceptions\RegistrationException;
use core\Session;

class User extends ActiveRecordEntity
{
    public $id;
    public $name;
    public $surname;
    public $email;
    public $password;
    public $phone;
    public $roleId;
    public $isBlocked;

    public function emailExists($email)
    {
        return $this->db->connection->query("SELECT id, password FROM users WHERE email = '$email'")->fetchAll()[0];
    }


    public function isPassword($userPassword, $password)
    {
        return password_verify($password, $userPassword);
    }

    public function save()
    {
        if ($this->id) {
            if ($this->name) $this->db->connection->query("UPDATE users SET name = {$this->name} WHERE id = {$this->id}");
            if ($this->surname) $this->db->connection->query("UPDATE users SET surname = {$this->surname} WHERE id = {$this->id}");
            if ($this->email) $this->db->connection->query("UPDATE users SET email = {$this->email} WHERE id = {$this->id}");
            if ($this->phone) $this->db->connection->query("UPDATE users SET phone = {$this->phone} WHERE id = {$this->id}");
            if ($this->roleId) $this->db->connection->query("UPDATE users SET role_id = {$this->roleId} WHERE id = {$this->id}");
            if ($this->isBlocked) $this->db->connection->query("UPDATE users SET isBlocked = {$this->isBlocked} WHERE id = {$this->id}");
        }

        else {
            if ($this->emailExists($this->email)) throw new RegistrationException("Account with this email already exists");
            else $this->db->connection->query("INSERT INTO users(name, surname, email, password, phone, role_id, is_blocked) VALUES('{$this->name}', '{$this->surname}', '{$this->email}', '{$this->password}', '{$this->phone}', {$this->roleId}, {$this->isBlocked})");
        }
    }

    public function getTableName()
    {
        return 'users';
    }
}