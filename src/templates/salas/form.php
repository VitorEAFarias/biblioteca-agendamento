<main class="ls-main ">
	<div class="container-fluid">
		<?php include($base_path . '/templates/alert-template.php') ?>

		<div class="container">
			<div class="row form-content mt-4" id="formTwo">

				<?php
				if ($operator != 'edit') { ?>
					<h3 style="color: #0f4192; font-weight: bold">Cadastro de Salas e Auditórios</h3>
				<?php  } else { ?>
					<h3 style="color: #0f4192; font-weight: bold">Edição de Salas e Auditórios</h3>
				<?php   } ?>

				<div class="col-md-12">

					<form action="<?php echo $action ?>" method="post" class="row ls-form">

						<div class="row">

							<label class="ls-label col-md-4">
								<p><b class="ls-label-text">Nome do Local</b></p>
								<input type="text" required name="local[nomeLocal]" placeholder="Nome do Local" value="<?php echo $post['local']['nomeLocal'] ?>">
							</label>

							<label class="ls-label col-md-4">
								<p><b class="ls-label-text">Capacidade</b></p>
								<input type="number" required name="local[capacidade]" placeholder="Capacidade de lugares" value="<?php echo $post['local']['capacidade'] ?>">
							</label>

							<label class="ls-label col-md-4">
								<p><b class="ls-label-text">Cor do Google</b></p>
								<input type="color" required name="local[color]" placeholder="Cor do google" value="<?php echo $post['local']['color'] ?>">
							</label>

							<label class="ls-label col-md-12">
								<p><b class="ls-label-text">Descrição</b></p>
								<textarea name="local[descricao]" placeholder="Descrição da Sala" rows="6"><?php echo $post['local']['descricao'] ?></textarea>
							</label>

							<div class="d-flex justify-content-end mb-4">
								<p><b class="ls-label-text">Disponível</b></p>
								<label class="ls-label-text" style="margin-left: 15px;">
									<input type="radio" required name="local[disponivel]" value="1" <?php echo ($post['local']['disponivel'] == '1' ? 'checked' : '') ?>> Sim
								</label>
								<label class="ls-label-text" style="margin-left: 10px;">
									<input type="radio" required name="local[disponivel]" value="0" <?php echo ($post['local']['disponivel'] == '0' ? 'checked' : '') ?>> Não
								</label>
							</div>

							<input type="hidden" name="local[local_id]" value="<?php echo $post['local']['local_id'] ?>">

							<div class="d-flex justify-content-end">
								<a href="/salas"><button class="btn btn-voltar" type="button">Voltar</button></a>
								<?php if ($operator == 'edit') : ?>
									<button class="btn btn-executar" name="form[op]" value="update">Atualizar</button>
								<?php endif ?>


								<?php if ($operator != 'edit') : ?>
									<button class="btn btn-executar" name="form[op]" value="create">Cadastrar</button>
								<?php endif ?>
							</div>
						</div>

					</form>

				</div>
			</div>
		</div>
	</div>
</main>