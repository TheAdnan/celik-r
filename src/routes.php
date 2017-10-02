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

$app->get('/uplata', function (Request $request, Response $response, array $args) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
