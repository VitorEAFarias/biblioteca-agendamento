<main class="ls-main">

	<style>
		.ls-box {
			background: none !important;
		}

		.border_orange {
			border: solid 2px orange
		}

		.border_#00c9f5 {
			border: solid 2px #00c9f5
		}

		.separate_row {
			margin-bottom: 30px
		}
	</style>
	<div class="container-fluid">

		<h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>

		<?php include($base_path . '/templates/alert-template.php') ?>

		<div class="row">
			<?php if ($user['user_adm'] == 1) : ?>

				<?php if ($user['role']['access'] == 0) : ?>

					<div class="col-md-12" style="padding-bottom: 3% !important">
						<div class="ls-box ls-board-box">
							<header class="ls-info-header">
								<h2 class="ls-title-3">Números e agendamentos</h2>
								<p class="ls-float-right ls-float-none-xs ls-small-info">
									<br />Última atualização em <strong><?php echo date('d/m/Y') ?></strong>
								</p>
							</header>


							<div class="col-sm-6 col-md-4 ls-alert-success">
								<a href="/field-search-form/today">
									<div class="ls-box">
										<div class="ls-box-head">
											<h6 class="ls-title-4">EVENTO DE HOJE</h6>
										</div>
										<div class="ls-box-body">
											<span class="ls-board-data">
												<strong>
													<?php echo $result['today']  ?>
												</strong>
											</span>
										</div>
										<div class="ls-box-footer">
											<small>até o momento</small>
										</div>
									</div>
								</a>
							</div>


							<div class="col-sm-6 col-md-4 ls-alert-box-success">
								<a href="/field-search-form/all">
									<div class="ls-box">
										<div class="ls-box-head">
											<h6 class="ls-title-4">TOTAL DE REGISTROS NO BANCO DE DADOS</h6>
										</div>
										<div class="ls-box-body">
											<span class="ls-board-data">
												<strong><?php echo $result['total'] ?></strong>
											</span>
										</div>
										<div class="ls-box-footer">
											<small>até o momento</small>
										</div>
									</div>
								</a>
							</div>

							<div class="col-sm-6 col-md-4 ls-alert-box-success">
								<a href="/field-search-form/analise">
									<div class="ls-box">
										<div class="ls-box-head">
											<h6 class="ls-title-4">TOTAL DE AGENDAMENTOS EM ANÁLISE</h6>
										</div>
										<div class="ls-box-body">
											<span class="ls-board-data">
												<strong><?php echo $result['total_analise'] ?></strong>
											</span>
										</div>
										<div class="ls-box-footer">
											<small>até o momento</small>
										</div>
									</div>
								</a>
							</div>

							<div class="col-sm-6 col-md-4 ls-alert-box-success">
								<a href="/field-search-form/novadata">
									<div class="ls-box">
										<div class="ls-box-head">
											<h6 class="ls-title-4">TOTAL DE AGENDAMENTOS SUGERIDO NOVA DATA</h6>
										</div>
										<div class="ls-box-body">
											<span class="ls-board-data">
												<strong><?php echo $result['total_nova_data'] ?></strong>
											</span>
										</div>
										<div class="ls-box-footer">
											<small>até o momento</small>
										</div>
									</div>
								</a>
							</div>



							<div class="col-sm-6 col-md-4 ls-alert-box-success">
								<a href="/field-search-form/aprovado">
									<div class="ls-box">
										<div class="ls-box-head">
											<h6 class="ls-title-4">TOTAL DE AGENDAMENTOS APROVADOS</h6>
										</div>
										<div class="ls-box-body">
											<strong><?php echo $result['total_aprovado'] ?></strong>
											<small>até o momento</small>
										</div>
									</div>
								</a>
							</div>


							<div class="col-sm-6 col-md-4 ls-alert-box-success">
								<a href="/field-search-form/cancelado">
									<div class="ls-box">
										<div class="ls-box-head">
											<h6 class="ls-title-4">TOTAL DE AGENDAMENTOS CANCELADOS</h6>
										</div>
										<div class="ls-box-body">
											<strong><?php echo $result['total_recusado'] ?></strong>
											<small>até o momento</small>
										</div>
									</div>
								</a>
							</div>


						</div>
					</div>
		</div>
	<?php endif ?>
<?php endif ?>

<div class="row">

	<div class="col-sm-6 col-md-6">
		<div class="ls-box ls-lg-space" style="margin-bottom: 40px;">
			<h1 class="ls-title-1 ls-color-theme">AGENDAMENTOS DE AUDITÓRIOS</h1>
			<a class="ls-btn-primary" href="/field-search-form/two">AGENDAR</a>
		</div>
	</div>

	<!--div class="col-sm-6 col-md-6">
				<div class="ls-box ls-lg-space ">
				  <h1 class="ls-title-1 ls-color-theme">RELATÓRIO DE AGENDAMENTOS</h1>
				  <a class="ls-btn-primary" href="/field-search-form/analise">RELATÓRIOS</a>
				</div>
    	</div-->



</div>


	</div>
</main>