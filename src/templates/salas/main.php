<?php
if ($user['user_adm'] == 0) {
  header('Refresh: 1; URL= ../dashboard');
  die();
} ?>
<style>
  #titulo-auditorio {
    color: #4463B0;
  }

  .form-field {
    display: flex;
    flex-direction: column;
    background-color: #f5f5f5;
    border-radius: 8px;
    padding: 5px;
  }

  .form-field input {
    background-color: #f5f5f5;
    border: none;
    box-shadow: none !important;
    border-radius: 0 !important;
    border-bottom: 1px solid #c6c6c6;
  }

  #area-filtrar {
    margin-left: 15px;
    display: flex;
    align-items: center;
  }

  .area-local-filtrar label {
    color: grey
  }

  .actions {
    background-color: transparent !important;
    border: none;
  }

  table th {
    color: #0F4192;
  }

  .p-cor-google {
    border-radius: 10px;
    padding-top: 4px;
    padding-left: 10px;
    padding-right: 10px;
    padding-bottom: 4px;
    max-width: 190px !important;
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

    <div class="py-4">
      <form action="<?php echo $action ?>" method="post" class="ls-form ls-form-horizontal">
        <div class="area-local-filtrar">
          <div class="d-flex">
            <div class="form-field col-md-3">
              <div class="form-floating">
                <b for="floatingInput">Nome do Local</b>
                <input type="text" class="form-control" name="form[nomeLocal]" id="floatingInput" value="<?php echo $post['form']['nomeLocal'] ?>">
              </div>
            </div>
            <div id="area-filtrar">
              <button type="submit" name="form[op]" value="search" class="btn-filtro btn">
                <i class="fas fa-filter"></i>
                Filtrar
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="d-flex justify-content-between">
      <h1 id="titulo-auditorio">Salas</h1>
      <div class="d-flex align-items-start">
        <a href="salas/form"><button class="btn-cadastro btn">
            <i class="fas fa-pencil-alt"></i> Cadastrar Sala
          </button></a>
      </div>
    </div>

    <div class="row">
      <div>
        <table class="col-md-12 ls-table" border="0">
          <tr>
            <th width="10%">ID</th>
            <th width="30%">NOME</th>
            <th width="25%">COR EXIBIDA NA AGENDA</th>
            <th width="25%">CAPACIDADE</th>
            <th width="15%">Disponível</th>
            <th width="10%"></th>
          </tr>
          <?php foreach ($results as $item) : ?>
            <tr>
              <td><?php echo $item['local_id'] ?></td>
              <td><?php echo $item['nomeLocal'] ?></td>
              <td>
                <div style="background-color:<?= $item['color'] ?>" class="p-cor-google text-white">
                  <?php echo $item['nomeLocal'] ?></div>
              </td>
              <td><?php echo $item['capacidade'] ?></td>
              <?php if ($item['disponivel'] == 1) : ?>
                <td>Sim</td>
              <?php else : ?>
                <td>Não</td>
              <?php endif; ?>
              <td>
                <div class="d-flex justify-content-end">
                  <div data-ls-module="dropdown" class="ls-dropdown">
                    <a href="#" class="ls-btn-primary actions"><i class="fas fa-ellipsis-v" style="color: black; font-size: 16px;"></i></a>
                    <ul class="ls-dropdown-nav">
                      <li><a href="<?php echo '/salas/form/' . $item['local_id'] ?>">Editar</a></li>
                    </ul>
                  </div>
                </div>
              </td>

            </tr>
          <?php endforeach ?>
        </table>
      </div>
    </div>

  </div>
</main>