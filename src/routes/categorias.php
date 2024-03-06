<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/categorias', function () {

	$this->any('', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');

		$post = $Request->getParsedBody();
		$results = [];

		$post['form']['selects']['select_status'] = $this->session->get('select_status');

		$post['form']['id'] = $this->convert->checkIfExist($post['form']['id'], '');
		$post['form']['nome'] = $this->convert->checkIfExist($post['form']['nome'], '');
		$post['form']['status'] = $this->convert->checkIfExist($post['form']['status'], '1');

		$results = $this->mysql->fetchAll(
			'SELECT *
				FROM categorias 
				WHERE nome LIKE :nome
				AND id LIKE :id
				AND status = :status
				ORDER BY id ASC',
			[
				':id' => $post['form']['id'] . '%',
				':nome' => $post['form']['nome'] . '%',
				':status' => $post['form']['status'],
			]
		);


		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Categorias');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'categorias/main.php', [
			'results'	=> $results,
			"messages" => $this->flash->getMessages(),
			"user" => $this->session->get('auth'),
			"post"	=> $post
		]);
		return $phpView;
	});


	$this->any('/edit/{id:[0-9A-Za-z]+}', function ($Request, $Response, $args) {

		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		if ($post['form']['op'] == 'update') {
			$this->mysql->update('categorias', $post['registry'], ['id' => $args['id']]);
			return $Response->withStatus(302)->withHeader('Location', $args['id'] . '?msg=Categoria atualizada com sucesso');
		}

		$registry = [];
		$registry = $this->mysql->fetchAssoc(
			'SELECT * FROM categorias where id = :id',
			[
				':id' => $args['id']
			]
		);

		if (!$registry) {
			$this->flash->addMessageNow('ls-alert-danger', 'Categoria Inexistente');
			return $Response->withStatus(302)->withHeader('Location', '/categorias');
		}

		$registry['role'] = json_decode($registry['role'], true);

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Editar - Categorias');
		$phpView->addAttribute('operator', 'edit');
		$phpView->addAttribute('action', $_SERVER['REQUEST_URI']);
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'categorias/categoria-id.php', [
			'registry'	=> $registry,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	$this->any('/create', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Cadastrar - Categoria');
		$phpView->addAttribute('operator', 'create');
		$phpView->addAttribute('action', '/categorias/add');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'categorias/categoria-id.php', [
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);

		return $phpView;
	});

	$this->post('/add', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$this->mysql->insert('categorias', $post['registry']);

		return $Response->withStatus(302)->withHeader('Location', '/categorias?msg=Cadastro Realizado com Sucesso');
	});

	$this->get('/status/{id:[0-9A-Za-z]+}/{status:[0-9]+}', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$registry = [
			'status' => $args['status']
		];

		$this->mysql->update('categorias', $registry, ['id' => $args['id']]);

		return $Response->withStatus(302)->withHeader('Location', '/categorias?msg=Situação do usuário alterada com sucesso');
	});
})->add($middleware['auth']);
