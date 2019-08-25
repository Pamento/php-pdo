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




$app->get('/getArticles/{id}',function (Request $request, Response $response, array $args) {
    $dao = new DaoPost();
    $daoUser = new DaoUser();
    $user = $daoUser->getById($args['id']);
	$articles = $dao->getAll($args['id']);
	return $this->view->render($response, 'articles.twig', [
        'articles'=> $articles,
        'user' => $user
	]);
})->setName('getArticles');




$app->get('/adduser', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'adduser.twig');
})->setName('adduser');

$app->post('/adduser', function (Request $request, Response $response, array $args) {
    $form = $request->getParsedBody();
    $newUser = new User($form['name'], $form['surname'], $form['username'], $form['email'],$form['password'] );
    $dao = new DaoUser();
		$dao->add($newUser);
		return $response->withRedirect('/');
		// or
		// $redirectUrl = $this->rouetr->pathFor('index');
		// return $response->withRedirect($redirectUrl);
		// not thisone
		// return $this->view->render($response, 'index.twig'
		// // , ['newId' => $newUser->getId()]
		// 	);
})->setName('index');




// ========= login ========= login ========= login ========= login ========= login ========= login
$app->get('/login', function (Request $request, Response $response, array $args) {
    $user = $_SESSION['user'];
    if(!empty($user)) {
        $daoArticle =  new DaoPost();
        $articles = $daoArticle->getByUser($user->getEmail());
      
        return $this->view->render($response, 'myBlog.twig',[
            'articles'=>$articles
        ]);
    }
    return $this->view->render($response, 'login.twig');
})->setName('login');
// ========= login ========= login ========= login ========= login ========= login ========= login
// ========= login ========= login ========= login ========= login ========= login ========= login
$app->post('/login', function (Request $request, Response $response, array $args) {
    $dao = new DaoUser();
    $daoArticle = new DaoPost();
    $form = $request->getParsedBody();
    $logUser = $dao->getByLogin($form['email'], $form['password']);

    if ($logUser ){
        $_SESSION['user'] = $logUser;

        return $response->withRedirect('/myBlog');// add afish message: "login denided"
    }
    return $response->withRedirect('/');// add afish message: "login denided"
})->setName('login');
// ========= login ========= login ========= login ========= login ========= login ========= login
$app->get('/myBlog', function (Request $request, Response $response, array $args) {
    $user = $_SESSION['user'];
    if(!empty($user)) {
        $daoArticle =  new DaoPost();
        $articles = $daoArticle->getByUser($user->getEmail());
      
        return $this->view->render($response, 'myBlog.twig',[
            'articles'=>$articles
        ]);
    }
    return $response->withRedirect('/');// add afish message: "login denided"
})->setName('myBlog');





$app->get('/updateuser/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoUser;
    $user = $dao->getById($args['id']);
    return $this->view->render($response, 'updateuser.twig', [
        'user' => $user
    ]);
})->setName('updateuser');
// ========= updateuser
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






$app->get('/deletepost/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoPost;
    $dao->delete($args['id']);
    $redirectUrl = $this->router->pathFor('myBlog');
    return $response->withRedirect($redirectUrl);
})->setName('deletepost');



$app->get('/updatepost/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoPost;
    $post = $dao->getById($args['id']);

    return $this->view->render($response, 'myBlog.twig', [
        'post' => $post
    ]);
})->setName('updatepost');
// ========= updatepost
$app->post('/updatepost/{id}', function (Request $request, Response $response, array $args) {
    $dao = new DaoPost;
    $postData = $request->getParsedBody();

    $post = $dao->getById($args['id']);
    $post->setTitle($postData['title']);
    $post->setArticle($postData['article']);
    $newPost = new Post($post);

    $dao->update($newPost);
    $redirectUrl = $this->router->pathFor('myBlog');
    return $response->withRedirect($redirectUrl);
})->setName('updatepost');

        // $app->get('/adduser', function (Request $request, Response $response, array $args) {
        //     return $this->view->render($response, 'adduser.twig');
        // })->setName('adduser');

        // $app->post('/adduser', function (Request $request, Response $response, array $args) {
        //     $form = $request->getParsedBody();
        //     $newUser = new User($form['name'], $form['surname'], $form['username'], $form['email'],$form['password'] );
        //     $dao = new DaoUser();
        //         $dao->add($newUser);
        //         return $response->withRedirect('/');
        // })->setName('index');