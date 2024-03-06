<?php


use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/contato', function () {

	$this->any('', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Contato');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');
		$phpView = $this->renderer->render($Response, 'contato/main.php', [
			'messages' => $this->flash->getMessages()
		]);
		return $phpView;
	});
})->add($middleware['syncToSession'])->add($middleware['auth']);
