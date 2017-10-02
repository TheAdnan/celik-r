<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/clanovi', function (Request $request, Response $response, array $args) {
    // Render index view
    $clanovi = new Clan($this->db);
    $data = array('clanovi' => $clanovi->getAll());
    return $this->renderer->render($response, 'clanovi.phtml', $data);
});

$app->get('/uplata/{id}', function (Request $request, Response $response, array $args) {
    if(isset($args["id"])){
        $clan = new Clan($this->db);
        $uplata = new Uplata($this->db);
        $data = array('clan' => $clan->get($args["id"]), 'uplate' => $uplata->getAllForClan($args["id"]));
        return $this->renderer->render($response, 'uplata.phtml', $data);
    }
});

$app->get('/uplata', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
});
