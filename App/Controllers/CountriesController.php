<?php

namespace App\Controllers;

use App\Libs\DatabaseDriver;
use App\Services\Countries;
use App\Services\Auth;
use App\Libs\Router;
use App\Libs\Request;
use App\Libs\Response;
use App\Libs\RESTHelper;

Router::get('/countries', function(Request $req, Response $res) {
    try {
        Auth::authorize();
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage());
    }

    try {
        return $res->status(200)->toJSON(json_decode(RESTHelper::CallAPI('GET', 'https://restcountries.eu/rest/v2/all?limit=20&offset=0'))); 
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage()); 
    }
});

Router::post('/countries/favorites/add', function(Request $req, Response $res) {
    try {
        Auth::authorize();
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage());
    }

    try {
        $result = (new Countries(new DatabaseDriver()))->addToFavorites($req->getJSON());
        return $res->status(200)->toJSON($result); 
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage()); 
    }
});

Router::post('/countries/favorites/remove', function(Request $req, Response $res) {
    try {
        Auth::authorize();
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage());
    }

    try {
        $result = (new Countries(new DatabaseDriver()))->removeFromFavorites($req->getJSON());
        return $res->status(200)->toJSON($result); 
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage()); 
    }
});

Router::get('/countries/favorites', function(Request $req, Response $res) {
    try { 
        Auth::authorize();
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage());
    }

    try {
        $result = (new Countries(new DatabaseDriver()))->getFavorites();
        return $res->status(200)->toJSON($result); 
    } catch (\Exception $ex) {
        return $res->status($ex->getCode())->toJSON($ex->getMessage()); 
    }
});