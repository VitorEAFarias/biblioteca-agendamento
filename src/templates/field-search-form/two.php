<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
	#detalhes_pcd,
	#texto_pcd {
		display: none;
	}

	/* Estilo para o campo de seleção */
	.custom-select {
		display: inline-block;
		position: relative;
		width: 100%;
		font-family: Arial, sans-serif;
		font-size: 16px;
		border: 1px solid #ccc;
		border-radius: 4px;
		padding: 8px 12px;
		background-color: #fff;
		cursor: pointer;
	}

	/* Estilo para a seta do campo de seleção */
	.custom-select::after {
		content: '\25BC';
		position: absolute;
		top: 50%;
		right: 10px;
		transform: translateY(-50%);
		pointer-events: none;
	}
</style>

<main class="ls-main ">
	<div class="container-fluid">
		<script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>

		<?php include($base_path . '/templates/alert-template.php') ?>

		<div class="form-content row mt-4">

			<h1 style="color: #0F4192">Agendamento</h1>
			<form id="form-agendamento" action="<?php echo $action ?>" method="post" class="ls-form-horizontal row ls-form mt-3">
				<!-- Solicitante -->
				<div class="row">
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Solicitante</b></p>
							<input type="text" name="agendamentos[solicitante]" placeholder="nome solicitante" value="<?php echo trim($post['agendamentos']['solicitante']) ?>" required>
						</label>
					</div>
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Email Solicitante</b></p>
							<input type="email" name="agendamentos[email]" placeholder="email solicitante" value="<?php echo $post['agendamentos']['email'] ?>" required>
						</label>
					</div>
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Ramal Solicitante</b></p>
							<input type="number" name="agendamentos[ramal]" placeholder="ramal solicitante" value="<?php echo $post['agendamentos']['ramal'] ?>" required>
						</label>
					</div>
				</div>
				<!-- Responsável -->
				<div class="row">
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Responsável</b></p>
							<input type="text" name="agendamentos[responsavel]" placeholder="nome responsável" value="<?php echo trim($post['agendamentos']['responsavel']) ?>" required>
						</label>
					</div>
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Email Responsável</b></p>
							<input type="email" name="agendamentos[email_responsavel]" placeholder="email responsável" value="<?php echo $post['agendamentos']['email_responsavel'] ?>" required>
						</label>
					</div>
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Ramal Responsável</b></p>
							<input type="number" name="agendamentos[ramal_responsavel]" placeholder="ramal responsável" value="<?php echo $post['agendamentos']['ramal_responsavel'] ?>" required>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Nome do Evento</b></p>
							<input type="text" name="agendamentos[nomeEvento]" placeholder="Nome do Evento" value="<?php echo $post['agendamentos']['nomeEvento'] ?>" required>
						</label>
					</div>
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Quantidade de participantes</b></p>
							<input id='quantidade' type="number" name="agendamentos[quantidade]" value="<?php echo $post['agendamentos']['quantidade'] ?>" required max="28" min="1" onchange="verificarValor()">
						</label>
					</div>
					<div class="col-xl-4">
						<label class="ls-label">
							<p><b class="ls-label-text">Categoria do Evento</b></p>
							<div class="ls-custom-select">
								<select class="ls-custom" name="agendamentos[categoria]">
									<option value="">Não Definido</option>
									<?php foreach ($post['categorias'] as $item) : ?>
										<?php
										if (is_numeric($post['agendamentos']['categoria']) && $post['agendamentos']['categoria'] == $item['id']) {
											$selected = 'selected';
										} else {
											$selected = ($post['agendamentos']['categoria'] == $item['nome'] ? 'selected' : '');
										}
										?>
										<option <?php echo $selected ?> value="<?php echo $item['nome'] ?>">
											<?php echo $item['nome'] ?>
										</option>
									<?php endforeach ?>
								</select>
							</div>
						</label>
					</div>

				</div>
				<div id="dates-container">
					<div class="row mt-2" id="date-row">
						<div class="col-xl-5" style="display: flex; align-items: flex-end; justify-content: space-between">
							<div class="col-xl-5">
								<label class="ls-label">
									<p><b class="ls-label-text">Data Inicial</b></p>
								</label>
								<div class="ls-prefix-group" style="display: block">
									<div style="display: flex">
										<input type="text" id="data-inicial" name="agendamentos[dataInicial]" placeholder="dd/mm/aaaa" value="<?php echo date('d/m/Y', strtotime($post['agendamentos']['dataInicial'])) ?>" required style="width: 100%;">
										<a id="calendar-icon" class="ls-label-text-prefix ls-ico-calendar" style="min-width: 40px;"></a>
									</div>
								</div>
							</div>
							<div class="col-xl-2 text-center">
								<span><b></b></span>
							</div>
						</div>

						<div class="col-xl-2">
							<label class="ls-label">
								<p><b class="ls-label-text">Horário Inicial</b></p>
							</label>
							<select id="hora-inicio" class="form-control" name="agendamentos[horaInicial]" required style="width: 100%">
								<?php
								$horaMin = strtotime('08:00');
								$horaMax = strtotime('17:30');
								$horaInicial = isset($post['agendamentos']['horaInicial']) && !empty($post['agendamentos']['horaInicial']) ? $post['agendamentos']['horaInicial'] : '08:00';

								for ($hora = $horaMin; $hora <= $horaMax; $hora += 900) {
									$horaAtual = date('H:i', $hora);
									$selected = $horaAtual == $horaInicial ? 'selected' : '';
									echo '<option value="' . $horaAtual . '" ' . $selected . '>' . $horaAtual . '</option>';
								}
								?>
							</select>
							<span id="hora-inicio-error" style="color: red;"></span>
						</div>


						<div class="col-xl-1 text-center mt-5">
							<span><b>Até</b></span>
						</div>
						<div class="col-xl-2">
							<label class="ls-label">
								<p><b class="ls-label-text">Horário Final</b></p>
							</label>
							<select id="hora-fim" class="form-control" name="agendamentos[horaFinal]" required style="width: 100%">
								<?php
								$horaMin = strtotime('08:00');
								$horaMax = strtotime('17:30');
								$horaFinal = isset($post['agendamentos']['horaFinal']) && !empty($post['agendamentos']['horaFinal']) ? $post['agendamentos']['horaFinal'] : '08:00';
								for ($hora = $horaMin; $hora <= $horaMax; $hora += 900) {
									$horaAtual = date('H:i', $hora);
									$selected = $horaAtual == $horaFinal ? 'selected' : '';
									echo '<option value="' . $horaAtual . '" ' . $selected . '>' . $horaAtual . '</option>';
								}
								?>
							</select>
							<span id="hora-fim-error" style="color: red;"></span>
						</div>
						<div class="col-xl-2 mt-4" style="display: flex; justify-content: start;">
							<button type="button" class="ls-ico-cancel-circle ls-btn-primary remove-date mt-2" style="display: none;"> </button>
						</div>
					</div>
				</div>
				<div class="col-xl-2 mt-5" id="adicionar-data">
					<button class="ls-btn-primary" type="button" id="add-date">Adicionar Outra Data</button>
				</div>
				<div class="col-xl-12 mt-4 d-flex">
					<p><b class="ls-label-text">Haverá participantes PcD que precisaremos considerar durante o evento?</b>
					</p>
					<label class="ls-label-text" style="margin-left: 10px">
						<input type="radio" id="item_pcd" name="agendamentos[participantePcD]" value="1" <?php echo ($post['agendamentos']['participantePcD'] == '1' ? 'checked' : '') ?> required onchange="mostrarPcD()"> <b>Sim</b>
					</label>
					<label class="ls-label-text" style="margin-left: 10px">
						<input type="radio" id="item_pcd" name="agendamentos[participantePcD]" value="0" <?php echo (($post['agendamentos']['participantePcD'] == '0' || $post['agendamentos']['participantePcD'] == '') ? 'checked' : '') ?> required onchange="mostrarPcD()"> <b>Não</b>
					</label>
				</div>
				<div class="col-xl-12">
					<label class="ls-label">
						<p id="texto_pcd"><b class="ls-label-text">Forneça detalhes sobre os aspectos de acessibilidade que
								devem ser atendidos</b></p>
						<textarea id="detalhes_pcd" name="agendamentos[detalhesPcD]" rows="5"><?php echo trim($post['agendamentos']['detalhesPcD']) ?></textarea>
					</label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="ls-label d-flex">
							<p><b class="ls-label-text">Necessário espaço para coffee break? (o serviço de café é de
									responsabilidade do solicitante)</b></p>
							<label class="ls-label-text">
								<input type="radio" name="agendamentos[coffe]" id="radio-sim" value="1" <?php echo ($post['agendamentos']['coffe'] == '1' ? 'checked' : '') ?> required> Sim
							</label>
							<label class="ls-label-text">
								<input type="radio" name="agendamentos[coffe]" id="radio-nao" value="0" <?php echo ($post['agendamentos']['coffe'] == '0' ? 'checked' : '') ?> required> Não
							</label>
						</label>
					</div>
				</div>
				<div class="row" id="horario-cafe" hidden>
					<div class="col-md-8">
						<div class="col-md-3">
							<label class="ls-label">
								<p><b class="ls-label-text">Horário Início Café</b></p>
							</label>
							<select id="cafe-inicial" class="form-control" name="agendamentos[horaInicialCafe]" required style="width: 100%">
								<?php
								$horaMin = strtotime('08:00');
								$horaMax = strtotime('17:30');
								$horaInicioCafe = isset($post['agendamentos']['horaInicialCafe']) && !empty($post['agendamentos']['horaInicialCafe']) ? $post['agendamentos']['horaInicialCafe'] : '08:00';
								for ($hora = $horaMin; $hora <= $horaMax; $hora += 900) {
									$horaAtual = date('H:i', $hora);
									$selected = $horaAtual == $horaInicioCafe ? 'selected' : '';
									echo '<option value="' . $horaAtual . '" ' . $selected . '>' . $horaAtual . '</option>';
								}
								?>
							</select>
						</div>
						<div class="col-md-2 text-center" style="margin-top: 50px;">
							<span><b>Até</b></span>
						</div>
						<div class="col-md-3">
							<label class="ls-label">
								<p><b class="ls-label-text">Horário Fim Café</b></p>
							</label>
							<select id="cafe-final" class="form-control" name="agendamentos[horaFinalCafe]" required style="width: 100%">
								<?php
								$horaMin = strtotime('08:00');
								$horaMax = strtotime('17:30');
								$horaFinalCafe = isset($post['agendamentos']['horaFinalCafe']) && !empty($post['agendamentos']['horaFinalCafe']) ? $post['agendamentos']['horaFinalCafe'] : '08:00';
								for ($hora = $horaMin; $hora <= $horaMax; $hora += 900) {
									$horaAtual = date('H:i', $hora);
									$selected = $horaAtual == $horaFinalCafe ? 'selected' : '';
									echo '<option value="' . $horaAtual . '" ' . $selected . '>' . $horaAtual . '</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-xl-12 mt-4">
					<label class="ls-label">
						<p><b class="ls-label-text">Observações</b></p>
						<textarea id="observacoes" name="agendamentos[observacoes]" rows="5"><?php echo trim($post['agendamentos']['observacoes']) ?></textarea>
					</label>
				</div>

				<!-- Area de aprovação -->
				<?php if ($operator == 'edit') : ?>
					<hr style="border-bottom: 2px solid grey" class="mt-3">
					<div class="row mt-3">
						<div class="col-xl-4">
							<label class="ls-label">
								<p><b class="ls-label-text">Status do Agendamento</b></p>
								<div class="ls-custom-select">
									<select class="ls-custom" name="agendamentos[status]" required id="status" onchange="mostrarTextarea()">
										<?php foreach ($post['form']['selects']['agendamento_status'] as $item) : ?>
											<?php $selected = ($post['agendamentos']['status'] == $item['value'] ? 'selected' : '') ?>
											<option <?php echo $selected ?> value="<?php echo $item['value'] ?>">
												<?php echo $item['name'] ?>
											</option>
										<?php endforeach ?>
									</select>
								</div>
							</label>
						</div>

						<div class="col-xl-4">
							<label class="ls-label">
								<p><b class="ls-label-text">Locais disponíveis</b></p>
								<div class="ls-custom-select">
									<select class="ls-custom" name="agendamentos[local_id]">
										<option disabled selected value="">Selecione</option>
										<?php foreach ($post['locais'] as $item) : ?>
											<?php $selected = ($post['agendamentos']['local_id'] == $item['local_id'] ? 'selected' : '') ?>
											<option style="color:<?php echo $item['color'] ?>" <?php echo $selected ?> value="<?php echo $item['local_id'] ?>">
												<?php echo $item['nomeLocal'] ?>
											</option>
										<?php endforeach ?>
									</select>
								</div>
							</label>
						</div>
						<div class="col-xl-4">
							<label class="ls-label">
								<p><b class="ls-label-text">Categoria do Evento</b></p>
								<div class="ls-custom-select">
									<select class="ls-custom" name="agendamentos[categoria]">
										<option value="">Não Definido</option>
										<?php foreach ($post['categorias'] as $item) : ?>
											<?php
											if (is_numeric($post['agendamentos']['categoria']) && $post['agendamentos']['categoria'] == $item['id']) {
												$selected = 'selected';
											} else {
												$selected = ($post['agendamentos']['categoria'] == $item['nome'] ? 'selected' : '');
											}
											?>
											<option <?php echo $selected ?> value="<?php echo $item['nome'] ?>">
												<?php echo $item['nome'] ?>
											</option>
										<?php endforeach ?>
									</select>
								</div>
							</label>
						</div>
						<div class="col-xl-12">
							<label class="ls-label">
								<p id="titulo_motivo"><b class="ls-label-text">Justificativa</b></p>
								<textarea id="nao_aprovado_motivo" name="agendamentos[nao_aprovado_motivo]" rows="5" required><?php echo trim($post['agendamentos']['nao_aprovado_motivo']) ?></textarea>
							</label>
						</div>
					</div>
				<?php endif ?>
				<div>
					<div>
						<span>
							<b>Recursos oferecidos:</b> Projetores e computadores. Caso sejam necessários outros recursos,
							entrar em contato pelo e-mail biblioteca.atendimento@butantan.gov.br
						</span>
					</div>
				</div>
				<label class="ls-label d-flex justify-content-end">
					<input type="hidden" name="agendamentos[evento_id]" value="<?php echo $post['agendamentos']['evento_id'] ?>" required>

					<?php
					if ($user['user_adm'] == 1) { ?>
						<a href="/field-search-form/all" class="btn btn-voltar">Voltar</a>
					<?php } else { ?>
						<a href="/agendamentos/historico" class="btn btn-voltar">Voltar</a>
					<?php } ?>

					<?php if ($operator == 'edit') : ?>
						<button class="btn btn-executar" name="form[op]" value="create">Atualizar</button>
					<?php endif ?>

					<?php if ($operator != 'edit') : ?>
						<button class="btn btn-executar" name="form[op]" value="create">Cadastrar</button>
					<?php endif ?>
				</label>
			</form>
		</div>
	</div>
</main>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var radioSim = document.getElementById('radio-sim');
		var radioNao = document.getElementById('radio-nao');
		var divHorarioCafe = document.getElementById('horario-cafe');
		var cafeInicialInput = document.getElementById("cafe-inicial");
		var cafeFinalInput = document.getElementById("cafe-final");
		var formulario = document.getElementById("seu-formulario");

		radioSim.addEventListener('change', function() {
			if (radioSim.checked) {
				divHorarioCafe.hidden = false;
				document.getElementById("cafe-inicial").required = true;
				document.getElementById("cafe-final").required = true;
			}
		});

		radioNao.addEventListener('change', function() {
			if (radioNao.checked) {
				divHorarioCafe.hidden = true;
				document.getElementById("cafe-inicial").required = false;
				document.getElementById("cafe-final").required = false;
			}
		});

		if (radioSim.checked) {
			divHorarioCafe.hidden = false;
			document.getElementById("cafe-inicial").required = true;
			document.getElementById("cafe-final").required = true;
		} else {
			divHorarioCafe.hidden = true;
			document.getElementById("cafe-inicial").required = false;
			document.getElementById("cafe-final").required = false;
		}
	});

	document.addEventListener('DOMContentLoaded', function() {
		var horaInicioInput = document.getElementById('hora-inicio');

		horaInicioInput.addEventListener('change', function() {
			var horaInicio = horaInicioInput.value;
			var horaMin = '08:00';
			var horaMax = '17:30';

			if (horaInicio < horaMin) {
				horaInicioInput.value = horaMin;
			} else if (horaInicio > horaMax) {
				horaInicioInput.value = horaMax;
			}
		});
	});

	document.addEventListener('DOMContentLoaded', function() {
		var addDateButton = document.getElementById('add-date');
		var form = document.getElementById('form-agendamento');
		var datesContainer = document.getElementById('dates-container');
		var originalRow = document.getElementById('date-row');
		var initialDateField = document.getElementById('data-inicial');

		createFlatpickr(initialDateField);

		addDateButton.addEventListener('click', function() {
			var newRow = originalRow.cloneNode(true);
			newRow.querySelector('#data-inicial').value = '';
			newRow.querySelector('#hora-inicio').value = '';
			newRow.querySelector('#hora-fim').value = '';

			datesContainer.appendChild(newRow);

			var newDateField = newRow.querySelector('#data-inicial');
			var newCalendarIcon = newRow.querySelector('.ls-ico-calendar');
			var removeDateButton = newRow.querySelector('.remove-date');
			createFlatpickr(newDateField);

			if (newCalendarIcon) {
				newCalendarIcon.addEventListener('click', function() {
					if (newDateField && newDateField._flatpickr) {
						newDateField._flatpickr.open();
					} else {
						createFlatpickr(newDateField);
					}
				});
			}

			if (removeDateButton) {
				removeDateButton.style.display = 'block';
				removeDateButton.addEventListener('click', function() {
					newRow.remove();
				});
			}

			newRow.addEventListener('click', function(event) {
				if (event.target.classList.contains('remove-date')) {
					newRow.remove();
				}
			});
		});

		form.addEventListener('submit', function(event) {
			var dateRows = datesContainer.querySelectorAll('#data-inicial');
			var startTimeRows = datesContainer.querySelectorAll('#hora-inicio');
			var endTimeRows = datesContainer.querySelectorAll('#hora-fim');
			var selectedDates = [];

			dateRows.forEach(function(row, index) {
				var dateInput = row.value.trim();
				var startTimeInput = startTimeRows[index].value.trim();
				var endTimeInput = endTimeRows[index].value.trim();

				if (dateInput !== '' && startTimeInput !== '' && endTimeInput !== '') {
					var selectedDate = {
						date: dateInput,
						startTime: startTimeInput,
						endTime: endTimeInput,
					};
					selectedDates.push(selectedDate);
				}
			});

			var datesInput = document.createElement('input');
			datesInput.type = 'hidden';
			datesInput.name = 'agendamentos[datas]';
			datesInput.value = JSON.stringify(selectedDates);
			form.appendChild(datesInput);
		});
	});

	function validarHorario() {
		var horaInicioInput = document.getElementById('hora-inicio');
		var horaInicioError = document.getElementById('hora-inicio-error');

		horaInicioInput.addEventListener('input', function() {
			var horaInicio = this.value;
			console.log(horaInicio)
			var isValid = (horaInicio >= '08:00' && horaInicio <= '17:00');
			horaInicioError.textContent = isValid ? '' : 'A hora inicial deve estar entre 08:00 e 17:00.';
		});

		var horaFimInput = document.getElementById('hora-fim');
		var horaFimErro = document.getElementById('hora-fim-error');

		horaFimInput.addEventListener('input', function() {
			var horaFim = this.value;
			var isValid = (horaFim >= '09:00' && horaFim <= '17:30');
			horaFimErro.textContent = isValid ? '' : 'A hora final deve estar entre 09:00 e 17:30.'
		});
	}

	function createFlatpickr(field) {
		var flatpickrInstance = field._flatpickr;

		if (flatpickrInstance) {
			flatpickrInstance.destroy();
		}

		var currentDate = new Date();
		var threeMonthsLater = new Date(currentDate.getFullYear(), currentDate.getMonth() + 3, 0);

		field._flatpickr = flatpickr(field, {
			dateFormat: 'd/m/Y',
			minDate: getNextMonday(),
			maxDate: threeMonthsLater,
			disable: [
				function(date) {
					return date.getDay() === 0 || date.getDay() === 6;
				}
			],
			locale: {
				firstDayOfWeek: 1,
				weekdays: {
					shorthand: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
					longhand: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
				},
				months: {
					shorthand: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
					longhand: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
				},
			},
		});

		var calendarIcon = document.getElementById('calendar-icon');
		if (calendarIcon) {
			calendarIcon.addEventListener('click', function() {
				field._flatpickr.open();
			});
		}

		function getNextMonday() {
			var currentDate = new Date();
			var nextDay = new Date(currentDate);
			nextDay.setDate(currentDate.getDate() + 1);

			return nextDay;
		}
	}

	document.body.onload = mostrarTextarea();
	document.body.onload = mostrarPcD();

	function verificarValor() {
		var quantidadeInput = document.getElementById("quantidade");
		var valorInserido = parseInt(quantidadeInput.value);
		var maxPermitido = parseInt(quantidadeInput.getAttribute("max"));

		if (valorInserido > maxPermitido) {
			alert("O número máximo de participantes é de 28.");
		}
	}

	function mostrarPcD() {
		var selectValue_pcd = document.querySelector('input[name="agendamentos[participantePcD]"]:checked').value;
		var textarea_pcd = document.getElementById('detalhes_pcd');
		var titulo_pcd = document.getElementById('texto_pcd');

		if (selectValue_pcd == '1') {
			textarea_pcd.removeAttribute('disabled');
			textarea_pcd.style.display = 'block';
			titulo_pcd.style.display = 'block';
		} else {
			textarea_pcd.style.display = 'none';
			titulo_pcd.style.display = 'none';
			textarea_pcd.setAttribute('disabled', 'disabled');
		}
	}

	function mostrarTextarea() {
		var selectValue = document.getElementById('status');
		var textarea = document.getElementById('nao_aprovado_motivo');
		var titulo = document.getElementById('titulo_motivo');

		if (selectValue && textarea && titulo) {
			if (selectValue.value === '1') {
				textarea.style.display = 'block';
				titulo.style.display = 'block';
				textarea.removeAttribute('disabled');
				textarea.required = true;
			} else {
				textarea.setAttribute('disabled', 'disabled');
				textarea.removeAttribute('required');
				textarea.style.display = 'none';
				titulo.style.display = 'none';
			}
		}
	}
</script>