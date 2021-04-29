<?php
namespace App\Services;
use App\Libs\DatabaseDriver;
use App\Libs\Config;
use DateTimeImmutable;
use Doctrine\DBAL\DriverManager;
use PDO;
use PDOException;
use Firebase\JWT\JWT;

class Auth
{
    private $db;

    public function __construct(DatabaseDriver $ddb) {
        $this->db = @$ddb;
    }

    public function login($req) {
       $prepStmt = $this->db->pdo->prepare('select username,password from users where username = :username and password = :password');
       $prepStmt->bindValue(':username', $req->username, PDO::PARAM_STR);
       $prepStmt->bindValue(':password', $req->password, PDO::PARAM_STR);
       $prepStmt->execute();

       $result = $prepStmt->fetch(PDO::FETCH_ASSOC);
       if (!$result) {
           throw new \Exception("Wrong username/password.", 404);
       }

       return [
            'accessToken' => $this->generateToken()
       ];
    }

    private function generateToken() {
        $secretKey  = Config::get('secretKey');
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+30 minutes')->getTimestamp();      
        $serverName = Config::get('domainName');

        $data = [
            'iat'  => $issuedAt->getTimestamp(),         
            'iss'  => $serverName,                       
            'nbf'  => $issuedAt->getTimestamp(),        
            'exp'  => $expire,                           
        ];

        return JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );
    }

    public static function authorize() {
        if(!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            throw new \Exception("Unauthorized call.", 401);
        }

        $jwt = $matches[1];

        if(!$jwt) {
            throw new \Exception("Unauthorized call.", 401);
        }

        $secretKey  = Config::get('secretKey');
        $token = JWT::decode($jwt, $secretKey, ['HS512']);
        $now = new DateTimeImmutable();
        $serverName = Config::get('domainName');

        if ($token->iss !== $serverName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp())
        {
            throw new \Exception("Unauthorized call.", 401); // Refresh
        }

        return true;
        
    }

}