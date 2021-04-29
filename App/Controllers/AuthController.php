<?php

namespace App\Controllers;

use App\Libs\DatabaseDriver;
use App\Services\Auth;
use App\Libs\Router;
use App\Libs\Request;
use App\Libs\Response;

Router::post('/login', function(Request $req, Response $res) {
    try {
        $resp = (new Auth(new DatabaseDriver()))->login($req->getJSON());
        return $res->status(200)->toJSON($resp);    
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage());    
    }

});

