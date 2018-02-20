<?php

use Slim\Http\Request;
use Slim\Http\Response;
use pdoblog\entities\User;
use pdoblog\entities\Post;
use pdoblog\dao\DaoUser;
use pdoblog\dao\DaoPost;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    $dao = new DaoUser();
    $users = $dao->getAll();
    return $this->view->render($response, 'index.twig', [
        'users' => $users
    ]);
})->setName('index');

$app->get('/adduser', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'adduser.twig');
})->setName('adduser');



$app->post('/adduser', function (Request $request, Response $response, array $args) {
    $form = $request->getParsedBody();
    $newUser = new User($form['name'], $form['surname'], $form['username'], $form['email']);
    $dao = new DaoUser();
    $dao->add($newUser);
    return $this->view->render($response, 'adduser.twig', [
        'newId' => $newUser->getId()
    ]);
})->setName('adduser');

$app->get('/updateuser/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoUser;
    $user = $dao->getById($args['id']);
    return $this->view->render($response, 'updateuser.twig', [
        'user' => $user
    ]);
})->setName('updateuser');

$app->post('/updateuser/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoUser;
    $postData = $request->getParsedBody();
    $user = $dao->getById($args['id']);
    $user->setName($postData['name']);
    $user->setSurname($postData['surname']);
    $user->setUsername($postData['username']);
    $user->setEmail($postData['email']);
    // $user->set($postData['pass']);
    $dao->update($user);
    $redirectUrl = $this->router->pathFor('index');
    return $response->withRedirect($redirectUrl);
})->setName('updateuser');

$app->get('/deleteuser/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoUser;
    $dao->delete($args['id']);
    $redirectUrl = $this->router->pathFor('index');
    return $response->withRedirect($redirectUrl);
})->setName('deleteuser');