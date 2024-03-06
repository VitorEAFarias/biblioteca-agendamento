<?php
if ($user['user_adm'] == 0) {
  header('Refresh: 1; URL= ../dashboard');
  die();
} ?>

<style>
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

<main class="ls-main">



  <div class="container-fluid">

    <?php include($base_path . '/templates/alert-template.php') ?>

    <div class="row mt-4">
      <form action="/categorias" method="post">
        <div class="row d-flex align-items-center">
          <div class="ls-label col-md-3 ">
            <div class="form-field">
              <b class="ls-label-text">Código</b>
              <input type="text" name="form[id]" class="ls-field" value="<?php echo $post['form']['id'] ?>">
            </div>
          </div>

          <div class="ls-label col-md-4">
            <div class="form-field">
              <b class="ls-label-text">Nome</b>
              <input type="text" name="form[nome]" class="ls-field" value="<?php echo $post['form']['nome'] ?>">
            </div>
          </div>

          <div class="ls-label col-md-4 ">
            <div class="form-field">
              <b class="ls-label-text">Situação</b>
              <div class="ls-custom-select">
                <select class="ls-custom" name="form[status]">
                  <?php foreach ($post['form']['selects']['select_status'] as $item) : ?>
                    <?php $selected = ($post['form']['status'] == $item['id'] ? 'selected' : '') ?>
                    <option <?php echo $selected ?> value="<?php echo $item['id'] ?>">
                      <?php echo $item['name'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>

          <label class="ls-label col-md-1 ls-txt-right">
            <button type="submit" name="form[op]" value="search" class="btn btn-primary btn-filtro"><i class="fas fa-filter"></i> Filtrar</button>

          </label>
        </div>

      </form>
    </div>

    <div class="row">
      <div class="d-flex align-items-center justify-content-between">
        <h1 style="color: #0f4192">Categorias</h1>
        <a href="/categorias/create" class="btn btn-cadastro"><i class="fas fa-pencil-alt"></i> Cadastrar</a>
      </div>
      <hr style="margin-bottom: 0 !important">
      <table class="col-md-12 ls-table" border="0">
        <tr>
          <th width="15%" style="color: #0f4192">CÓDIGO</th>
          <th width="30%" style="color: #0f4192">NOME DA CATEGORIA</th>
          <th width="30%" style="color: #0f4192">SITUAÇÃO</th>
          <th width="10%"></th>
        </tr>
        <?php foreach ($results as $item) : ?>
          <tr>
            <td><?php echo $item['id'] ?></td>
            <td><?php echo $item['nome'] ?></td>


            <td>
              <?php
              if ($item['status'] == 1) { ?>
                <span style="color: green !important">Ativo</span>
              <?php } else { ?>
                <span style="color: red !important">Desativado</span>
              <?php }
              ?>
            </td>

            <td>
              <div class="d-flex justify-content-end">
                <?php if ($item['status'] == 1) : ?>
                  <div data-ls-module="dropdown" class="ls-dropdown">
                    <a href="#" class="ls-btn-primary actions"><i class="fas fa-ellipsis-v" style="color: black; font-size: 16px;"></i></a>
                    <ul class="ls-dropdown-nav">
                      <li><a href="<?php echo '/categorias/edit/' . $item['id'] ?>">Editar</a></li>
                      <li><a href="<?php echo '/categorias/status/' . $item['id'] . '/0'; ?>">Desativar</a></li>
                    </ul>
                  </div>
                <?php endif ?>

                <?php if ($item['status'] == 0) : ?>
                  <a href="<?php echo '/categorias/status/' . $item['id'] . '/1'; ?>" class="ls-btn-danger ls-ico-plus">Ativar</a>
                <?php endif ?>

              </div>
            </td>

          </tr>
        <?php endforeach ?>
      </table>
    </div>

  </div>
</main>