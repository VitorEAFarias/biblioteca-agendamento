<?php

// Application middleware
// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new \Slim\Middleware\Session([
	'name' => 'IB',
	'autorefresh' => true,
	'lifetime' => '1 day'
]));

$middleware['syncToSession'] = function ($Request, $Response, $next) {
	//$this->session->delete('users_roles');

	$this->session->delete('horario');
	$this->session->delete('lugares');

	$response = $next($Request, $Response);

	$this->session->set('select_status', [
		['id' => 0, 'name' => 'Desativado'],
		['id' => 1, 'name' => 'Ativo'],
	]);

	$this->session->set('agendamento_status', [
		['value' => 0, 'name' => 'Em análise'],
		['value' => 1, 'name' => 'Não Aprovado'],
		['value' => 2, 'name' => 'Aprovado'],
		['value' => 3, 'name' => 'Cancelado'],
	]);

	$this->session->set('users_roles', [
		['id' => 0, 'role' => 'Administrador', 'access' => 0],
		['id' => 1, 'role' => 'Suporte', 'access' => 1],
		['id' => 2, 'role' => 'Coordenador', 'access' => 2],
		['id' => 3, 'role' => 'Grupo de Email', 'access' => 3],
	]);


	$this->session->set('img_locais', [
		['value' => '1', 'arquivo' => 'Pasteur.png'],
		['value' => '2', 'arquivo' => 'BerthelotECalmette.png'],
		['value' => '3', 'arquivo' => 'BerthelotECalmette.png'],
	]);

	return $response;
};

$middleware['auth'] = function ($Request, $Response, $next) {
	if (!$this->session->exists('auth')) {
		return $Response->withStatus(200)->withHeader('Location', '/');
	}

	$response = $next($Request, $Response);

	return $response;
};
