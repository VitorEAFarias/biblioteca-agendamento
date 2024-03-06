<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

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

  .p-cor-google {
    border-radius: 10px;
    padding-top: 4px;
    padding-left: 10px;
    padding-right: 10px;
    padding-bottom: 4px;
    max-width: 190px !important;
    text-align: center;
  }
</style>

<main class="ls-main ">
  <div class="container-fluid">
    <?php include($base_path . 'templates/alert-template.php') ?>

    <form action="#" method="post" class="ls-form ls-form-horizontal">
      <div class="row mt-4">

        <div class="ls-label col-md-2">
          <div class="form-field">
            <b class="ls-label-text">Evento</b>
            <input type="text" name="form[evento]" class="ls-field" autocomplete="off" placeholder="Nome do Evento" value="<?php echo $post['form']['evento'] ?>">
          </div>
        </div>

        <div class="ls-label col-md-3">
          <div class="form-field">
            <b class="ls-label-text">Local</b>
            <input type="text" name="form[local]" class="ls-field" autocomplete="off" placeholder="Local" value="<?php echo $post['form']['local'] ?>">
          </div>
        </div>

        <div class="ls-label col-md-3">
          <div class="form-field">
            <b class="ls-label-text">Situação</b>
            <div class="ls-custom-select">
              <select class="ls-custom" name="form[status]">
                <option value="">TODOS</option>
                <?php foreach ($post['form']['selects']['agendamento_status'] as $item) : ?>
                  <?php $selected = ($post['form']['status'] == $item['value'] ? 'selected' : '') ?>
                  <option <?php echo $selected ?> value="<?php echo $item['value'] ?>">
                    <?php echo $item['name'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>

        <div class="ls-label col-md-3">
          <div class="form-field">
            <b class="ls-label-text">Data Evento</b>
            <input type="date" name="form[data]" class="ls-field" autocomplete="off" placeholder="Data Evento" value="<?php echo $post['form']['data'] ?>">
          </div>
        </div>

        <label class="ls-label  col-md-1 ls-txt-right d-flex align-items-center">
          <button type="submit" name="form[op]" value="search" class="btn btn-primary btn-filtro"><i class="fas fa-filter"></i> Filtrar</button>
        </label>

      </div>
    </form>
    <h1 style="color: #0f4192">Minhas Solicitações</h1>
    <hr style="margin-bottom: 0">
    <div class="row">
      <table class="col-md-12 ls-table">
        <tr>
          <th width="7%">ID</th>
          <!--th>Solicitante</th>
                    <th>email</th-->
          <th width="25%">EVENTO</th>
          <!-- <th>Data Inicio</th> -->
          <th width="18%">DATA EVENTO</th>

          <th width="20%">LOCAL</th>
          <th width="10%">DATA DA SOLICITAÇÃO</th>
          <th width="15%">STATUS</th>
          <th width="5%"></th>
        </tr>
        <?php
        foreach ($results as $index =>  $item) : ?>
          <tr>
            <td><?php echo $item['evento_id'] ?></td>
            <td><?php echo $item['nomeEvento'] ?></td>
            <td>
              <?=
              empty($item['data_evento']) ? "-" : date('d/m/Y', strtotime($item['data_evento'])) . ' ' . $item['horaInicial'] . ' - ' . $item['horaFinal']
              ?>
            </td>

            <?php
            if ($item['nomeLocal'] != '') { ?>
              <td>
                <div style="background-color:<?= $item['color'] ?>" class="p-cor-google text-white">
                  <?php echo $item['nomeLocal'] ?></div>
              </td>
            <?php } else { ?>
              <td>
                <div style="background-color: grey" class="p-cor-google text-white">Não Definido</div>
              </td>
            <?php  }
            ?>
            <td><?php echo date('d/m/Y', strtotime($item['create_date'])) ?></td>
            <td><?php
                switch ($item['status']) {
                  case 0:
                    echo 'Em análise';
                    break;
                  case 1:
                    echo 'Não Aprovado';
                    break;
                  case 2:
                    if ($item['cancelado'] == 1) {
                      echo 'Cancelado';
                    } else {
                      echo 'Aprovado';
                    }
                    break;
                  case 3:
                    echo 'Cancelado';
                    break;
                  default:
                    echo $item['cancelado'] == 1 ? 'Cancelado' : 'Aprovado';
                    break;
                }
                ?></td>
            <?php

            if ($item['status'] == 2 && $item['cancelado'] != 1) {
              echo '<td>
                                <div class="ls-txt-center ls">
                                    <div data-ls-module="dropdown" class="ls-dropdown">
                                    <a href="#" class="ls-btn-primary actions"><i class="fas fa-ellipsis-v" style="color: black; font-size: 16px;"></i></a>
                                      <ul class="ls-dropdown-nav">
                                        <li><a href="/agendamentos/status/' . $item["evento_id"] . '/3";">Cancelar Socilitação</a></li>
                                        <li><a href="/agendamentos/send-ical/' . $item["evento_id"] . '";">Google Agenda</a></li>
                                      </ul>
                                    </div>                  
                                </div>
                              </td>';
            } else if ($item['status'] == 0) {
              echo '<td>
                                <div class="ls-txt-center ls">
                                    <div data-ls-module="dropdown" class="ls-dropdown">
                                    <a href="#" class="ls-btn-primary actions"><i class="fas fa-ellipsis-v" style="color: black; font-size: 16px;"></i></a>
                                      <ul class="ls-dropdown-nav">
                                        <li><a href="/agendamentos/status/' . $item["evento_id"] . '/3";">Cancelar Socilitação</a></li>
                                      </ul>
                                    </div>                  
                                </div>
                              </td>';
            };
            ?>

          </tr>
        <?php endforeach ?>
      </table>

    </div>

  </div>
</main>