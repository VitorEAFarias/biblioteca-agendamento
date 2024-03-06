<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/locales-all.min.js"></script>
<script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css">

<?php
$date = new DateTime();
$formatter = new IntlDateFormatter(
	'pt_BR',
	IntlDateFormatter::FULL,
	IntlDateFormatter::NONE,
	'America/Sao_Paulo',
	IntlDateFormatter::GREGORIAN
);
$formatter2 = new IntlDateFormatter(
	'pt_BR',
	IntlDateFormatter::MEDIUM,
	IntlDateFormatter::NONE,
	'America/Sao_Paulo',
	IntlDateFormatter::GREGORIAN
);
?>

<style>
	.btn-orange {
		background-color: #4463B0;
		border: 1px solid #4463B0;
		padding: 10px 16px;
		border-radius: 8px;
		color: white;
	}

	.btn-orange:hover {
		background-color: white;
		color: #4463B0;
	}

	.card-dash {
		background-color: #f5f5f9;
		padding: 20px;
		border-radius: 10px;
		min-height: 160px;
	}

	.side-calendar {
		display: flex;
		justify-content: space-between;
	}

	.side-calendar a {
		text-decoration: none;
		color: black;
	}

	.side-calendar-events {
		padding: 15px;
		margin-top: 30px;
		border-radius: 12px;
		box-shadow: 3px 3px 7px rgba(0, 0, 0, 0.1);
	}

	.color-calendar {
		height: 50px;
		width: 4.348px;
		border-radius: 7px;
		margin: 0 20px;
	}

	#calendario tbody .fc-scrollgrid-section:first-child {
		display: none;
	}

	.fc .fc-timegrid-slot-minor {
		border-top-style: none;
	}

	.fc-theme-standard .fc-scrollgrid {
		border: none !important;
	}

	#calendar a {
		text-decoration: none;
		color: black;
	}

	.fc-col-header-cell-cushion {
		color: grey;
		text-decoration: none;
		font-weight: 400 !important;
	}

	.fc .fc-timegrid-col.fc-day-today {
		background-color: white;
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var calendarEl = document.getElementById('calendario');

		var calendar = new FullCalendar.Calendar(calendarEl, {
			timeZone: 'UTC',
			initialView: 'timeGridDay',
			locale: 'pt-br',
			editable: true,
			selectable: true,
			dayMaxEvents: true,
			headerToolbar: {
				left: '',
				// center: 'title',
				right: ''
			},
			events: [
				<?php
				foreach ($eventos as $key => $value) :
					if ($value['cancelado']) continue;


					$id = $value['evento_id'];

					if ($user['user_adm'] == 1) {
						$title = utf8_decode($value['nomeEvento']);
					}

					if ($user['user_adm'] == 0) {
						$title = 'OCUPADO';
					}

					$color = $value['color'];

					$descriptionStart = date("d/m/Y", strtotime($value['data_evento'])) . ' das ' . $value['horaInicial'];
					$descriptionEnd =  date("d/m/Y", strtotime($value['data_evento'])) . ' ate ' . $value['horaFinal'];

					//$tituloPop =  '<br /><b>Título:</b> ';

					$tituloInicio =  '<br /><b>Início:</b> ';
					$tituloTermino =  '<br /><b>Término:</b> ';

					$people = "<br /><b>Participantes: </b>" . $value['quantidade'];

					$tituloObservacoes =   '<hr /><b>Observações:</b> ';

					$tituloInicio = utf8_decode($tituloInicio);
					$tituloTermino = utf8_decode($tituloTermino);
					$tituloCafe = utf8_decode($tituloCafe);
					$tituloRecursos = utf8_decode($tituloRecursos);
					$tituloObservacoes = utf8_decode($tituloObservacoes);

					$nomeLocal = '<b>Local:</b> ' . utf8_decode($value['nomeLocal']);
					if (!$value['nomeLocal']) {
						$nomeLocal = '<b>Local:</b> ' .  utf8_decode('Não informado');
					}

					$solicitante = '<br /><b>Solicitante:</b> ' . utf8_decode($value['solicitante']);
					$ramal = '<br /><b>Ramal:</b> ' . utf8_decode($value['ramal']);

					$description =
						'<b>Evento:</b> ' . $title
						. $solicitante . $ramal . '<br>' . $nomeLocal .  $tituloInicio . $descriptionStart .
						'\n' . $tituloTermino .  $descriptionEnd . $people .  '' . $tituloObservacoes . utf8_decode($value['observacoes']);
					$description = utf8_encode($description);
					$description = str_replace("'", 0, $description);

					$value['nomeEvento'] = str_replace("'", 0, $value['nomeEvento']);
					$value['data_evento'] = date('Y-m-d', strtotime($value['data_evento']));
					$value['horaInicial'] = $value['data_evento'] . ' ' . $value['horaInicial'];
					$value['horaFinal'] = $value['data_evento'] . ' ' . $value['horaFinal'];

					if ($user['user_adm'] == 0) {
						$title = 'OCUPADO';
						echo "{
              title: 'OCUPADO',
              start: '{$value['horaInicial']}',
              end: '{$value['horaFinal']}',
              display: '{$value['color']}',
              color: '{$value['color']}',
              description:  \n''
            },";
					} else {
						echo "{
              title: '{$value['nomeEvento']}',
              start: '{$value['horaInicial']}',
              end: '{$value['horaFinal']}',
              display: '{$value['color']}',
              color: '{$value['color']}',
              description:  \n'{$description}'
            },";
					}

				endforeach;
				?>
			],

			eventDidMount: function(info) {

				var tooltip = new Tooltip(info.el, {
					title: info.event.extendedProps.description,
					placement: 'top',
					trigger: 'hover',
					container: 'body',
					//delay: { "show": 200, "hide": 200 },
					html: true

				});

			},
		});

		calendar.render();
	});
</script>

<main class="ls-main">

	<div class="container-fluid">
		<div class="row" style="margin-top: 20px">

			<?php
			if ($user['user_adm'] == 1) {
			?>
				<div class="col-lg-8">
					<div style="display: flex; justify-content: space-between">
						<div>
							<h2 style="font-size: 1.75rem">Olá, <?= $user['name'] ?></h2>
							<p style="margin-top: 10px; font-size: 16px">Hoje é <?= $formatter->format($date) ?></p>
						</div>
						<div style="margin-top: 10px">
							<a href="field-search-form/two">
								<button class="ls-ico-calendar ls-ico-left btn-orange">Agendar</button>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 px-3 pt-3">
							<div class="card-dash">
								<div class="row">
									<div class="col-lg-4">
										<img src="./assets/img/green.png" style="width: 90px;">
									</div>
									<div class="col-lg-8">
										<h6>Evento (s) de Hoje</h6>
										<h4>
											<strong><?php echo $result['today']  ?></strong>
										</h4>
										<span class="text-secondary">até o momento</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 px-3 pt-3">
							<div class="card-dash">
								<div class="row">
									<div class="col-lg-4">
										<img src="./assets/img/green.png" style="width: 90px">
									</div>
									<div class="col-lg-8">
										<h6>Total de registros</h6>
										<h4>
											<strong><?php echo $result['total'] ?></strong>
										</h4>
										<span class="text-secondary">até o momento</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 px-3 pt-3">
							<div class="card-dash">
								<div class="row">
									<div class="col-lg-4">
										<img src="./assets/img/orange.png" style="width: 90px">
									</div>
									<div class="col-lg-8">
										<h6>Total de agendamento em análise</h6>
										<h4>
											<strong><?php echo $result['total_analise'] ?></strong>
										</h4>
										<span class="text-secondary">até o momento</span>
									</div>
								</div>
							</div>
						</div>

						<!-- <div class="col-lg-6 px-3 pt-3">
							<div class="card-dash">
								<div class="row">
									<div class="col-lg-4">
										<img src="./assets/img/orange.png" style="width: 90px">
									</div>
									<div class="col-lg-8">
										<h6>Total de agendamentos sugerindo nova data</h6>
										<h4>
											<strong><?php echo $result['total_nova_data'] ?></strong>
										</h4>
										<span class="text-secondary">até o momento</span>
									</div>
								</div>
							</div>
						</div> -->

						<div class="col-lg-6 px-3 pt-3">
							<div class="card-dash">
								<div class="row">
									<div class="col-lg-4">
										<img src="./assets/img/green.png" style="width: 90px">
									</div>
									<div class="col-lg-8">
										<h6>Total de agendamentos aprovados</h6>
										<h4>
											<strong><?php echo $result['total_aprovado'] ?></strong>
										</h4>
										<span class="text-secondary">até o momento</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 px-3 pt-3">
							<div class="card-dash">
								<div class="row">
									<div class="col-lg-4">
										<img src="./assets/img/red.png" style="width: 90px">
									</div>
									<div class="col-lg-8">
										<h6>Total de agendamentos cancelados</h6>
										<h4>
											<strong><?php echo $result['total_recusado'] ?></strong>
										</h4>
										<span class="text-secondary">até o momento</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } else { ?>
				<div class="col-lg-8">
					<div style="display: flex; justify-content: space-between">
						<div>
							<h2 style="font-size: 1.75rem">Olá, <?= $user['name'] ?></h2>
							<p style="margin-top: 10px; font-size: 16px">Hoje é <?= $formatter->format($date) ?></p>

						</div>
						<div style="margin-top: 10px">
							<a href="field-search-form/two">
								<button class="ls-ico-calendar ls-ico-left btn-orange">Agendar</button>
							</a>
						</div>
					</div>
					<div>
						<p style="margin-top: 25px; font-size: 16px">Bem-vindo (a) ao Sistema de Agendamento do auditório e salas da Biblioteca do Instituto Butantan! Abaixo você encontrará a descrição dos espaços disponibilizados e agende conforme a sua necessidade. O uso é livre para as salas de estudo em grupo e individual.</p>
					</div>
					<?php foreach ($salas as $key => $sala) {
						if ($key % 2 == 0) { ?>
							<div class="mt-4" style="border: 1px solid grey; padding: 15px; border-radius: 15px">
								<div class="row">
									<div class="col-md-4">
										<?php
										foreach ($_SESSION['img_locais'] as $img) {
											if ($sala['local_id'] == $img['value']) { ?>
												<img src="/assets/img/salas/<?= $img['arquivo'] ?>" width="90%">
										<?php	}
										} ?>
									</div>
									<div class="col-md-8 d-flex justify-content-between flex-column">
										<h4><?= $sala['nomeLocal'] ?></h4>
										<p style="font-size: 16px"><?= $sala['descricao'] ?></p>
										<div class="d-flex justify-content-end">
											<span style="background-color: #ececec; padding: 8px; border-radius: 15px">Capacidade: <?= $sala['capacidade'] ?> pessoas.</span>
										</div>
									</div>
								</div>
							</div>
						<?php	} else { ?>
							<div class="mt-4" style="border: 1px solid grey; padding: 15px; border-radius: 15px">
								<div class="row">
									<div class="col-md-8 d-flex justify-content-between flex-column">
										<h4><?= $sala['nomeLocal'] ?></h4>
										<p style="font-size: 16px"><?= $sala['descricao'] ?></p>
										<div class="d-flex justify-content-end">
											<span style="background-color: #ececec; padding: 8px; border-radius: 15px">Capacidade: <?= $sala['capacidade'] ?> pessoas.</span>
										</div>
									</div>
									<div class="col-md-4">
										<?php
										foreach ($_SESSION['img_locais'] as $img) {
											if ($sala['local_id'] == $img['value']) { ?>
												<img src="/assets/img/salas/<?= $img['arquivo'] ?>" width="90%">
										<?php	}
										} ?>
									</div>
								</div>
							</div>
					<?php }
					} ?>
				</div>
			<?php } ?>
			<div class="col-lg-4 mt-2">
				<div class="side-calendar">
					<span style="font-size: 1.125rem">
						<?= $result['today'] ?> eventos hoje
					</span>
					<?php if ($user['user_adm'] == 1) { ?>
						<a href="field-search-form/today">
							<span>ver todos</span>
							<i class="ls-ico-chevron-right" style="font-size: 14px; color: #4463B0"></i>
						</a>
					<?php	} ?>
				</div>
				<div class="side-calendar-events">
					<span style="font-size: 1.125rem">Calendário</span><br><br>
					<span class="text-secondary" style="font-size: 0.875rem"><?= $formatter2->format($date) ?></span>
					<?php
					foreach ($today_events as $result) {
						foreach ($auditorios as $auditorio) {
							if ($result['local_id'] == $auditorio['local_id']) {
								$cor = $auditorio['color'];
								$local = $auditorio['nomeLocal'];
							} else if ($result['local_id'] == 0) {
								$cor = '#7a7a7a';
								$local = 'Não Definido';
							}
						}
					?>
						<div style="display: flex; align-items: center; margin-top: 10px;">
							<span style="font-size: 24px;"><?= $result['horaInicial'] ?></span>
							<div class='color-calendar' style="background-color: <?= $cor ?>"></div>
							<div>
								<div>
									<span style="font-size: 13px"><?= $user['user_adm'] == 0 ? 'Ocupado' : $result['nomeEvento'] ?></span><br>
									<span style="font-size: 13px"><?= $local ?></span>
								</div>
							</div>
						</div>
					<?php	} ?>
				</div>
			</div>
			<!-- Calendario -->
			<?php
			if ($user['user_adm'] == 1) {
			?>
				<div class="col-lg-12 my-4">
					<div style="display: flex; justify-content: space-between">
						<h5 style="color: #2b2f3e; font-weight: 600">Agendamentos</h5>
						<i class="ls-ico-week text-secondary" style="font-size: 20px;"></i>
					</div>
					<div id="calendario" style="max-height: 650px;"></div>
				</div>
			<?php } ?>
		</div>
	</div>
</main>