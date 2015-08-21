<?php


namespace App\Models;


class TokenModel
{
    protected $database;

    function __construct($database)
    {
        $this->database = $database;
    }

    public function generate()
    {
        $token = md5((new \DateTime)->format(\DateTime::ISO8601));
        $this->database->insert('tokens',
            [
                'token'      => $token,
                'expiredate' => (new \DateTime)->add(new \DateInterval('PT1H'))->format('Y-m-d H:i:s')
            ]);
        return $token;
    }

    public function check($token)
    {
        $query = $this->database->prepare('SELECT id FROM tokens WHERE token = ? AND expiredate > ?');
        $query->bindValue(1, $token, \PDO::PARAM_STR);
        $query->bindValue(2, (new \DateTime), "datetime");
        $query->execute();

        return $query->fetch();
    }
}