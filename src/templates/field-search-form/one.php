<main class="ls-main ">
  <div class="container-fluid">
    <h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>
    
    <?php include($base_path.'/templates/alert-template.php') ?>

	<div class="row">
		<div class="col-md-12">
			<form action="/field-search-form/send-search" method="post" class="row ls-form ls-form-horizontal">
				<fieldset>
	        
	        <label class="ls-label col-md-12 col-sm-12">
	          <b class="ls-label-text">1. Local de internação hospitalar? (Nome do hospital)</b>
	          <div class="ls-custom-select">
	            <select class="ls-custom" name="answer[hospital]">
	            	<option selected="selected" value="">Escolher opção</option>
	              <?php foreach ($post['form']['selects']['hospitals'] as $item): ?>
	                <?php $selected = ($post['form']['name'] == $item['name'] ? 'selected' : '') ?>
	                <option <?php echo $selected ?> value="<?php echo $item['name'] ?>">
	                  <?php echo $item['name'] ?>
	                </option>
	              <?php endforeach ?>
	            </select>
	          </div>
	        </label>

	        <label class="ls-label col-md-6 col-sm-6">
	          <b class="ls-label-text">2. Inicio da internação</b>
	          <input type="text" name="answer[hospitalization_begin]" class="datepicker"  placeholder="dd/mm/aaaa" 
	          value="<?php echo $post[answer][hospitalization_begin] ?>">
	        </label>

	        <label class="ls-label col-md-6 col-sm-6">
	          <b class="ls-label-text">Fim da internação</b>
	          <input type="text" name="answer[hospitalization_end]" class="datepicker"  placeholder="dd/mm/aaaa" 
	          value="<?php echo $post[answer][hospitalization_end] ?>">
	        </label>
					
					<div class="ls-label col-md-12 col-sm-12">
						<b>3. A internação hospitalar foi por Síndrome Respiratória Aguda Grave?</b>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[hospitalization_was_respiratory_syndrome]" value="1"> Sim
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[hospitalization_was_respiratory_syndrome]" value="0"> Não
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[hospitalization_was_respiratory_syndrome]" value="NULL"> Ignorado
						</label>
					</div>

					<div class="ls-label col-md-12 col-sm-12">
						<b>4. O participante fez tratamento específico contra SARS-CoV-2/COVID-19?</b>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[specific_treatment_covid]" value="1"> Sim
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[specific_treatment_covid]" value="0"> Não
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[specific_treatment_covid]" value="NULL"> Ignorado
						</label>
					</div>

					<div class="ls-label col-md-12 col-sm-12">
					 <b class="ls-label-text">Específique</b>
					 <textarea name="answer[specific_treatment_covid_observation]" rows="2"></textarea>
					</div>


					<div class="ls-label col-md-12 col-sm-12">
						<b>5. O participante foi internado na UTI</b>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[patient_was_admitted]" value="1"> Sim
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[patient_was_admitted]" value="0"> Não
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[patient_was_admitted]" value="NULL"> Ignorado
						</label>
					</div>

	        <label class="ls-label col-md-6 col-sm-6">
	          <b class="ls-label-text">6. Inicio da internação em UTI</b>
	          <input type="text" name="answer[severe_hospitalization_begin]" class="datepicker"  placeholder="dd/mm/aaaa" 
	          value="<?php echo $post[answer][severe_hospitalization_begin] ?>">
	        </label>

	        <label class="ls-label col-md-6 col-sm-6">
	          <b class="ls-label-text">Fim da internação em UTI</b>
	          <input type="text" name="answer[severe_hospitalization_end]" class="datepicker"  placeholder="dd/mm/aaaa" 
	          value="<?php echo $post[answer][severe_hospitalization_end] ?>">
	        </label>

					<div class="ls-label col-md-12 col-sm-12">
						<b>7. Uso de suporte ventilatório:</b>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[used_ventilatory_support]" value="2"> Sim, invasivo
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[used_ventilatory_support]" value="1"> Sim, não invasivo
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[used_ventilatory_support]" value="0"> Não
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[used_ventilatory_support]" value="NULL"> Ignorado
						</label>
					</div>

					<div class="ls-label col-md-6 col-sm-6">
						<b>8. Coletou amostra de secreção respiratória para PCR-RT?	</b>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[collected_pcr_sample]" value="1"> Sim
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[collected_pcr_sample]" value="0"> Não
						</label>
						<label class="ls-label-text">
					  	<input type="radio" name="answer[collected_pcr_sample]" value="NULL"> Ignorado
						</label>
					</div>

	        <label class="ls-label col-md-6 col-sm-6">
	          <b class="ls-label-text">Caso afirmativo, data da coleta da secreção respiratória</b>
	          <input type="text" name="answer[date_collect_sample_begin]" class="datepicker"  placeholder="dd/mm/aaaa" 
	          value="<?php echo $post[answer][date_collect_sample_begin] ?>">
	        </label>

	        <label class="ls-label col-md-12 col-sm-12">
	          <b class="ls-label-text">9. Caso afirmativo, qual foi o resultado?</b>
	          <div class="ls-custom-select">
	            <select class="ls-custom" name="answer[virus_results]">
	            	<option selected="selected" value="">Escolher opção</option>
	              <?php foreach ($post['form']['selects']['virus_results'] as $item): ?>
	                <?php $selected = ($post['form']['name'] == $item['name'] ? 'selected' : '') ?>
	                <option <?php echo $selected ?> value="<?php echo $item['name'] ?>">
	                  <?php echo $item['name'] ?>
	                </option>
	              <?php endforeach ?>
	            </select>
	          </div>
	        </label>

					<div class="ls-label col-md-12 col-sm-12">
					 <b class="ls-label-text">Específique</b>
					 <textarea rows="2" name="answer[virus_results_observation]"></textarea>
					</div>

	        <label class="ls-label col-md-6 col-sm-6">
	          <b class="ls-label-text">10. Evolução do participante</b>
	          <div class="ls-custom-select">
	            <select class="ls-custom" name="answer[patient_status]">
	            	<option selected="selected" value="">Escolher opção</option>
	              <?php foreach ($post['form']['selects']['patient_status'] as $item): ?>
	                <?php $selected = ($post['form']['name'] == $item['name'] ? 'selected' : '') ?>
	                <option <?php echo $selected ?> value="<?php echo $item['name'] ?>">
	                  <?php echo $item['name'] ?>
	                </option>
	              <?php endforeach ?>
	            </select>
	          </div>
	        </label>

	        <label class="ls-label col-md-6 col-sm-6">
	          <b class="ls-label-text">Data de evolução do participante</b>
	          <input type="text" name="answer[status_evolution_begin]" class="datepicker"  placeholder="dd/mm/aaaa" 
	          value="<?php echo $post[answer][status_evolution_begin] ?>">
	        </label>


	        <label class="ls-label col-md-12 col-sm-12">
	          <b class="ls-label-text">11. Classificação final do diagnóstico de internação hospitalar:</b>
	          <div class="ls-custom-select">
	            <select class="ls-custom" name="answer[final_classification]">
	            	<option selected="selected" value="">Escolher opção</option>
	              <?php foreach ($post['form']['selects']['final_classification'] as $item): ?>
	                <?php $selected = ($post['form']['name'] == $item['name'] ? 'selected' : '') ?>
	                <option <?php echo $selected ?> value="<?php echo $item['name'] ?>">
	                  <?php echo $item['name'] ?>
	                </option>
	              <?php endforeach ?>
	            </select>
	          </div>
	        </label>

					<div class="ls-label col-md-12 col-sm-12">
					 <b class="ls-label-text">CID-10 do diagnótico principal</b>
					 <textarea rows="2" name="answer[cid_10]" ></textarea>
					</div>

					<div class="ls-label col-md-12 col-sm-12">
					 <b class="ls-label-text">Específique</b>
					 <textarea rows="2" name="answer[final_classification_observation]"></textarea>
					</div>

					<div class="ls-label col-md-12 col-sm-12">
					 <b class="ls-label-text">Observações</b>
					 <textarea rows="3" name="answer[observation]"></textarea>
					</div>
        
				</fieldset>



				<div class="ls-actions-btn ls-txt-right">
					<button class="ls-btn ls-btn-primary ls-ico-thumbs-up" name="form[op]" value="create">Enviar pesquisa</button>
				</div>

			</form>
		</div>
	</div>

 </div>
</main>

<?php include($base_path.'/templates/vuejs/field-search-form/geo-localization.html') ?>