<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/agendamentos', function () {

	$this->any('', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		try {
			$conn = new PDO("sqlsrv:Server=" . SERVER_HOST . ";database=" . SERVER_DBNAME, SERVER_USERNAME, SERVER_PASSWORD);

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$queryFull = "SELECT *
				FROM vw_evento_periodos
				where status = 2";

			$queryLocais = 'SELECT * from local WHERE disponivel <> 0 order by nomeLocal ASC';

			$stmt = $conn->query($queryFull);

			$stmt2 = $conn->query($queryLocais);

			//echo "Connected successfully <br>";
		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}


		$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$locais = $stmt2->fetchAll(PDO::FETCH_ASSOC);

		$post['recursos'] = $this->session->get('recursos');


		$results = $this->mysql->fetchAll(
			'SELECT * from eventos order by create_date',
			[
				':asbl' => $post['form']['asbl'] . '%',
				':address_number' => $post['form']['number'] . '%',
				':address' => $post['form']['address'] . '%',
			]
		);

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Todos Agendamentos');
		$phpView->addAttribute('action', '/agendamentos');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'agendamentos/view.php', [
			'results'	=> $results,
			'eventos'	=> $eventos,
			'locais'	=> $locais,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	$this->any('/eventos', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Todos Agendamentos');
		$phpView->addAttribute('action', 'agendamentos/eventos');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'agendamentos/view.php', [
			'results'	=> $results,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	$this->any('/historico', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$post['recursos'] = $this->session->get('recursos');
		$post['form']['selects']['agendamento_status'] = $this->session->get('agendamento_status');
		$post['form']['nome'] = $this->convert->checkIfExist($post['form']['nome'], '');
		$post['form']['evento'] = $this->convert->checkIfExist($post['form']['evento'], '');
		$post['form']['local'] = $this->convert->checkIfExist($post['form']['local'], '');
		$post['form']['data'] = $this->convert->checkIfExist($post['form']['data'], '');
		$post['form']['status'] = $this->convert->checkIfExist($post['form']['status'], '');

		$post['form']['selects']['users_roles'] = $this->session->get('users_roles');

		$query = "SELECT TOP(500) * FROM vw_evento_periodos 
		WHERE Create_User = :Create_user
		AND nomeEvento LIKE :nomeEvento
		AND nomeLocal LIKE :nomeLocal	
		AND CONVERT(VARCHAR(25), data_evento, 126) LIKE :data_evento		
		AND status like :status
		ORDER BY create_date DESC";

		if (empty($post['form']['local'])) {
			$query = "SELECT TOP(500) * FROM vw_evento_periodos 
			WHERE Create_User = :Create_user
			AND nomeEvento LIKE :nomeEvento
			AND CONVERT(VARCHAR(25), data_evento, 126) LIKE :data_evento		
			AND status like :status
			ORDER BY create_date DESC";
		}

		//AND data_evento LIKE :data_evento
		$results = $this->mysql->fetchAll(
			$query,
			[
				':Create_user' => $user['id'],

				':nomeEvento' => '%' . $post['form']['evento'] . '%',
				':nomeLocal' => '%' . $post['form']['local'] . '%',
				':data_evento' => '%' . $post['form']['data'] . '%',
				':status' => '%' . $post['form']['status'] . '%',
			]
		);

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Minhas solicitações');
		$phpView->addAttribute('action', '/historico');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'agendamentos/historico.php', [
			'results'	=> $results,
			'user'	=> $user,
			"messages" => $this->flash->getMessages(),
			"post"	=> $post
		]);
		return $phpView;
	});

	$this->get('/status/{evento_id:[0-9A-Za-z]+}/{status:[0-9]+}', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$registry = [
			'status' => $args['status']
		];

		$this->mysql->update('eventos', $registry, ['evento_id' => $args['evento_id']]);
		$this->flash->addMessage('ls-alert-success', 'Situação do usuário alterada com sucesso');

		$agendamentos = $this->mysql->fetchAssoc(
			'SELECT * FROM eventos WHERE evento_id = :id',
			[':id' => $args['evento_id']]
		);

		if ($registry['status'] == 3) {
			$this->mailer->addAddress($agendamentos['email_responsavel']);
			$this->mailer->addAddress('biblioteca.atendimento@butantan.gov.br');
		} else {
			$this->mailer->addAddress($agendamentos['email']);
		}

		$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Cancelamento - Agendamentos Biblioteca');
		$this->mailer->addAddress('vitor.farias@fundacaobutantan.org.br');

		$this->mailer->Subject = 'Socilitação de cancelamento';

		$this->mailer->Body = $this->mail_template->getTemplateByName(
			'canceled.php',
			['agendamentos' => $agendamentos]
		);
		//$this->mailer->Body = $sendMail['descricao'];

		if (!$this->mailer->send()) {
			var_dump($this->mailer->ErrorInfo);
		}

		return $Response->withStatus(302)->withHeader('Location', '/agendamentos/historico');
	});

	$this->any('/send-ical/{evento_id:[0-9A-Za-z]+}', function ($Request, $Response, $args) {

		date_default_timezone_set('America/Sao_Paulo');

		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();

		// 20210811T150000Z
		$sendMail = $this->mysql->fetchAssoc(
			'SELECT * FROM eventos WHERE evento_id = :id',
			[':id' => $args['evento_id']]
		);

		$uid = md5($sendMail['evento_id'] . '#ibutantan.local') . '@butantan.gov.br';

		$date = date_create();
		$datestamp = date_format($date, 'Ymd');
		$horastamp = date_format($date, 'His');

		$datestamp = $datestamp . 'T' . $horastamp;
		//$datestamp = date("YmdTHisZ", strtotime('+6 hours'));


		$dateStart = date("Ymd", strtotime($sendMail['dataInicial']));
		$dateStart_title = date("d/m/Y", strtotime($sendMail['dataInicial']));
		$timeStart = str_replace(":", "", $sendMail['horaInicial']) . '00';
		$start = $dateStart . 'T' . $timeStart . 'Z';
		//$start  = date_format(date_create($sendMail['dataInicial']), 'Ymd') . 'T' . str_replace(":", "",  $sendMail['horaInicial'] . '00Z');

		$DateEnd = date("Ymd", strtotime($sendMail['dataFinal']));
		$TimeEnd = str_replace(":", "", $sendMail['horaFinal']) . '00';
		$end = $DateEnd . 'T' . $TimeEnd . 'Z';
		//$end = date_format(date_create($sendMail['dataFinal']), 'Ymd') . 'T' . str_replace(":", "",  $sendMail['horaFinal'] . '00Z');


		// var_dump($datestamp);
		// var_dump($sendMail['dataInicial']);
		// var_dump($sendMail['dataFinal']);
		// exit;


		$this->mailer->setFrom('alerta.butantan@butantan.gov.br', 'Agendamentos Biblioteca');
		$this->mailer->addAddress($sendMail['email'], $sendMail['solictante']);
		$this->mailer->Subject = $sendMail['nomeEvento'];

		//$this->mailer->Body = $this->mail_template->getTemplateByName('ical.php', 
		//['sendMail' => $sendMail] 	
		//);
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
		ORGANIZER;CN=biblioteca.atendimento@butantan.gov.br:mailto:biblioteca.atendimento@butantan.gov.br
		ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=TRUE
		;CN=' . $sendMail['email'] . ';X-NUM-GUESTS=0:mailto:' . $sendMail['email'] . '
		LOCATION:
		DESCRIPTION:' . $sendMail['assunto'] . '
		STATUS:' . $sendMail['status'] . '
		SUMMARY:' . $sendMail['nomeEvento'] . '
		TRANSP:OPAQUE
		UID:' . $uid . '
		END:VEVENT
		END:VCALENDAR
		';

		$this->mailer->Ical = $ical_content;
		$this->mailer->AddStringAttachment($ical_content, "meeting.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");

		if (!$this->mailer->send()) {
			var_dump($this->mailer->ErrorInfo);
		}
		return $Response->withRedirect('/agendamentos/historico', 301);
	});
})->add($middleware['auth']);
