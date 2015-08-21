<?php

namespace App\Models;


class UserModel
{
    protected $database;

    function __construct($database)
    {
        $this->database = $database;
    }

    public function save($username, $description)
    {
        $this->database->insert("users", ['username' => $username, 'description' => $description]);
        return $this->database->lastInsertId();
    }

    public function update($id, $username, $description)
    {
        return $this->database->update('users', ['username' => $username, 'description' => $description],
            ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->database->delete("users", ['id' => $id]);
    }

    public function getAll()
    {
        return $this->database->fetchAll('SELECT id, username, description FROM users');
    }

}