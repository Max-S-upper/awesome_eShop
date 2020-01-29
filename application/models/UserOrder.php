<?php


namespace application\models;


class UserOrder extends ActiveRecordEntity
{
    public $id;
    public $user_id;
    public $note;

    public function getLastIdByUserId($userId)
    {
        $userOrderData = $this->db->connection->query("SELECT id FROM users_orders WHERE user_id = $userId")->fetchAll();
        return array_pop($userOrderData)['id'];
    }

    public function save()
    {
        if ($this->id) {
            if ($this->user_id) $this->db->connection->query("UPDATE users_orders SET user_id = {$this->user_id} WHERE id = {$this->id}");
            if ($this->note) $this->db->connection->query("UPDATE users_orders SET note = {$this->note} WHERE id = {$this->id}");
        }

        else {
            return $this->db->connection->query("INSERT INTO users_orders(user_id, note) VALUES({$this->user_id}, '{$this->note}')");
        }
    }

    public function getTableName()
    {
        return 'users_orders';
    }
}