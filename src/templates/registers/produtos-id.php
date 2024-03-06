<main class="ls-main ">
  <div class="container-fluid">

    <h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>  

    <?php include($base_path.'templates/alert-template.php') ?>
    
    <div class="row">
      
      <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="ls-form ls-form-horizontal">
        <fieldset>

          <label class="ls-label col-md-4">
            <b class="ls-label-text">Classe</b>
            <div class="ls-custom-select">
              <select class="ls-custom" name="product[product_class_id]" required>
                <option selected="selected" value="0">Selecione a classe</option>
                <?php foreach ($post['form']['selects']['products_class'] as $item): ?>
                  <?php $selected = ($product['product_class_id'] == $item['id'] ? 'selected' : '') ?>
                  <option <?php echo $selected ?> value="<?php echo $item['id'] ?>">
                    <?php echo round($item['id']) . ' - ' . utf8_encode($item['name']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </label>


          <label class="ls-label col-md-4">
            <b class="ls-label-text">Produto Base</b>
            <div class="ls-custom-select">
              <select class="ls-custom" name="product[raw_product_base_id]" required>
                <option selected="selected" value="0">Selecione a Produto</option>
                <?php foreach ($post['form']['selects']['raw_product_base'] as $item): ?>
                  <?php $selected = ($product['raw_product_base_id'] == $item['id'] ? 'selected' : '') ?>
                  <option <?php echo $selected ?> value="<?php echo round($item['id']) ?>">
                    <?php echo round($item['id']) . ' - ' . utf8_encode($item['measures']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </label>

          <label class="ls-label col-md-4">
            <b class="ls-label-text">Fornecedor</b>
            <div class="ls-custom-select">
              <select class="ls-custom" name="product[provider_id]"  required>
                <option selected="selected" value="0">Selecione a Fornecedor</option>
                <?php foreach ($post['form']['selects']['providers'] as $item): ?>
                  <?php $selected = ($product['provider_id'] == $item['id'] ? 'selected' : '') ?>
                  <option <?php echo $selected ?> value="<?php echo round($item['id']) ?>">
                    <?php echo utf8_encode($item['name']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Código</b>
            <input type="text" name="product[id]" placeholder="Código" class="ls-field" 
            value="<?php echo round($product['id']) ?>" 
            <?php echo ($operator['type'] == 'edit' ? 'disabled' : '') ?> 
            required >
          </label>

          <label class="ls-label col-md-6">
            <b class="ls-label-text">Descrição</b>
            <input type="text" name="product[name]" placeholder="Nome" class="ls-field" 
            value="<?php echo utf8_encode($product['name']) ?>" required >
          </label>

          <label class="ls-label col-md-3">
            <b class="ls-label-text">NCM</b>
            <div class="ls-custom-select">
              <select class="ls-custom" name="product[classification]" required >
                <option selected="selected" value="0">Selecione a NCM</option>
                <?php foreach ($post['form']['selects']['classifications'] as $item): ?>
                  <?php $selected = ($product['classification'] == $item['id'] ? 'selected' : '') ?>
                  <option <?php echo $selected ?> value="<?php echo $item['id'] ?>">
                    <?php echo round($item['id']) . ' - ' . utf8_encode($item['description']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </label>

          <label class="ls-label col-md-1">
            <b class="ls-label-text">Unidade</b>
            <input type="text" name="product[unit_measure]" placeholder="Unidade" class="ls-field" 
            value="<?php echo utf8_encode($product['unit_measure']) ?>" required list="unidades">
            <datalist id="unidades">
              <option value="PC">
              <option value="MT">
              <option value="LT">
              <option value="KG">
            </datalist>
          </label>

          <label class="ls-label col-md-3">
            <b class="ls-label-text">Medida</b>
            <input type="text" name="product[measures]" placeholder="Medida" class="ls-field" 
            value='<?php echo utf8_encode($product['measures']) ?>' required >
          </label>
          <label class="ls-label col-md-3">
            <b class="ls-label-text">Modelo</b>
            <input type="text" name="product[model]" placeholder="Modelo" class="ls-field" 
            value="<?php echo utf8_encode($product['model']) ?>"  >
          </label>
          <label class="ls-label col-md-2">
            <b class="ls-label-text">Watts</b>
            <input type="text" name="product[watts]" placeholder="Watts" class="ls-field" 
            value="<?php echo utf8_encode($product['watts']) ?>"  >
          </label>
          <label class="ls-label col-md-2">
            <b class="ls-label-text">Volts</b>
            <input type="text" name="product[volts]" placeholder="Volts" class="ls-field" 
            value="<?php echo utf8_encode($product['volts']) ?>"  >
          </label>
          <label class="ls-label col-md-2">
            <b class="ls-label-text">Material</b>
            <input type="text" name="product[material]" placeholder="Material" class="ls-field" 
            value="<?php echo utf8_encode($product['material']) ?>" required >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Preço Uni.</b><small>*Use ponto ao invés de virgúla</small>
            <input type="number" step="0.01" min="0.00" name="product[sale_price]" class="ls-field" 
            value="<?php echo $product['sale_price'] ?>" >

          </label>
          <label class="ls-label col-md-2">
            <b class="ls-label-text">Preço Custo</b><small>*Use ponto ao invés de virgúla</small>
            <input type="number" step="0.01" min="0.00" name="product[cost_price]" class="ls-field" 
            value="<?php echo $product['cost_price'] ?>"  >
          </label>
          <label class="ls-label col-md-1">
            <b class="ls-label-text">IPI</b>
            <input type="number" step="0.01" min="0.00" name="product[tribute_ipi]" class="ls-field" 
            value="<?php echo $product['tribute_ipi'] ?>"  >
          </label>

        </fieldset>

        <fieldset>
        
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <h4 class="ls-title-4 ls-txt-center">Observações</h4>
              </div>
              <label class="ls-label col-md-12">
                <b class="ls-label-text">Dados Técnicas</b>
                <textarea name="product[technical_description]" 
                rows="6"><?php echo utf8_encode($product['technical_description']) ?></textarea>
              </label>
              <label class="ls-label col-md-12">
                <b class="ls-label-text">Dados Internos</b>
                <textarea name="product[internal_description]" 
                rows="6"><?php echo utf8_encode($product['internal_description']) ?></textarea>
              </label>
            </div>
          </div>

          <div class="col-md-8">
            <div class="row">
              <div class="col-md-12">
                <h4 class="ls-title-4 ls-txt-center">Códigos de Clientes</h4>
              </div>
              <div class="col-md-12">
                <table class="ls-table">
                  <tr>                        
                    <th width="50%">Cliente</th>
                    <th>Código</th>
                    <th></th>
                  </tr>

                  <?php foreach ($codeByProduct as $index => $productByCode): ?>
                  <tr>
                    <td>
                      <label class="ls-label" style="margin-bottom: 0px;">
                        <div class="ls-custom-select">
                          <select class="ls-custom" name="<?php echo 'codeByProduct['.$index.'][client_id]' ?>">
                            <option selected="selected" value="0">Selecione o Cliente</option>
                            <?php foreach ($post['form']['selects']['clients'] as $item): ?>
                              <?php $selected = ($productByCode['client_id'] == $item['id'] ? 'selected' : '') ?>
                              <option <?php echo $selected ?> value="<?php echo $item['id'] ?>">
                                <?php echo utf8_encode($item['name']) ?>
                              </option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </label>                           
                    </td>
                    <td>
                      <label class="ls-label" style="margin-bottom: 0px;">
                        <input type="text" name="<?php echo 'codeByProduct['.$index.'][code]' ?>"
                        class="ls-field" value="<?php echo $productByCode['code'] ?>"  >  
                      </label>
                    </td>
                    <td>
                      <div data-ls-module="switchButton" class="ls-switch-btn ls-float-right">
                        <input type="checkbox" name="<?php echo 'codeByProduct['.$index.'][status]' ?>" 
                        <?php echo ($productByCode['status'] === false ? '' : 'checked') ?>
                        id="selectorSwitch" value="check" >
                        <label class="ls-switch-label" for="selectorSwitch" name="label-selectorSwitch" 
                        ls-switch-off="Removido"
                        ls-switch-on="Cadastrado"><span></span>
                        </label>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach ?>
                </table>
              </div>

            </div>
          </div>

        </fieldset>

        <fieldset>

          <div class="col-md-12">
            <h4 class="ls-title-4 ls-txt-center">Especificações Técnicas</h4>
          </div>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Vareta</b>
            <input type="text" name="product[rod]" placeholder="Vareta" class="ls-field" 
            value="<?php echo utf8_encode($product['rod']) ?>"  >
          </label>
          <label class="ls-label col-md-2">
            <b class="ls-label-text">Fio</b>
            <input type="text" name="product[wire]" placeholder="Fio" class="ls-field" 
            value="<?php echo utf8_encode($product['wire']) ?>"  >
          </label>
          <label class="ls-label col-md-2">
            <b class="ls-label-text">Metros</b>
            <input type="text" name="product[meters]" placeholder="Metros" class="ls-field" 
            value="<?php echo utf8_encode($product['meters']) ?>"  >
          </label>
          <label class="ls-label col-md-2">
            <b class="ls-label-text">Ohms. Inic.</b>
            <input type="text" name="product[init_amp]" placeholder="Ohms. Inic." class="ls-field" 
            value="<?php echo utf8_encode($product['init_amp']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Ohms. Final</b>
            <input type="text" name="product[final_amp]" placeholder="Ohms. Final" class="ls-field" 
            value="<?php echo utf8_encode($product['final_amp']) ?>"  >
          </label>
          <label class="ls-label col-md-2">
            <b class="ls-label-text">Tubos</b>
            <input type="text" name="product[tubes]" placeholder="Tubos" class="ls-field" 
            value="<?php echo utf8_encode($product['tubes']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Corte</b>
            <input type="text" name="product[cut]" placeholder="Corte" class="ls-field" 
            value="<?php echo utf8_encode($product['cut']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Final</b>
            <input type="text" name="product[final]" placeholder="Final" class="ls-field" 
            value="<?php echo utf8_encode($product['final']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Pino</b>
            <input type="text" name="product[pine]" placeholder="Pino" class="ls-field" 
            value="<?php echo utf8_encode($product['pine']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">2 Pinos</b>
            <input type="text" name="product[2_pine]" placeholder="2 Pinos" class="ls-field" 
            value="<?php echo utf8_encode($product['2_pine']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Ohm. Menor</b>
            <input type="text" name="product[powder]" placeholder="Ohm. Menor" class="ls-field" 
            value="<?php echo utf8_encode($product['powder']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Ohm. Maior</b>
            <input type="text" name="product[open_wire]" placeholder="Ohm. Maior" class="ls-field" 
            value="<?php echo utf8_encode($product['open_wire']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Ohm. Encontrada</b>
            <input type="text" name="product[resistence_ohm]" placeholder="Ohm. Encontrada" class="ls-field" 
            value="<?php echo utf8_encode($product['resistence_ohm']) ?>"  >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Cópia de Produto</b>
            <input type="text" name="product[tape]" placeholder="Cópia de Produto" class="ls-field" 
            value="<?php echo utf8_encode($product['tape']) ?>"  >
          </label>


          <label class="ls-label col-md-2">
            <b class="ls-label-text">N Elementos</b>
            <input type="text" name="product[elements]" placeholder="Elementos" class="ls-field" 
            value="<?php echo utf8_encode($product['elements']) ?>"  >
          </label>


          <input type="hidden" name="product[create_date]" value="<?php echo $product['create_date'] ?>"  

        </fieldset>
        <div class="ls-actions-btn ls-txt-right">
          
          <?php if ($operator == 'edit'): ?>
          <button class="ls-btn ls-btn-primary" name="form[op]" value="update">Alterar</button>
          <?php endif ?>

          <?php if ($operator == 'create'): ?>
          <button class="ls-btn ls-btn-primary" name="form[op]" value="create">Cadastrar</button>
          <?php endif ?>

          <?php if ($operator == 'copy'): ?>
          <button class="ls-btn ls-btn-primary" name="form[op]" value="create">Cadastar Cópia</button>
          <?php endif ?>
          
          <button class="ls-btn-danger" onclick="window.close();" >Fechar</button>
        </div>
      </form>
    </div>

  </div>
</main>