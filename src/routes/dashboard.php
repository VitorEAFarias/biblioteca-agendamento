<?php


use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/dashboard', function () {

	$this->any('', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$now = date('Y-m-d');

		try {
			$conn = new PDO("sqlsrv:Server=" . SERVER_HOST . ";database=" . SERVER_DBNAME, SERVER_USERNAME, SERVER_PASSWORD);

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$queryFull = "SELECT *
			FROM vw_evento_periodos
			where status = 2";

			$stmt = $conn->query($queryFull);


			$auditorios = $this->mysql->fetchAll('SELECT * from local order by nomeLocal ASC');
		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}

		$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$today = $this->mysql->fetchAssoc(
			'SELECT COUNT(*) as sum
			FROM [eventos]
			WHERE CAST(GETDATE() AS Date) BETWEEN dataInicial AND dataFinal
				AND status NOT IN (0, 1, 3);'
		);

		$salas = $this->mysql->fetchAll(
			'SELECT * from local WHERE disponivel <> 0'
		);


		$today_events = $this->mysql->fetchAll(
			'SELECT *
			FROM eventos
			WHERE 
			status NOT IN (0, 1, 3)
			AND 
			(CAST(dataInicial AS Date) = CAST(GETDATE() AS Date) OR CAST(dataFinal AS Date) = CAST(GETDATE() AS Date))
			ORDER BY horaInicial ASC',
		);

		$allSum = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM eventos WHERE create_date LIKE :filter_date ',
			[':filter_date' => $now]
		);

		$total = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM eventos'
		);

		$total_user = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM vw_evento_periodos WHERE Create_User = :Create_User',
			[':Create_User' => $user['id']]
		);

		$total_analise = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM eventos 
			WHERE status = 0'
		);

		$total_analise_user = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM vw_evento_periodos 
			WHERE status = 0 AND Create_User = :Create_User',
			[':Create_User' => $user['id']]
		);

		$total_nova_data = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM eventos 
			WHERE status = 1'
		);

		$total_aprovado = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM eventos 
			WHERE status = 2'
		);

		$total_aprovado_user = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM vw_evento_periodos 
			WHERE status = 2 AND Create_User = :Create_User',
			[':Create_User' => $user['id']]
		);

		$total_recusado = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM eventos 
			WHERE status = 3'
		);

		$total_recusado_user = $this->mysql->fetchAssoc(
			'SELECT COUNT(evento_id) as sum FROM vw_evento_periodos 
			WHERE status = 3 AND Create_User = :Create_User',
			[':Create_User' => $user['id']]
		);

		$result = [
			'all' => $allSum['sum'],
			'total' => $total['sum'],
			'total_user' => $total_user['sum'],
			'total_analise' => $total_analise['sum'],
			'total_analise_user' => $total_analise_user['sum'],
			'total_aprovado_user' => $total_aprovado_user['sum'],
			'total_recusado_user' => $total_recusado_user['sum'],
			'total_nova_data' => $total_nova_data['sum'],
			'total_aprovado' => $total_aprovado['sum'],
			'total_recusado' => $total_recusado['sum'],
			'today' => $today['sum'],
		];

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Painel Inicial');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');
		$phpView = $this->renderer->render($Response, 'dashboard/main.php', [
			'result' => $result,
			'salas' => $salas,
			'auditorios' => $auditorios,
			'today_events' => $today_events,
			'eventos' => $eventos,
			'post'	=> $post,
			'messages' => $this->flash->getMessages()
		]);
		return $phpView;
	});
})->add($middleware['syncToSession'])->add($middleware['auth']);
