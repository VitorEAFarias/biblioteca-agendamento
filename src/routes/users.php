<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/users', function () {

	$this->any('', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');

		$post = $Request->getParsedBody();
		$results = [];

		$post['form']['selects']['select_status'] = $this->session->get('select_status');

		$post['form']['id'] = $this->convert->checkIfExist($post['form']['id'], '');
		$post['form']['nome'] = $this->convert->checkIfExist($post['form']['nome'], '');
		$post['form']['email'] = $this->convert->checkIfExist($post['form']['email'], '');
		$post['form']['status'] = $this->convert->checkIfExist($post['form']['status'], '1');
		$post['form']['selects']['users_roles'] = $this->session->get('users_roles');

		$results = $this->mysql->fetchAll(
			'SELECT *
				FROM users 
				WHERE nome LIKE :nome
				AND id LIKE :id
				AND email LIKE :email
				AND status = :status
				ORDER BY nome ASC',
			[
				':id' => $post['form']['id'] . '%',
				':nome' => $post['form']['nome'] . '%',
				':email' => $post['form']['email'] . '%',
				':status' => $post['form']['status'],
			]
		);

		foreach ($results as $index => $item) {
			$role = json_decode($item['role'], true);
			$results[$index]['role'] = $role['role'];
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Usuários');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'users/main.php', [
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

		$post['form']['selects']['users_roles'] = $this->session->get('users_roles');

		if ($post['form']['op'] == 'update') {
			$post['registry']['role'] = json_encode($post['form']['selects']['users_roles'][$post['registry']['role']]);

			$this->mysql->update('users', $post['registry'], ['id' => $args['id']]);
			// $this->flash->addMessageNow('ls-alert-success', 'Usuário atualizado com sucesso');
			return $Response->withStatus(302)->withHeader('Location', $args['id'] . '?msg=Usuário atualizado com sucesso');
		}

		$registry = [];
		$registry = $this->mysql->fetchAssoc(
			'SELECT * FROM users where id = :id',
			[
				':id' => $args['id']
			]
		);

		if (!$registry) {
			$this->flash->addMessageNow('ls-alert-danger', 'Usuário Inexistente');
			return $Response->withStatus(302)->withHeader('Location', '/users');
		}

		$registry['role'] = json_decode($registry['role'], true);

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Editar - Usuário');
		$phpView->addAttribute('operator', 'edit');
		$phpView->addAttribute('action', $_SERVER['REQUEST_URI']);
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'users/user-id.php', [
			'registry'	=> $registry,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	$this->any('/create', function ($Request, $Response, $args) {

		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$post['form']['selects']['users_roles'] = $this->session->get('users_roles');

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Cadastrar - Usuário');
		$phpView->addAttribute('operator', 'create');
		$phpView->addAttribute('action', '/users/add');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'users/user-id.php', [
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);

		return $phpView;
	});

	$this->post('/add', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$post['form']['selects']['users_roles'] = $this->session->get('users_roles');

		$post['registry']['role'] = json_encode($post['form']['selects']['users_roles'][$post['registry']['role']]);

		$post['registry']['status'] = 1;

		$this->mysql->insert('users', $post['registry']);
		// $this->flash->addMessage('ls-alert-success', 'Cadastro Realizado com Sucesso');

		return $Response->withStatus(302)->withHeader('Location', '/users?msg=Cadastro Realizado com Sucesso');
	});

	$this->get('/status/{id:[0-9A-Za-z]+}/{status:[0-9]+}', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$registry = [
			'status' => $args['status'],
			'update_date' => date('Y-m-d H:i:s')
		];

		$this->mysql->update('users', $registry, ['id' => $args['id']]);
		// $this->flash->addMessage('ls-alert-success', 'Situação do usuário alterada com sucesso');

		return $Response->withStatus(302)->withHeader('Location', '/users?msg=Situação do usuário alterada com sucesso');
	});
})->add($middleware['auth']);
