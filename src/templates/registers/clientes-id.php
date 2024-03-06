<main class="ls-main ">
  <div class="container-fluid">

    <h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>  

    <?php include($base_path.'templates/alert-template.php') ?>
    
    <div class="row">
      
      <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="ls-form ls-form-horizontal">

        <fieldset>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Código</b>
            <input type="text" name="client[id]" placeholder="Código" class="ls-field" 
            value="<?php echo round($client['id']) ?>" 
            <?php echo ($operator['type'] == 'edit' ? 'disabled' : '') ?> 
            required >
          </label>

          <label class="ls-label col-md-5">
            <b class="ls-label-text">Nome</b>
            <input type="text" name="client[name]" placeholder="Nome" class="ls-field" 
            value="<?php echo $client['name'] ?>" 
            required >
          </label>

          <label class="ls-label col-md-2">
            <b class="ls-label-text">Categoria</b>
            <input type="text" name="client[category]" placeholder="Categoria" class="ls-field" 
            value="<?php echo utf8_encode($client['category']) ?>" 
            disabled >
          </label>

          <label class="ls-label col-md-3">
            <b class="ls-label-text">Vendedor</b>
            <div class="ls-custom-select">
              <select class="ls-custom" name="client[salesman_id]" required disabled>
                <option selected="selected" value="0">Selecione a vendedor</option>
                <?php foreach ($post['form']['selects']['salesmen'] as $item): ?>
                  <?php $selected = ($client['salesman_id'] == $item['id'] ? 'selected' : '') ?>
                  <option <?php echo $selected ?> value="<?php echo $item['id'] ?>">
                    <?php echo round($item['id']) . ' - ' . utf8_encode($item['name']) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </label>

        </fieldset>

        <fieldset>
          <ul class="ls-tabs-nav col-md-12">
            <li class="ls-active"><a data-ls-module="tabs" href="#address">Endereço</a></li>
            <li><a data-ls-module="tabs" href="#billing">Cobrança</a></li>
            <li><a data-ls-module="tabs" href="#delivery">Entrega</a></li>
            <li><a data-ls-module="tabs" href="#contacts">Contatos</a></li>
          </ul>
          <div class="ls-tabs-container col-md-12">

            <div id="address" class="ls-tab-content ls-active">
              <label class="ls-label col-md-6">
                <b class="ls-label-text">Endereço</b>
                <input type="text" name="client[address]" placeholder="Endereço" class="ls-field" 
                value="<?php echo utf8_encode($client['address']) ?>" >
              </label>
              <label class="ls-label col-md-3">
                <b class="ls-label-text">Número</b>
                <input type="text" name="client[number]" placeholder="Número" class="ls-field" 
                value="<?php echo utf8_encode($client['number']) ?>" >
              </label>
              <label class="ls-label col-md-3">
                <b class="ls-label-text">Complemento</b>
                <input type="text" name="client[address_complement]" placeholder="Complemento" class="ls-field" 
                value="<?php echo utf8_encode($client['address_complement']) ?>" >
              </label>
              <label class="ls-label col-md-4">
                <b class="ls-label-text">Bairro</b>
                <input type="text" name="client[neighborhood]" placeholder="Bairro" class="ls-field" 
                value="<?php echo utf8_encode($client['neighborhood']) ?>" >
              </label>
              <label class="ls-label col-md-4">
                <b class="ls-label-text">Cidade</b>
                <input type="text" name="client[city]" placeholder="Cidade" class="ls-field" 
                value="<?php echo utf8_encode($client['city']) ?>" >
              </label>
              <label class="ls-label col-md-2">
                <b class="ls-label-text">Estado</b>
                <input type="text" name="client[state]" placeholder="Estado" class="ls-field" 
                value="<?php echo utf8_encode($client['state']) ?>" >
              </label>
              <label class="ls-label col-md-2">
                <b class="ls-label-text">CEP</b>
                <input type="text" name="client[zip_code]" placeholder="CEP" class="ls-field" 
                value="<?php echo utf8_encode($client['zip_code']) ?>" >
              </label>              
            </div>

            <div id="billing" class="ls-tab-content">
              <label class="ls-label col-md-6">
                <b class="ls-label-text">Endereço</b>
                <input type="text" name="client[billing_address]" placeholder="Endereço" class="ls-field" 
                value="<?php echo utf8_encode($client['billing_address']) ?>" >
              </label>
              <label class="ls-label col-md-3">
                <b class="ls-label-text">Número</b>
                <input type="text" name="client[billing_number]" placeholder="Número" class="ls-field" 
                value="<?php echo utf8_encode($client['billing_number']) ?>" >
              </label>
              <label class="ls-label col-md-3">
                <b class="ls-label-text">Complemento</b>
                <input type="text" name="client[billing_address_complement]" placeholder="Complemento" class="ls-field" 
                value="<?php echo utf8_encode($client['billing_address_complement']) ?>" >
              </label>
              <label class="ls-label col-md-4">
                <b class="ls-label-text">Bairro</b>
                <input type="text" name="client[billing_neighborhood]" placeholder="Bairro" class="ls-field" 
                value="<?php echo utf8_encode($client['billing_neighborhood']) ?>" >
              </label>
              <label class="ls-label col-md-4">
                <b class="ls-label-text">Cidade</b>
                <input type="text" name="client[billing_city]" placeholder="Cidade" class="ls-field" 
                value="<?php echo utf8_encode($client['billing_city']) ?>" >
              </label>
              <label class="ls-label col-md-2">
                <b class="ls-label-text">Estado</b>
                <input type="text" name="client[billing_state]" placeholder="Estado" class="ls-field" 
                value="<?php echo utf8_encode($client['billing_state']) ?>" >
              </label>
              <label class="ls-label col-md-2">
                <b class="ls-label-text">CEP</b>
                <input type="text" name="client[billing_zip_code]" placeholder="CEP" class="ls-field" 
                value="<?php echo utf8_encode($client['billing_zip_code']) ?>" >
              </label>
            </div>

            <div id="delivery" class="ls-tab-content">
              <label class="ls-label col-md-6">
                <b class="ls-label-text">Endereço</b>
                <input type="text" name="client[delivery_address]" placeholder="Endereço" class="ls-field" 
                value="<?php echo utf8_encode($client['delivery_address']) ?>" >
              </label>
              <label class="ls-label col-md-3">
                <b class="ls-label-text">Número</b>
                <input type="text" name="client[delivery_number]" placeholder="Número" class="ls-field" 
                value="<?php echo utf8_encode($client['delivery_number']) ?>" >
              </label>
              <label class="ls-label col-md-3">
                <b class="ls-label-text">Complemento</b>
                <input type="text" name="client[delivery_address_complement]" placeholder="Complemento" class="ls-field" 
                value="<?php echo utf8_encode($client['delivery_address_complement']) ?>" >
              </label>
              <label class="ls-label col-md-4">
                <b class="ls-label-text">Bairro</b>
                <input type="text" name="client[delivery_neighborhood]" placeholder="Bairro" class="ls-field" 
                value="<?php echo utf8_encode($client['delivery_neighborhood']) ?>" >
              </label>
              <label class="ls-label col-md-4">
                <b class="ls-label-text">Cidade</b>
                <input type="text" name="client[delivery_city]" placeholder="Cidade" class="ls-field" 
                value="<?php echo utf8_encode($client['delivery_city']) ?>" >
              </label>
              <label class="ls-label col-md-2">
                <b class="ls-label-text">Estado</b>
                <input type="text" name="client[delivery_state]" placeholder="Estado" class="ls-field" 
                value="<?php echo utf8_encode($client['delivery_state']) ?>" >
              </label>
              <label class="ls-label col-md-2">
                <b class="ls-label-text">CEP</b>
                <input type="text" name="client[delivery_zip_code]" placeholder="CEP" class="ls-field" 
                value="<?php echo utf8_encode($client['delivery_zip_code']) ?>" >
              </label>
            </div>

            <div id="contacts" class="ls-tab-content">
              
              <label class="ls-label col-md-3">
                <b class="ls-label-text">Contato</b>
                <input type="text" name="client[contact_1]" placeholder="Contato" class="ls-field" 
                value="<?php echo utf8_encode($client['contact_1']) ?>"  />
              </label>
              <label class="ls-label col-md-3">
                <b class="ls-label-text">Telefone</b>
                <input type="text" name="client[phone_1]" placeholder="Telefone" class="ls-field" 
                value="<?php echo utf8_encode($client['phone_1']) ?>"  />
              </label>
              <label class="ls-label col-md-6">
                <b class="ls-label-text">E-mail</b>
                <input type="text" name="client[mail_1]" placeholder="E-mail" class="ls-field" 
                value="<?php echo utf8_encode($client['mail_1']) ?>"  />
              </label>

              <label class="ls-label col-md-3">
                <input type="text" name="client[contact_2]" placeholder="Contato" class="ls-field" 
                value="<?php echo utf8_encode($client['contact_2']) ?>"  />
              </label>
              <label class="ls-label col-md-3">
                <input type="text" name="client[phone_2]" placeholder="Telefone" class="ls-field" 
                value="<?php echo utf8_encode($client['phone_2']) ?>"  />
              </label>
              <label class="ls-label col-md-6">
                <input type="text" name="client[mail_2]" placeholder="E-mail" class="ls-field" 
                value="<?php echo utf8_encode($client['mail_2']) ?>"  />
              </label>

              <label class="ls-label col-md-3">
                <input type="text" name="client[contact_3]" placeholder="Contato" class="ls-field" 
                value="<?php echo utf8_encode($client['contact_3']) ?>"  />
              </label>
              <label class="ls-label col-md-3">
                <input type="text" name="client[phone_3]" placeholder="Telefone" class="ls-field" 
                value="<?php echo utf8_encode($client['phone_3']) ?>"  />
              </label>
              <label class="ls-label col-md-6">
                <input type="text" name="client[mail_3]" placeholder="E-mail" class="ls-field" 
                value="<?php echo utf8_encode($client['mail_3']) ?>"  />
              </label>

              <label class="ls-label col-md-3">
                <input type="text" name="client[contact_4]" placeholder="Contato" class="ls-field" 
                value="<?php echo utf8_encode($client['contact_4']) ?>"  />
              </label>
              <label class="ls-label col-md-3">
                <input type="text" name="client[phone_4]" placeholder="Telefone" class="ls-field" 
                value="<?php echo utf8_encode($client['phone_4']) ?>"  />
              </label>
              <label class="ls-label col-md-6">
                <input type="text" name="client[mail_4]" placeholder="E-mail" class="ls-field" 
                value="<?php echo utf8_encode($client['mail_4']) ?>"  />
              </label>

              <label class="ls-label col-md-3">
                <input type="text" name="client[contact_5]" placeholder="Contato" class="ls-field" 
                value="<?php echo utf8_encode($client['contact_5']) ?>"  />
              </label>
              <label class="ls-label col-md-3">
                <input type="text" name="client[phone_5]" placeholder="Telefone" class="ls-field" 
                value="<?php echo utf8_encode($client['phone_5']) ?>"  />
              </label>
              <label class="ls-label col-md-6">
                <input type="text" name="client[mail_5]" placeholder="E-mail" class="ls-field" 
                value="<?php echo utf8_encode($client['mail_5']) ?>"  />
              </label>

              <label class="ls-label col-md-3">
                <input type="text" name="client[contact_6]" placeholder="Contato" class="ls-field" 
                value="<?php echo utf8_encode($client['contact_6']) ?>"  />
              </label>
              <label class="ls-label col-md-3">
                <input type="text" name="client[fax]" placeholder="Telefone" class="ls-field" 
                value="<?php echo utf8_encode($client['fax']) ?>"  />
              </label>
              <label class="ls-label col-md-6">
                <input type="text" name="client[mail_6]" placeholder="E-mail" class="ls-field" 
                value="<?php echo utf8_encode($client['mail_6']) ?>"  />
              </label>
            </div>

          </div>
        </fieldset>

        <fieldset>
          <div class="col-md-12">
            <label class="ls-label col-md-12">
              <b class="ls-label-text">Observação</b>
              <textarea name="client[observation]" 
              rows="6"><?php echo utf8_encode($client['observation']) ?></textarea>
            </label>            
          </div>
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