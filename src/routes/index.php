<?php 

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response, array $args) {
	
	$phpView = $this->renderer;
	$phpView->addAttribute('title', 'Login');
	
	$this->renderer->setLayout('index.php');
	$phpView = $this->renderer->render($response, 'index/login.phtml', [
		"messages" => $this->flash->getMessages()
	]);
	
	return $phpView;
	
});

