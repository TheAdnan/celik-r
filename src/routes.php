<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes


$app->get('/login', function (Request $request, Response $response, array $args) {
    if($this->session->exists('user_session')){
        return $response->withRedirect('/clanovi');
    }
    return $this->renderer->render($response, 'login.phtml', $args);
});

$app->get('/logout', function (Request $request, Response $response, array $args) {
    if($this->session->exists('user_session')){
        unset($this->session->user_session);
        return $response->withRedirect('/login');
    }
    else{
        return $response->withRedirect('/login');
    }
});

$app->post('/login', function (Request $request, Response $response, array $args) {
    $form_data = $request->getParams();
    $login = new Site($this->db);
    if($login->login($form_data["username"], $form_data["password"])){
        $this->session->set('user_session', hash('joaat', $form_data["username"]));
        return $response->withRedirect('/clanovi');
    }
    else{
        return $response->withRedirect('/login');
    }
});


$app->get('/clanovi', function (Request $request, Response $response, array $args) {
    if($this->session->exists('user_session')){
        $clanovi = new Clan($this->db);
        $data = array('clanovi' => $clanovi->getAll());
        return $this->renderer->render($response, 'clanovi.phtml', $data);
    }
    else{
        return $response->withRedirect('/login');
    }
});

$app->get('/uplata/{id}', function (Request $request, Response $response, array $args) {
    if($this->session->exists('user_session')){
        if(isset($args["id"])){
            $clan = new Clan($this->db);
            $uplata = new Uplata($this->db);
            $data = array('clan' => $clan->get($args["id"]), 'uplate' => $uplata->getAllForClan($args["id"]));
            return $this->renderer->render($response, 'uplata.phtml', $data);
        }
    }
    else{
        return $response->withRedirect('/login');
    }
});

$app->get('/uplata', function (Request $request, Response $response, array $args) {
    if($this->session->exists('user_session')){
        return $this->renderer->render($response, 'index.phtml', $args);
    }
    else{
        return $response->withRedirect('/login');
    }
});
