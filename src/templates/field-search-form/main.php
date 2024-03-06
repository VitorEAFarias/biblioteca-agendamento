<?php
$url = $_SERVER['REQUEST_URI'];
$page = basename(parse_url($url, PHP_URL_PATH));
if ($user['user_adm'] == 0) {
	header('Refresh: 1; URL= ../dashboard');
	die();
}
?>
<style>
	.ls-main {
		height: auto !important;
		margin-bottom: 20px !important;
	}

	.ls-dropdown-nav {
		left: -250px !important
	}

	.form-field {
		background-color: #f5f5f5;
		padding: 10px;
		border-radius: 4px;
	}

	.form-field input {
		background-color: #f5f5f5;
		border: none;
		box-shadow: none !important;
		border-radius: 0 !important;
		border-bottom: 1px solid #c6c6c6;
	}

	.form-field .ls-custom-select {
		background-color: #f5f5f5;
		border: none;
		box-shadow: none !important;
		border-radius: 0 !important;
		border-bottom: 1px solid #c6c6c6;
	}

	.form-field .ls-custom-select select {
		background-color: #f5f5f5;
		border: none;
		box-shadow: none !important;
	}

	.form-field .ls-custom-select:after {
		background-color: #f5f5f5;
		border: none;
	}

	.actions {
		background-color: transparent !important;
		border: none;
	}

	.btn-relatorios {
		padding: 3px 10px;
		border: 1px solid #0F4192;
		background-color: white;
		border-radius: 8px;
		margin-right: 10px;
		color: #0F4192;
	}

	.btn-relatorios:hover {
		border: 1px solid white;
		background-color: #0F4192;
		color: white;
	}

	.active {
		border: none;
		background-color: white;
		color: #0F4192;
	}

	.actions {
		background-color: transparent !important;
		border: none;
	}

	.cor-google {
		border-radius: 10px;
		padding-top: 4px;
		padding-left: 10px;
		padding-right: 10px;
		padding-bottom: 4px;
		text-align: center;
	}


	.btn-filtro {
		background-color: #4463B0;
		border: 1px solid #4463B0;
		border-radius: 8px;
		color: white
	}

	.btn-filtro:hover {
		background-color: white;
		border: 1px solid #4463B0;
		color: #4463B0;
	}

	.btn-cadastro {
		background-color: #4463B0;
		border: 1px solid #4463B0;
		border-radius: 8px;
		color: white;
	}

	.btn-cadastro:hover {
		background-color: white;
		border-radius: 8px;
		color: #4463B0;
	}
</style>


<main class="ls-main ">
	<div class="container-fluid">
		<?php include($base_path . '/templates/alert-template.php') ?>
		<div class="row mt-4">
			<form action="<?php echo $action ?>" method="post" class="ls-form ls-form-horizontal">
				<div class="row d-flex align-items-center">
					<div class="ls-label 
					<?= $page == 'all' ? 'col-md-3' : 'col-md-5' ?>
					">
						<div class="form-field">
							<b class="ls-label-text">Solicitante</b>
							<input type="text" name="form[solicitante]" class="ls-field" autocomplete="off" value="<?php echo $post['form']['solicitante'] ?>">
						</div>
					</div>

					<div class="ls-label
					<?= $page == 'all' ? 'col-md-3' : 'col-md-5' ?>
					">
						<div class="form-field">
							<b class="ls-label-text">Nome do Evento</b>
							<input type="text" name="form[nomeEvento]" class="ls-field" value="<?php echo $post['form']['nomeEvento'] ?>">
						</div>
					</div>

					<?php
					if ($page == 'all') { ?>

						<div class="ls-label col-md-2 ">
							<div class="form-field">
								<b class="ls-label-text">Data Inicial</b>
								<input id="dataInicial" type="date" name="form[data]" class="ls-field" value="">
							</div>
						</div>

						<div class="ls-label col-md-2 ">
							<div class="form-field">
								<b class="ls-label-text">Data Final</b>
								<input id="dataFinal" type="date" name="form[data_final]" class="ls-field" value="">
							</div>
						</div>

					<?php	}
					?>

					<label class="ls-label col-md-1
					">
						<button type="submit" onclick="verificarDatas()" name="form[op]" value="search" class="btn btn-primary btn-filtro"><i class="fas fa-filter"></i> Filtrar</button>
					</label>

					<label class="ls-label col-md-1 ls-txt-right">
						<button type="submit" name="form[op]" value="generate" class="btn btn-primary btn-filtro"><i class="fas fa-file-csv"></i> Gerar</button>
					</label>
				</div>

			</form>

		</div>
		<div class="d-flex justify-content-between align-items-center">
			<h1 style="color: #0f4192">Relatórios</h1>
			<hr>
			<div>
				<a href="all"><button class="btn-relatorios <?= $page == 'all' ? 'active' : '' ?> ">Todos</button></a>
				<a href="today"><button class="btn-relatorios <?= $page == 'today' ? 'active' : '' ?> ">Hoje</button></a>
				<a href="analise"><button class="btn-relatorios <?= $page == 'analise' ? 'active' : '' ?> ">Em análise</button></a>
				<a href="aprovado"><button class="btn-relatorios <?= $page == 'aprovado' ? 'active' : '' ?> ">Aprovados</button></a>
				<a href="cancelado"><button class="btn-relatorios <?= $page == 'cancelado' ? 'active' : '' ?> ">Cancelado</button></a>
				<a href="nao_aprovado"><button class="btn-relatorios <?= $page == 'nao_aprovado' ? 'active' : '' ?> ">Não Aprovados</button></a>
				<a href="/field-search-form/two" class="ls-btn btn btn-cadastro"><i class="fas fa-calendar-alt"></i> Agendar</a>
			</div>
		</div>

		<div class="row">
			<table class="col-md-12 ls-table" border="0">
				<tr>
					<th width="5%" style="color: #0f4192">ID</th>
					<th width="17%" style="color: #0f4192">SOLICITANTE</th>
					<th width="18%" style="color: #0f4192">NOME DO EVENTO</th>
					<th width="14%" style="color: #0f4192">LOCAL</th>
					<th width="10%" style="color: #0f4192">CATEGORIA</th>
					<th width="11%" style="color: #0f4192">DATA INICIAL</th>
					<th width="11%" style="color: #0f4192">DATA FINAL</th>
					<th width="9%" style="color: #0f4192">ULTIMA ATUALIZAÇÃO</th>
					<th width="6%" style="color: #0f4192"></th>
				</tr>

				<?php foreach ($results as $item) : ?>
					<tr>
						<td><?php echo $item['evento_id'] ?></td>
						<td><?php echo $item['solicitante'] ?></td>
						<td><?php echo $item['nomeEvento'] ?></td>
						<?php
						foreach ($auditorios as $auditorio) {
							if ($item['local_id'] == $auditorio['local_id']) {
								$cor = $auditorio['color'];
								$local = $auditorio['nomeLocal'];
							} else if ($item['local_id'] == 0) {
								$cor = 'grey';
								$local = 'Não Definido';
							}
						}
						?>
						<td>
							<div style="background-color:<?= $cor ?>" class="cor-google text-white"><?php echo $local ?></div>
						</td>
						<td>
							<?php
							if (isset($item['categoria'])) { ?>
								<?php echo $item['categoria'] ?>
							<?php	} else { ?>
								Não Definido
							<?php	}
							?>
						</td>

						<td><?= date('d/m/Y', strtotime($item['dataInicial'])) . ' <br> ' . $item['horaInicial'] ?></td>
						<td><?= date('d/m/Y', strtotime($item['dataFinal'])) . ' <br> ' . $item['horaFinal'] ?></td>
						<td><?= date('d/m/Y', strtotime($item['update_date'])) ?></td>
						<td>
							<div class="ls-group-btn ls-group-active ls-txt-left">

								<div>
									<div data-ls-module="dropdown" class="ls-dropdown" style="display:inline">
										<a href="#" class="ls-btn-primary actions"><i class="fas fa-ellipsis-v" style="color: black; font-size: 16px;"></i></a>
										<ul class="ls-dropdown-nav">
											<li><a href="<?php echo '/field-search-form/two-read/' . $item['evento_id'] ?>">Visualizar</a></li>
											<li><a href="<?php echo '/field-search-form/two/' . $item['evento_id'] ?>">Editar</a></li>
											<li><a data-ls-module="modal" data-target="#modalmail<?php echo $item['evento_id'] ?>" class=""><span class="ls-ico-envelope"></span>
													- Enviar Email</a> </li>
											<li><a data-ls-module="modal" data-target="#modalEvento<?php echo $item['evento_id'] ?>" class=""><span class="ls-ico-calendar-more"></span>
													- Enviar Invite</a> </li>
										</ul>
									</div>
								</div>
							</div>


							<!-- modal email-->
							<div class="ls-modal" id="modalEvento<?php echo $item['evento_id'] ?>" style="z-index: 10">
								<div class="ls-modal-large">
									<div class="ls-modal-header ls-info-header" style="border: solid 5px #ef7736">
										<button data-dismiss="modal">&times;</button>
										<h4 class="ls-modal-title">Evento: <?php echo $item['nomeEvento'] ?></h4>
										<p> <b>Data Início:</b> <?php echo date('d/m/Y', strtotime($item['dataInicial'])) ?> às <?php echo $item['horaInicial'] ?>
											<br /> <b>Data Final:</b> <?php echo date('d/m/Y', strtotime($item['dataFinal'])) ?> às <?php echo $item['horaFinal'] ?>
											<br /><b>Observações:</b> <?php echo $item['observacoes'] ?>
										</p>
									</div>
									<div class="ls-modal-body">


										<h2>Enviar invite agenda</h2>

										<form action="/field-search-form/send-ical" method="POST" class="ls-form ls-form-horizontal row" data-ls-module="form">
											<fieldset>
												<div class="">

													<?php

													$dataI = date('Ymd', strtotime($item['dataInicial']));
													$horaI = str_replace(":", "", $item['horaInicial']);

													$dataF = date('Ymd', strtotime($item['dataFinal']));
													$horaF = str_replace(":", "", $item['horaFinal']);

													$horaInicialFormat = $dataI . 'T' . $horaI . '00Z';
													$horaFinalFormat = $dataF . 'T' . $horaF . '00Z';

													?>

													<label class="ls-label col-md-12">
														<b class="ls-label-text">Evento</b>
														<input type="text" name="sendMail[nomeEvento]" placeholder="nomeEvento" value="<?php echo $item['nomeEvento'] ?>" class="ls-field ls-form-disable">
													</label>

													<label class="ls-label col-md-2">
														<b class="ls-label-text">ID Evento</b>
														<input type="text" name="sendMail[evento_id]" placeholder="evento_id" value="<?php echo $item['evento_id'] ?>" class="ls-field ls-form-disable">
													</label>

													<label class="ls-label col-md-5">
														<b class="ls-label-text">Data Inicial</b>
														<input type="text" name="sendMail[dataInicial]" placeholder="dataInicial" value="<?php echo $horaInicialFormat ?>" class="ls-field ls-form-disable">
													</label>

													<label class="ls-label col-md-5">
														<b class="ls-label-text">Data Final</b>
														<input type="text" name="sendMail[dataFinal]" placeholder="dataFinal" value="<?php echo $horaFinalFormat ?>" class="ls-field ls-form-disable">
													</label>

													<label class="ls-label col-md-12">
														<b class="ls-label-text">Observações</b>
														<input type="text" name="sendMail[observacoes]" placeholder="observacoes" value="<?php echo $item['observacoes'] ?>" class="ls-field ls-form-disable">
													</label>


													<label class="ls-label col-md-12">
														<b class="ls-label-text">Assunto</b>
														<input type="text" name="sendMail[assunto]" placeholder="Assunto" class="ls-field ls-form-disable" value="<?php echo $item['nomeEvento'] ?>" required>
													</label>

													<label class="ls-label col-md-12">
														<b class="ls-label-text">Status do evento</b>
														<div class="ls-custom-select">
															<select name="sendMail[status]" class="ls-select">
																<option value="CONFIRMED">Agendar</option>
																<option value="CANCELLED">Cancelar</option>
															</select>
														</div>
													</label>

													<label class="ls-label col-md-6">
														<b class="ls-label-text">Solicitante</b>
														<p class="ls-label-info">responsavel pelo agendamento</p>
														<input type="text" name="sendMail[destino_nome]" placeholder="Nome e sobrenome" class="ls-field ls-form-disable" value="<?php echo $item['solicitante'] ?>" required>
													</label>
													<label class="ls-label col-md-6">
														<b class="ls-label-text">E-mail</b>
														<p class="ls-label-info">email de contato do solicitante</p>
														<input type="text" name="sendMail[destino_email]" placeholder="Escreva seu email" value="<?php echo $item['email'] ?>" required>
													</label>
													<!--div-->
													<button type="submit" class="ls-btn-primary">Enviar ICAL</button>
											</fieldset>
										</form>
									</div>
									<hr />
								</div>
							</div>

							<!-- enviar email para outras pessoas -->
							<div class="ls-modal" id="modalmail<?php echo $item['evento_id'] ?>" style="z-index: 10">
								<div class="ls-modal-large">
									<div class="ls-modal-header ls-info-header" style="border: solid 5px #ef7736">
										<button data-dismiss="modal">&times;</button>
										<h4 class="ls-modal-title">Evento: <?php echo $item['nomeEvento'] ?></h4>
										<p> <b>Data Início:</b> <?php echo date('d/m/Y', strtotime($item['dataInicial'])) ?> às <?php echo $item['horaInicial'] ?>
											<br /> <b>Data Final:</b> <?php echo date('d/m/Y', strtotime($item['dataFinal'])) ?> às <?php echo $item['horaFinal'] ?>
											<br /><b>Observações:</b> <?php echo $item['observacoes'] ?>
										</p>
									</div>
									<div class="ls-modal-body">
										<h2>Enviar Email</h2>
										<!--  -->
										<form action="/field-search-form/send-mail-out" method="POST" class="ls-form ls-form-horizontal row" data-ls-module="form">
											<fieldset>
												<div class="">
													<?php
													$dataI = date('Ymd', strtotime($item['dataInicial']));
													$horaI = str_replace(":", "", $item['horaInicial']);
													$dataF = date('Ymd', strtotime($item['dataFinal']));
													$horaF = str_replace(":", "", $item['horaFinal']);
													$horaInicialFormat = $dataI . 'T' . $horaI . '00Z';
													$horaFinalFormat = $dataF . 'T' . $horaF . '00Z';
													?>

													<label class="ls-label col-md-12">
														<b class="ls-label-text">Evento</b>
														<input type="text" name="sendMailOut[nomeEvento]" placeholder="nomeEvento" value="<?php echo $item['nomeEvento'] ?>" class="ls-field ls-form-disable" required>
													</label>

													<label class="ls-label col-md-12">
														<b class="ls-label-text">Assunto</b>
														<input type="text" name="sendMailOut[assunto]" placeholder="Assunto" class="ls-field ls-form-disable" value="<?php echo $item['nomeEvento'] ?>" required>
													</label>

													<label class="ls-label col-md-12">
														<b class="ls-label-text">Destino</b>
														<input type="text" name="sendMailOut[destino]" placeholder="Email" class="ls-field ls-form-disable" value="" required>
													</label>

													<label class="ls-label col-md-12">
														<b class="ls-label-text">Mensagem</b>
														<textarea name="sendMailOut[descripttion]" class="ckeditor" required rows="9">
															Evento: <?php echo $item['nomeEvento'] ?>
															<br />Data Início: <?php echo date('d/m/Y', strtotime($item['dataInicial'])) ?> às <?php echo $item['horaInicial'] ?>
															<br />Data Final: <?php echo date('d/m/Y', strtotime($item['dataFinal'])) ?> às <?php echo $item['horaFinal'] ?>
															<br />Solicitante: <?php echo $item['solicitante'] ?>
															<br />E-mail: <?php echo $item['email'] ?>
															<br />Observações: <?php echo $item['observacoes'] ?> <br /> <br />
                                                    	</textarea>
													</label>

													<label class="ls-label col-md-12">
														<button type="submit" class="ls-btn-primary">Enviar Email</button>
													</label>
											</fieldset>
										</form>
									</div>
									<hr />
								</div>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
</main>
<script src="//cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<script>
	// CKEDITOR.replace('editor');

	function verificarDatas() {
		var dataInicial = document.getElementById("dataInicial").value;
		var dataFinal = document.getElementById("dataFinal").value;

		if ((dataInicial === "" && dataFinal === "") || (dataInicial !== "" && dataFinal !== "")) {
			return true;
		} else {
			alert("Preencha ambas as datas ou deixe ambas vazias.");
			event.preventDefault();
			return false;
		}
	}
</script>