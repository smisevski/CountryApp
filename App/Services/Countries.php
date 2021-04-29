<?php

namespace App\Services;

use App\Libs\DatabaseDriver;
use PDO;
use App\Libs\RESTHelper;
use PDOException;
use \DateTime;

class Countries
{
    public function __construct(DatabaseDriver $ddb)
    {
        $this->db = @$ddb;
    }

    public function addToFavorites($req)
    {
        $prepStmt = $this->db->pdo->prepare('insert into favorites(country_id, user_id, is_removed, created_on) values(:country_id, :user_id, :is_removed, :created_on)');
        $prepStmt->bindValue(':country_id', $req->country_id, PDO::PARAM_STR);
        $prepStmt->bindValue(':user_id', $req->user_id, PDO::PARAM_INT);
        $prepStmt->bindValue(':is_removed', 0, PDO::PARAM_BOOL);
        $prepStmt->bindValue(':created_on', (new DateTime())->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        try {
            $prepStmt->execute();
            return $req;
        } catch (\PDOException $pdoEx) {
            throw new \Exception($pdoEx->getMessage(), $pdoEx->getCode());
        }
    }

    public function removeFromFavorites($req)
    {
        $prepStmt = $this->db->pdo->prepare('update favorites set is_removed = 1 where country_id = :country_id');
        $prepStmt->bindValue(':country_id', $req->country_id, PDO::PARAM_STR);
        try {
            $prepStmt->execute();
            return $this->getFavorites();
        } catch (\PDOException $pdoEx) {
            throw new \Exception($pdoEx->getMessage(), $pdoEx->getCode());
        }
    }

    public function getFavorites()
    {
        $prepStmt = $this->db->pdo->prepare('select * from favorites where is_removed = 0 and user_id = :user_id order by created_on desc');
        $prepStmt->bindValue(':user_id', 1, PDO::PARAM_INT);
        $prepStmt->execute();
        $result = $prepStmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new \Exception("Not found.", 404);
        }

        $url = 'https://restcountries.eu/rest/v2/alpha?codes=';

        foreach ($result as $row) {
            $url = $url . strtolower($row['country_id']) . ';';
        }

        try {
            return json_decode(RESTHelper::CallAPI('GET', $url));
        } catch (\PDOException $pdoEx) {
            throw new \Exception($pdoEx->getMessage(), $pdoEx->getCode());
        }
    }
}
