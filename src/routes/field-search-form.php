<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Google_Client as GoogleClient;
use Google_Service\Calendar as Google_Service_Calendar;

$app->group('/field-search-form', function () {

	$now = date('Y-m-d');

	$this->any('', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$results = $this->mysql->fetchAll(
			'SELECT * from eventos order by create_date'
		);


		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Todos Agendamentos');
		$phpView->addAttribute('action', '/field-search-form');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/main.php', [
			'results'	=> $results,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	/*em análise  = 0*/
	$this->any('/analise', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$auditorios = $this->mysql->fetchAll('SELECT * from local order by nomeLocal ASC');

		$post['form']['solicitante'] = $this->convert->checkIfExist($post['form']['solicitante'], '');
		$post['form']['ramal'] = $this->convert->checkIfExist($post['form']['ramal'], '');
		$post['form']['nomeEvento'] = $this->convert->checkIfExist($post['form']['nomeEvento'], '');

		$results = $this->mysql->fetchAll(
			'SELECT   *
			FROM eventos
			WHERE status = 0 
			AND solicitante LIKE :solicitante
			AND ramal LIKE :ramal
			AND nomeEvento LIKE :nomeEvento
			ORDER BY evento_id DESC',
			[
				':solicitante' => '%' . $post['form']['solicitante'] . '%',
				':ramal' => '%' . $post['form']['ramal'] . '%',
				':nomeEvento' => '%' . $post['form']['nomeEvento'] . '%',
			]
		);

		foreach ($results as $index => $result) {
			$results[$index]['agendamentos'] = $post['form']['selects']['solicitante'][$result['solicitante']]['name'];
		}

		if ($post['form']['op'] == 'generate') {
			$phpView = $this->renderer;

			$phpView = $this->renderer->render($Response, 'csv/main.php', [
				'results'	=> $results,
				'auditorios'	=> $auditorios,
				"messages" => $this->flash->getMessages(),
				"post"	=> $post
			]);
			return $phpView;
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Agendamentos em análise');
		$phpView->addAttribute('action', '/field-search-form/analise');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/main.php', [
			'results'	=> $results,
			'auditorios'	=> $auditorios,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	/*nova data = 1*/
	$this->any('/nao_aprovado', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$auditorios = $this->mysql->fetchAll('SELECT * from local order by nomeLocal ASC');

		$post['form']['solicitante'] = $this->convert->checkIfExist($post['form']['solicitante'], '');
		$post['form']['ramal'] = $this->convert->checkIfExist($post['form']['ramal'], '');
		$post['form']['nomeEvento'] = $this->convert->checkIfExist($post['form']['nomeEvento'], '');

		$results = $this->mysql->fetchAll(
			'SELECT   *
			FROM eventos
			WHERE status = 1 
			AND solicitante LIKE :solicitante
			AND ramal LIKE :ramal
			AND nomeEvento LIKE :nomeEvento
			ORDER BY evento_id DESC',
			[
				':solicitante' => '%' . $post['form']['solicitante'] . '%',
				':ramal' => '%' . $post['form']['ramal'] . '%',
				':nomeEvento' => '%' . $post['form']['nomeEvento'] . '%',
			]
		);

		foreach ($results as $index => $result) {
			$results[$index]['agendamentos'] = $post['form']['selects']['solicitante'][$result['solicitante']]['name'];
		}

		if ($post['form']['op'] == 'generate') {
			$phpView = $this->renderer;

			$phpView = $this->renderer->render($Response, 'csv/main.php', [
				'results'	=> $results,
				'auditorios'	=> $auditorios,
				"messages" => $this->flash->getMessages(),
				"post"	=> $post
			]);
			return $phpView;
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Agendamentos Não Aprovados');
		$phpView->addAttribute('action', '/field-search-form/nao_aprovado');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/main.php', [
			'results'	=> $results,
			'auditorios'	=> $auditorios,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	/*aprovado = 2*/

	$this->any('/aprovado', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$auditorios = $this->mysql->fetchAll('SELECT * from local order by nomeLocal ASC');

		$post['form']['solicitante'] = $this->convert->checkIfExist($post['form']['solicitante'], '');
		$post['form']['ramal'] = $this->convert->checkIfExist($post['form']['ramal'], '');
		$post['form']['nomeEvento'] = $this->convert->checkIfExist($post['form']['nomeEvento'], '');

		$results = $this->mysql->fetchAll(
			'SELECT top(100) *
			FROM eventos as a
			Inner join local as b on b.local_id = a.local_id
			WHERE a.status = 2 
			AND a.solicitante LIKE :solicitante
			AND a.ramal LIKE :ramal
			AND a.nomeEvento LIKE :nomeEvento
			ORDER BY a.evento_id DESC',

			[
				':solicitante' => '%' . $post['form']['solicitante'] . '%',
				':ramal' => '%' . $post['form']['ramal'] . '%',
				':nomeEvento' => '%' . $post['form']['nomeEvento'] . '%',
			]
		);
		foreach ($results as $index => $result) {
			$results[$index]['agendamentos'] = $post['form']['selects']['solicitante'][$result['solicitante']]['name'];
		}

		if ($post['form']['op'] == 'generate') {
			$phpView = $this->renderer;

			$phpView = $this->renderer->render($Response, 'csv/main.php', [
				'results'	=> $results,
				'auditorios'	=> $auditorios,
				"messages" => $this->flash->getMessages(),
				"post"	=> $post
			]);
			return $phpView;
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Agendamentos Aprovados');
		$phpView->addAttribute('action', '/field-search-form/aprovado');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/main.php', [
			'results'	=> $results,
			'auditorios'	=> $auditorios,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	/*recusado = 3*/
	$this->any('/cancelado', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$auditorios = $this->mysql->fetchAll('SELECT * from local order by nomeLocal ASC');

		$post['form']['solicitante'] = $this->convert->checkIfExist($post['form']['solicitante'], '');
		$post['form']['ramal'] = $this->convert->checkIfExist($post['form']['ramal'], '');
		$post['form']['nomeEvento'] = $this->convert->checkIfExist($post['form']['nomeEvento'], '');

		$results = $this->mysql->fetchAll(
			'SELECT top(100) *
			FROM eventos
			WHERE status = 3
			AND solicitante LIKE :solicitante
			AND ramal LIKE :ramal
			AND nomeEvento LIKE :nomeEvento
			ORDER BY evento_id DESC',
			[
				':solicitante' => '%' . $post['form']['solicitante'] . '%',
				':ramal' => '%' . $post['form']['ramal'] . '%',
				':nomeEvento' => '%' . $post['form']['nomeEvento'] . '%',
			]
		);

		foreach ($results as $index => $result) {
			$results[$index]['agendamentos'] = $post['form']['selects']['solicitante'][$result['solicitante']]['name'];
		}

		if ($post['form']['op'] == 'generate') {
			$phpView = $this->renderer;

			$phpView = $this->renderer->render($Response, 'csv/main.php', [
				'results'	=> $results,
				'auditorios'	=> $auditorios,
				"messages" => $this->flash->getMessages(),
				"post"	=> $post
			]);
			return $phpView;
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Agendamentos Cancelados');
		$phpView->addAttribute('action', '/field-search-form/cancelado');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/main.php', [
			'results'	=> $results,
			'auditorios'	=> $auditorios,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	/*agendamentos do dia*/
	$this->any('/today', function ($Request, $Response, $args) {
		$now = date('Y-m-d');
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$auditorios = $this->mysql->fetchAll('SELECT * from local order by nomeLocal ASC');

		$post['form']['solicitante'] = $this->convert->checkIfExist($post['form']['solicitante'], '');
		$post['form']['ramal'] = $this->convert->checkIfExist($post['form']['ramal'], '');
		$post['form']['nomeEvento'] = $this->convert->checkIfExist($post['form']['nomeEvento'], '');

		$results = $this->mysql->fetchAll(
			'SELECT * from [eventos] where evento_id in (
				select evento_id from eventos
				where 
				CAST(dataInicial as date) = CAST(GETDATE() as date)) 
				and status NOT IN (0,3)
			AND solicitante LIKE :solicitante
			AND ramal LIKE :ramal
			AND nomeEvento LIKE :nomeEvento
			ORDER BY evento_id DESC',
			[
				':solicitante' => '%' . $post['form']['solicitante'] . '%',
				':ramal' => '%' . $post['form']['ramal'] . '%',
				':nomeEvento' => '%' . $post['form']['nomeEvento'] . '%',
				':now' => $now,
			]
		);

		foreach ($results as $index => $result) {
			$results[$index]['agendamentos'] = $post['form']['selects']['solicitante'][$result['solicitante']]['name'];
		}

		if ($post['form']['op'] == 'generate') {
			$phpView = $this->renderer;

			$phpView = $this->renderer->render($Response, 'csv/main.php', [
				'results'	=> $results,
				'auditorios'	=> $auditorios,
				"messages" => $this->flash->getMessages(),
				"post"	=> $post
			]);
			return $phpView;
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Agendamentos do dia');
		$phpView->addAttribute('action', '/field-search-form/today');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/main.php', [
			'results'	=> $results,
			'auditorios'	=> $auditorios,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	$this->any('/all', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$auditorios = $this->mysql->fetchAll('SELECT * from local order by nomeLocal ASC');

		$post['form']['solicitante'] = $this->convert->checkIfExist($post['form']['solicitante'], '');
		$post['form']['nomeEvento'] = $this->convert->checkIfExist($post['form']['nomeEvento'], '');

		if (empty($post['form']['data']) && empty($post['form']['data_final'])) {
			$results = $this->mysql->fetchAll(
				'SELECT TOP 200 eventos.*, 
									CASE
											WHEN TRY_CAST(eventos.categoria AS int) IS NOT NULL THEN 
													(SELECT nome FROM categorias WHERE id = CAST(eventos.categoria AS int))
											ELSE eventos.categoria
									END AS categoria_nome
					FROM eventos
					WHERE eventos.solicitante LIKE :solicitante
					AND eventos.nomeEvento LIKE :nomeEvento
					ORDER BY eventos.evento_id DESC',
				[
					':solicitante' => '%' . $post['form']['solicitante'] . '%',
					':nomeEvento' => '%' . $post['form']['nomeEvento'] . '%'
				]
			);
		} else {
			$results = $this->mysql->fetchAll(
				'SELECT TOP 200 eventos.*, 
									CASE
											WHEN TRY_CAST(eventos.categoria AS int) IS NOT NULL THEN 
													(SELECT nome FROM categorias WHERE id = CAST(eventos.categoria AS int))
											ELSE eventos.categoria
									END AS categoria_nome
					FROM eventos
					WHERE eventos.solicitante LIKE :solicitante
					AND eventos.nomeEvento LIKE :nomeEvento
					AND eventos.dataInicial BETWEEN :dataInicial AND :dataFinal
					ORDER BY eventos.evento_id DESC',
				[
					':solicitante' => '%' . $post['form']['solicitante'] . '%',
					':nomeEvento' => '%' . $post['form']['nomeEvento'] . '%',
					':dataInicial' => $post['form']['data'],
					':dataFinal' => $post['form']['data_final']
				]
			);
		}

		foreach ($results as $index => $result) {
			$results[$index]['agendamentos'] = $post['form']['selects']['solicitante'][$result['solicitante']]['name'];
		}

		if ($post['form']['op'] == 'generate') {
			$phpView = $this->renderer;

			$phpView = $this->renderer->render($Response, 'csv/main.php', [
				'results'	=> $results,
				'auditorios'	=> $auditorios,
				"messages" => $this->flash->getMessages(),
				"post"	=> $post
			]);
			return $phpView;
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Todos Registros');
		$phpView->addAttribute('action', '/field-search-form/all');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/main.php', [
			'results'	=> $results,
			'auditorios'	=> $auditorios,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	/*formulario de cadastro*/

	$this->any('/two', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$post['form']['selects']['select_status'] = $this->session->get('select_status');
		$post['form']['selects']['agendamento_status'] = $this->session->get('agendamento_status');
		$post['form']['selects']['users_roles'] = $this->session->get('users_roles');
		$post['form']['selects']['lugares'] = $this->session->get('lugares');

		$post['agendamentos']['dataInicial'] = $this->convert->checkIfExist($post['agendamentos']['dataInicial'], date('Y-m-d'));
		// $post['agendamentos']['dataFinal']   = $this->convert->checkIfExist($post['agendamentos']['dataFinal'], date('Y-m-d'));
		$post['agendamentos']['dataFinal']   = $post['agendamentos']['dataInicial'];

		$categorias = $this->mysql->fetchAll("SELECT * FROM categorias");

		$colaboradores = $this->mysqlRH->fetchAll(
			"SELECT id, nome, cpf, matricula, cc, Universal_id, centrocusto FROM `Geral`.vw_integracao_RH_AD WHERE status <> 3 AND status <> 'DEMITIDO' ORDER BY nome ASC"
		);

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Agendamento de salas e auditórios');
		$phpView->addAttribute('action', '/field-search-form/send-search');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/two.php', [
			"messages" => $this->flash->getMessages(),
			"categorias" => $categorias,
			"post"	=> $post,
			"colaboradores" => $colaboradores
		]);

		return $phpView;
	});

	$this->any('/two/{id:[0-9]+}', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$resultslocal = [];

		$post['agendamentos'] = $this->mysql->fetchAssoc(
			'SELECT * FROM eventos WHERE evento_id = :id',
			[':id' => $args['id']]
		);

		$post['locais'] = $this->mysql->fetchAll(
			'SELECT * FROM local WHERE disponivel = 1'
		);

		$post['categorias'] = $this->mysql->fetchAll(
			'SELECT * FROM categorias WHERE status = 1'
		);

		$post['locais'] = $post['locais'];
		$post['form']['selects']['horario']            = $this->session->get('horario');
		$post['form']['selects']['agendamento_status'] = $this->session->get('agendamento_status');
		$post['form']['selects']['lugares']            = $this->session->get('lugares');

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Agendamento de salas e auditórios');
		$phpView->addAttribute('action', '/field-search-form/update-search');
		$phpView->addAttribute('operator', 'edit');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/two.php', [
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);

		return $phpView;
	});

	$this->any('/two-read/{id:[0-9]+}', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$post['agendamentos'] = $this->mysql->fetchAssoc(
			'SELECT * FROM eventos WHERE evento_id = :id',
			[':id' => $args['id']]
		);

		$post['locais'] = $this->mysql->fetchAll(
			'SELECT * FROM local WHERE disponivel = 1'
		);

		$post['locais']           = $post['locais'];

		$post['form']['selects']['horario']            = $this->session->get('horario');
		$post['form']['selects']['agendamento_status'] = $this->session->get('agendamento_status');
		$post['form']['selects']['lugares']            = $this->session->get('lugares');

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Agendamento de auditórios - Biblioteca');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'field-search-form/two-read.php', [
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);

		return $phpView;
	});

	$this->post('/send-search', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		$novasDatas = json_decode($post['agendamentos']['datas'], true);

		foreach ($novasDatas as $key => $value) {
			$post['agendamentos']['create_date'] = date("Y-m-d H:i:s");
			$post['agendamentos']['update_date'] = date("Y-m-d H:i:s");

			$post['agendamentos']['horaInicialCafe'] = $post['agendamentos']['horaInicialCafe'] != "" ? $post['agendamentos']['horaInicialCafe'] : '00:00:00';
			$post['agendamentos']['horaFinalCafe'] = $post['agendamentos']['horaFinalCafe'] != "" ? $post['agendamentos']['horaFinalCafe'] : '00:00:00';

			$agendamentos = $post['agendamentos'];

			unset($agendamentos['evento_id']);
			unset($agendamentos['datas']);

			$arrData1 = explode('/', $value['date']);
			$agendamentos['dataInicial'] = "$arrData1[2]-$arrData1[1]-$arrData1[0]";
			$arrData2 = explode('/', $value['date']);
			$agendamentos['dataFinal'] = "$arrData2[2]-$arrData2[1]-$arrData2[0]";
			$agendamentos['horaInicial'] = date('H:i', strtotime($value['startTime']));
			$agendamentos['horaFinal'] = date('H:i', strtotime($value['endTime']));

			$agendamentos['create_user'] = $user['id'];
			$agendamentos['last_user'] = $user['id'];
			$agendamentos['visivel'] = '';
			$agendamentos['local_id'] = '';

			$this->mysql->insert('eventos', $agendamentos);

			$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
			$this->mailer->addAddress('biblioteca.atendimento@butantan.gov.br');
			//$this->mailer->addAddress('vitor.farias@fundacaobutantan.org.br');
			$this->mailer->CharSet = 'UTF-8';
			$this->mailer->Encoding = 'base64';
			$this->mailer->Subject = 'Solicitação de Agendamento';

			$this->mailer->Body = $this->mail_template->getTemplateByName(
				'new.php',
				[
					'agendamentos' => $agendamentos,
					'locais' => $post['locais']
				]
			);

			if (!$this->mailer->send()) {
				var_dump($this->mailer->ErrorInfo);
			}
		}

		return $Response->withRedirect('/agendamentos/historico?msg=Agendamento realizado com sucesso!', 301);
	});

	$this->post('/update-search', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		unset($post['agendamentos']['datas']);
		$agendamentos = $post['agendamentos'];
		$agendamentos['update_date'] = date('Y-m-d H:i:s');

		$agendamentos['dataInicial'] = $this->convert->date($agendamentos['dataInicial']);
		// $agendamentos['dataFinal'] = $this->convert->date($agendamentos['dataFinal']);
		$agendamentos['dataFinal'] = $agendamentos['dataInicial'];

		$agendamentos['last_user'] = $user['id'];

		$id = $agendamentos['evento_id'];
		unset($agendamentos['evento_id']);


		$this->mysql->update('eventos', $agendamentos, ['evento_id' => $id]);

		$post['locais'] = $this->mysql->fetchAll(
			'SELECT * FROM local WHERE disponivel = 1'
		);

		if ($agendamentos['status'] == 1) {

			$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
			$this->mailer->addAddress($agendamentos['email'], $agendamentos['solicitante']);
			$this->mailer->CharSet = 'UTF-8';
			$this->mailer->Encoding = 'base64';
			$this->mailer->Subject = 'Agendamento Não Aprovado - ' . $agendamentos['nomeEvento'];

			$this->mailer->Body = $this->mail_template->getTemplateByName(
				'not_aproved.php',
				[
					'agendamentos' => $agendamentos,
					'locais' => $post['locais']
				]
			);

			if (!$this->mailer->send()) {
				var_dump($this->mailer->ErrorInfo);
			}
		}

		if ($agendamentos['status'] == 2) {

			$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
			$this->mailer->addAddress($agendamentos['email'], $agendamentos['solicitante']);
			$this->mailer->Subject = 'Agendamento Aprovado - ' . $agendamentos['nomeEvento'];
			$this->mailer->CharSet = 'UTF-8';
			$this->mailer->Encoding = 'base64';

			$this->mailer->Body = $this->mail_template->getTemplateByName(
				'aproved.php',
				[
					'agendamentos' => $agendamentos,
					'locais' => $post['locais']
				]
			);

			if (!$this->mailer->send()) {
				var_dump($this->mailer->ErrorInfo);
			}
		}

		if ($agendamentos['status'] == 3) {

			$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
			$this->mailer->addAddress($agendamentos['email'], $agendamentos['solicitante']);
			$this->mailer->Subject = 'Agendamento Cancelado - ' . $agendamentos['nomeEvento'];
			$this->mailer->CharSet = 'UTF-8';
			$this->mailer->Encoding = 'base64';

			$this->mailer->Body = $this->mail_template->getTemplateByName(
				'canceled.php',
				[
					'agendamentos' => $agendamentos,
					'locais' => $post['locais']
				]
			);
			//$this->mailer->Body = $sendMail['descricao'];

			if (!$this->mailer->send()) {
				var_dump($this->mailer->ErrorInfo);
			}
		}

		$stmt = $this->mysql->prepare("EXEC USP_VALIDA_EVENTO");
		$stmt->execute();


		return $Response->withRedirect('/field-search-form/two/' . $id . '?msg=Atualização realizada com sucesso!', 301);
	});

	$this->any('/send-mail', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$sendMail = $post['sendMail'];

		$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
		$this->mailer->addAddress($sendMail['destino_email'], $sendMail['destino_nome']);
		$this->mailer->Subject = $sendMail['assunto'];

		$this->mailer->Body = $this->mail_template->getTemplateByName(
			'mail.php',
			['sendMail' => $sendMail]
		);

		if (!$this->mailer->send()) {
			var_dump($this->mailer->ErrorInfo);
		}

		return $Response->withRedirect('/field-search-form/all', 301);
	});

	$this->any('/send-mail-out', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$sendMail = $post['sendMailOut'];

		$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
		$this->mailer->addAddress($sendMail['destino']);
		$this->mailer->Subject = $sendMail['assunto'];
		$this->mailer->CharSet = 'UTF-8';
		$this->mailer->Encoding = 'base64';

		$this->mailer->Body = $this->mail_template->getTemplateByName(
			'mailOut.php',
			['sendMail' => $sendMail]
		);
		//$this->mailer->Body = $sendMail['descricao'];

		if (!$this->mailer->send()) {
			var_dump($this->mailer->ErrorInfo);
		}

		return $Response->withRedirect('/field-search-form/all', 301);
	});

	$this->any('/send-ical', function ($Request, $Response, $args) {
		date_default_timezone_set('America/Sao_Paulo');
		$post = $Request->getParsedBody();
		$sendMail = $post['sendMail'];

		$add_Day_point = 0;
		if ($sendMail['quantidade_repeticao'] > 0) {
			$add_Day = '+' . $add_Day_point . ' day';
			// 20210811T150000Z
			$dateStart = date("Ymd", strtotime($sendMail['dataInicial'] . $add_Day));
			$dateStart_title = date("d/m/Y", strtotime($sendMail['dataInicial'] . $add_Day));
			$timeStart = date("His", strtotime($sendMail['dataInicial']));
			$start = $dateStart . 'T' . $timeStart . 'Z';

			$DateEnd = date("Ymd", strtotime($sendMail['dataFinal']  . $add_Day));
			$TimeEnd = date("His", strtotime($sendMail['dataFinal']));
			$end = $DateEnd . 'T' . $TimeEnd . 'Z';

			$add_Day_point += $sendMail['frequencia_dias'];

			// -----------------------------

			$uid = md5($sendMail['evento_id'] . '#ibutantan.local' . $start) . '@butantan.gov.br';

			$date = date_create();
			$datestamp = date_format($date, 'Ymd');
			$horastamp = date_format($date, 'His');

			$datestamp = $datestamp . 'T' . $horastamp;

			$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
			$this->mailer->addAddress($sendMail['destino_email'], $sendMail['destino_nome']);
			$this->mailer->Subject = $sendMail['assunto'];

			$this->mailer->Body = $sendMail['nomeEvento'];
			$this->mailer->IsHTML(FALSE);
			$ical_content = '
			BEGIN:VCALENDAR
			PRODID:-//Google Inc//Google Calendar 70.9054//EN
			VERSION:2.0
			X-WR-TIMEZONE:America/Sao_Paulo
			CALSCALE:GREGORIAN
			METHOD:REQUEST
			BEGIN:VEVENT
			DTSTAMP:' . $datestamp . '
			DTSTART;TZID=America/Sao_Paulo:' . $start . '
			DTEND;TZID=America/Sao_Paulo:' . $end . '
			ORGANIZER;CN=biblioteca.atendimento@fundacaobutantan.org.br:mailto:biblioteca.atendimento@fundacaobutantan.org.br
			ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=TRUE
			;CN=' . $sendMail['destino_email'] . ';X-NUM-GUESTS=0:mailto:' . $sendMail['destino_email'] . '
			LOCATION:
			DESCRIPTION:' . $sendMail['assunto'] . ' ' . $dateStart_title . '
			STATUS:' . $sendMail['status'] . '
			SUMMARY:' . $sendMail['nomeEvento'] . ' ' . $dateStart_title . '
			TRANSP:OPAQUE
			UID:' . $uid . '
			END:VEVENT
			END:VCALENDAR
			';

			$ical_content = preg_replace('/^\s+/m', '', $ical_content);

			$this->mailer->Ical = $ical_content;
			$this->mailer->AddStringAttachment($ical_content, "meeting.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");

			if (!$this->mailer->send()) {
				var_dump($this->mailer->ErrorInfo);
			}
		} else {
			$uid = md5($sendMail['evento_id'] . '#ibutantan.local') . '@fundacaobutantan.org.br';

			$date = date_create();
			$datestamp = date_format($date, 'Ymd');
			$horastamp = date_format($date, 'His');

			$datestamp = $datestamp . 'T' . $horastamp;

			$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
			$this->mailer->addAddress($sendMail['destino_email'], $sendMail['destino_nome']);
			$this->mailer->Subject = $sendMail['assunto'];
			$this->mailer->Body = $sendMail['nomeEvento'];
			$this->mailer->IsHTML(FALSE);

			$ical_content = '
			BEGIN:VCALENDAR
			PRODID:-//Google Inc//Google Calendar 70.9054//EN
			VERSION:2.0
			X-WR-TIMEZONE:America/Sao_Paulo
			CALSCALE:GREGORIAN
			METHOD:REQUEST
			BEGIN:VEVENT
			DTSTAMP:' . $datestamp . '
			DTSTART;TZID=America/Sao_Paulo:' . $sendMail['dataInicial'] . '
			DTEND;TZID=America/Sao_Paulo:' . $sendMail['dataFinal'] . '
			ORGANIZER;CN=tic.desenvolvimento@butantan.gov.br:mailto:tic.desenvolvimento@butantan.gov.br
			ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=TRUE
			;CN=' . $sendMail['destino_email'] . ';X-NUM-GUESTS=0:mailto:' . $sendMail['destino_email'] . '
			LOCATION:
			DESCRIPTION:' . $sendMail['assunto'] . '
			STATUS:' . $sendMail['status'] . '
			SUMMARY:' . $sendMail['nomeEvento'] . '
			TRANSP:OPAQUE
			UID:' . $uid . '
			END:VEVENT
			END:VCALENDAR
			';

			$ical_content = preg_replace('/^\s+/m', '', $ical_content);

			$this->mailer->Ical = $ical_content;
			$this->mailer->AddStringAttachment($ical_content, "meeting.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");

			if (!$this->mailer->send()) {
				var_dump($this->mailer->ErrorInfo);
			}
		}

		return $Response->withRedirect('/field-search-form/all', 301);
	});
})->add($middleware['auth']);
