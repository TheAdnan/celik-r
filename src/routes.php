<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes


$app->get('/login', function (Request $request, Response $response, array $args) {
    if($this->session->exists('user_session')){
        $this->flash->addMessage('Success', 'You have successfully logged in');
        return $response->withRedirect('/clanovi');
    }
    $this->flash->addMessage('Failed', 'Wrong username or password!');
//    $messages = $this->flash->getMessages();
//    print_r($messages);
    return $this->renderer->render($response, 'login.phtml', $args);
});

$app->get('/logout', function (Request $request, Response $response, array $args) {
    if($this->session->exists('user_session')){
        unset($this->session->user_session);
    }
    return $response->withRedirect('/login');
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




//Forms

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

$app->post('/uplata/{id}', function (Request $request, Response $response, array $args) {
    if($this->session->exists('user_session')){
        $form_data = $request->getParams();
        if(isset($args["id"]) && isset($form_data["uplata"])){
            $clan = new Clan($this->db);
            if(!is_null($clan->get($args["id"]))){
                if(!isset($form_data["mjesec"])) $form_data["mjesec"] = date("m");
                if(!isset($form_data["godina"])) $form_data["godina"] = date("Y");
                $uplata = new Uplata($this->db);
                if(!$uplata->isPayed($args["id"], $form_data["mjesec"], $form_data["godina"])) $uplata->pay($args["id"], $form_data["mjesec"], $form_data["godina"]);
            }
            $this->flash->addMessage('Success', 'Payment successful');
            return $response->withRedirect('/uplata/' . $args["id"]);
        }
    }
    else{
        $this->flash->addMessage('Failed', 'An error occurred');
        return $response->withRedirect('/login');
    }
});

