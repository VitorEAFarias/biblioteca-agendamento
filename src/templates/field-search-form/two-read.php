<main class="ls-main ">
	<div class="container-fluid">
		<?php include($base_path . '/templates/alert-template.php') ?>

		<div class="container form-content mt-5">
			<h1 style="color: #0F4192">Agendamento</h1>

			<form action="<?php echo $action ?>" method="post" class="ls-form-horizontal row ls-form ls-form-disable" data-ls-module="form">

				<fieldset>

					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Nome Solicitante</b></p>
						<input type="text" name="agendamentos[solicitante]" placeholder="Nome Solicitante" value="<?php echo $post['agendamentos']['solicitante'] ?>">
					</label>

					<label class="ls-label px-2 col-xl-4">
						<p><b class="ls-label-text">Email Solicitante</b></p>
						<input type="email" name="agendamentos[email]" placeholder="Email Solicitante" value="<?php echo $post['agendamentos']['email'] ?>">
					</label>

					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Ramal Solicitante</b></p>
						<input type="number" name="agendamentos[ramal]" placeholder="Ramal Solicitante" value="<?php echo $post['agendamentos']['ramal'] ?>">
					</label>

					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Nome Responsável</b></p>
						<input type="text" name="agendamentos[responsavel]" placeholder="Nome Responsável" value="<?php echo $post['agendamentos']['responsavel'] ?>">
					</label>

					<label class="ls-label px-2 col-xl-4">
						<p><b class="ls-label-text">Email Responsável</b></p>
						<input type="email" name="agendamentos[email_responsavel]" placeholder="Email Responsável" value="<?php echo $post['agendamentos']['email_responsavel'] ?>">
					</label>

					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Ramal Responsável</b></p>
						<input type="number" name="agendamentos[ramal_responsavel]" placeholder="Ramal Responsável" value="<?php echo $post['agendamentos']['ramal_responsavel'] ?>">
					</label>

					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Data Inicial</b></p>
						<div class="ls-prefix-group">
							<input type="text" name="agendamentos[dataInicial]" class="datepicker" placeholder="dd/mm/aaaa" value="<?php echo date('d/m/Y', strtotime($post['agendamentos']['dataInicial'])) ?>">
							<a class="ls-label-text-prefix ls-ico-calendar"></a>
						</div>
					</label>

					<!--- ARRAY DE HORÁRIOS 07 - 20:00 -->
					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Horário Inicial</b></p>
						<input type="time" name="agendamentos[horaInicial]" min="07:00" max="20:00" value="<?php echo $post['agendamentos']['horaInicial'] ?>" required>
						<small>Horário comercial: 7h ás 20h</small>
					</label>

					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Horário Inicio Café</b></p>
						<input type="time" name="agendamentos[horaInicialCafe]" placeholder="00:00:00" value="<?php echo $post['agendamentos']['horaInicialCafe'] ?>">
					</label>

				</fieldset>

				<fieldset>
					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Data Final</b></p>
						<div class="ls-prefix-group">
							<input type="text" name="agendamentos[dataFinal]" class="datepicker" placeholder="dd/mm/aaaa" value="<?php echo date('d/m/Y', strtotime($post['agendamentos']['dataFinal'])) ?>">
							<a class="ls-label-text-prefix ls-ico-calendar"></a>
						</div>
					</label>

					<!--- ARRAY DE HORÁRIOS 07 - 20:00 -->
					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Horário Final</b></p>
						<input type="time" name="agendamentos[horaFinal]" min="07:00" max="20:00" value="<?php echo $post['agendamentos']['horaFinal'] ?>" required>
						<small>Horário comercial: 7h ás 20h</small>
					</label>

					<label class="ls-label col-xl-4">
						<p><b class="ls-label-text">Horário Fim Café</b></p>
						<input type="time" name="agendamentos[horaFinalCafe]" placeholder="00:00:00" value="<?php echo $post['agendamentos']['horaFinalCafe'] ?>">
					</label>
				</fieldset>

				<label class="ls-label col-xl-4">
					<p><b class="ls-label-text">Nome do Evento</b></p>
					<input type="text" name="agendamentos[nomeEvento]" placeholder="Nome do Evento" value="<?php echo $post['agendamentos']['nomeEvento'] ?>">
				</label>

				<label class="ls-label col-xl-4 px-3">
					<p><b class="ls-label-text">Quantidade de participantes</b></p>

					<input type="number" name="agendamentos[quantidade]" value="<?php echo $post['agendamentos']['quantidade'] ?>" required>

				</label>

				<label class="ls-label col-xl-4 px-3">
					<p><b class="ls-label-text">Categoria</b></p>
					<input type="text" name="agendamentos[categoria]" value="<?php echo $post['agendamentos']['categoria'] ?>" required>
				</label>



				<label class="ls-label col-xs-12 col-md-12 col-sm-12">
					<p><b class="ls-label-text">Observações</b></p>
					<input type="text" name="agendamentos[observacoes]" placeholder="Nome do Evento" value="<?php echo $post['agendamentos']['observacoes'] ?>">
				</label>

				<?php
				if ($post['agendamentos']['participantePcD'] != 0) { ?>
					<label class="ls-label col-xs-12 col-md-12 col-sm-12">
						<h4><b class="ls-label-text">Atenção</b></h4>
						<p><b class="ls-label-text">Possui participante com PcD</b></p>
						<p><b class="ls-label-text">Detalhes: <?= $post['agendamentos']['detalhesPcD'] ?></b></p>
					</label>
				<?php }
				?>
		</div>
		<fieldset class="ls-form-horizontal">
			<div class="ls-actions-btn ls-txt-right">

				<input type="hidden" name="agendamentos[evento_id]" value="<?php echo $post['agendamentos']['evento_id'] ?>">

				<a href="/field-search-form/all" class="btn btn-voltar">Voltar</a>
				<a href="" class="btn btn-executar" onclick="window.print();return false">Imprimir</a>

			</div>
		</fieldset>

	</div>

	</form>
</main>