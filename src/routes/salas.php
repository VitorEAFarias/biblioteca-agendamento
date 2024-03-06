<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/salas', function () {

	$now = date('Y-m-d');


	$this->any('', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$results = $this->mysql->fetchAll(
			'SELECT * from local order by nomeLocal ASC',
			[
				':nomeLocal' => $post['form']['nomeLocal'] . '%',
			]
		);

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Auditórios');
		$phpView->addAttribute('action', '/salas');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'salas/main.php', [
			'results'	=> $results,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	$this->any('/all', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$results = $this->mysql->fetchAll(
			'SELECT * from local order by nomeLocal ASC',
			[
				':nomeLocal' => $post['form']['nomeLocal'] . '%',
			]
		);

		foreach ($results as $index => $result) {
			$results[$index]['agendamentos'] = $post['form']['selects']['solicitante'][$result['solicitante']]['name'];
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Todos Registros');
		$phpView->addAttribute('action', '/field-search-form/all');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'salas/main.php', [
			'results'	=> $results,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});



	/*formulario de cadastro*/

	$this->any('/form', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Cadastro de auditórios - Biblioteca');
		$phpView->addAttribute('action', '/salas/send-search');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'salas/form.php', [
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);


		return $phpView;
	});

	$this->any('/form/{id:[0-9]+}', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();


		$post['local'] = $this->mysql->fetchAssoc(
			'SELECT * FROM local WHERE local_id = :id',
			[':id' => $args['id']]
		);

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Cadastro de auditórios - Biblioteca');
		$phpView->addAttribute('action', '/salas/update-search');
		$phpView->addAttribute('operator', 'edit');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'salas/form.php', [
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);

		return $phpView;
	});


	$this->post('/send-search', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();


		$local = $post['local'];
		unset($local['local_id']);

		$local['create_date'] = date('Y-m-d H:i:s');
		$local['update_date'] = date('Y-m-d H:i:s');

		$this->mysql->insert('local', $local);

		return $Response->withRedirect('/salas?msg=Auditório Cadastrado com Sucesso!', 301);
	});

	$this->post('/update-search', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$local = $post['local'];
		$local['update_date'] = date('Y-m-d H:i:s');

		//$local['last_user'] = $user['id'];

		$id = $local['local_id'];
		unset($local['local_id']);

		$this->mysql->update('local', $local, ['local_id' => $id]);

		return $Response->withRedirect('/salas/form/' . $id . '?msg=Local atualizado com sucesso!', 301);
	});
})->add($middleware['auth']);
