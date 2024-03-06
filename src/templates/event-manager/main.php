<main class="ls-main ">
  <div class="container-fluid">
    <h1 class="ls-title-intro ls-ico-cog"><?= $title ?></h1>

    <?php include($base_path.'templates/alert-template.php') ?>
    
    <div class="row ls-box-filter">
      <label class="ls-label col-md-12 ls-txt-right"> 
        <button class="ls-btn ls-btn-primary ls-ico-spinner" onclick="window.location.reload()">Atualizar</button>
      </label>      
    </div>

    <div class="row">
      <table class="col-md-12 ls-table" border="0">
        <tr>
          <th>user</th>
          <th>operation</th>
          <th>date</th>
          <th>wasExecuted</th>
          <th>status</th>
          <th>entity</th>
          <th></th>
        </tr>
        <?php foreach ($results as $index =>  $item): ?>
        <tr class="<?php echo $item['alert'] ?>">
          <td><?php echo $item['user'] ?></td> 
          <td><?php echo $item['operation'] ?></td> 
          <td><?php echo date('H:i:s d/m/Y', strtotime($item['date'])) ?></td> 
          <td><?php echo $item['was_executed'].' - '.date('H:i:s d/m/Y', strtotime($item['date_executed'])) ?> </td> 
          <td><?php echo $item['status'] ?></td> 
          <td><?php echo $item['entity'] ?></td> 
          <td>
            <div class="ls-txt-center">
              <div data-ls-module="dropdown" class="ls-dropdown">
                <a href="#" class="ls-btn-primary">Ações</a>
                <ul class="ls-dropdown-nav">
                  <li>
                    <a data-ls-module="modal" data-target="<?php echo '#'.$index.'-log' ?>">Log</a>
                  </li>
                  <li>
                    <a data-ls-module="modal" data-target="<?php echo '#'.$index.'-data' ?>">Data</a>
                  </li>
                  <li>
                    <a data-ls-module="modal" data-target="<?php echo '#'.$index.'-id' ?>">Id</a>
                  </li>
                </ul>
              </div>  
            </div>
          </td>
        </tr>
        <?php endforeach ?>
      </table>
      
    </div>

  </div>
</main>

<?php foreach ($results as $index => $item): ?>

<div class="ls-modal" id="<?php echo $index.'-log' ?>">
  <div class="ls-modal-box">
    <div class="ls-modal-header">
      <button data-dismiss="modal">&times;</button>
      <h4 class="ls-modal-title">Log</h4>
    </div>
    <div class="ls-modal-body">
      <div class="row">
        <div class="col-md-12">
          <p><?php echo $item['log'] ?></p>
        </div>
      </div>
    </div>
    <div class="ls-modal-footer">
    </div>
  </div>
</div>    

<div class="ls-modal" id="<?php echo $index.'-data' ?>">
  <div class="ls-modal-large">
    <div class="ls-modal-header">
      <button data-dismiss="modal">&times;</button>
      <h4 class="ls-modal-title">Data</h4>
    </div>
    <div class="ls-modal-body">
      <div class="row">
        <table class="col-md-12 ls-table ls-table-striped" border="0">
          <tr>
            <th>Field</th>
            <th>Value</th>
          </tr>
          <?php foreach (json_decode($item['json_data'], true) as $field => $value): ?>
          <tr>
            <td><?php echo $field ?></td>
            <td><?php echo $value ?></td>
          </tr> 
          <?php endforeach ?>
        </table>
      </div>
    </div>
    <div class="ls-modal-footer">
    </div>
  </div>
</div>

<div class="ls-modal" id="<?php echo $index.'-id' ?>">
  <div class="ls-modal-box">
    <div class="ls-modal-header">
      <button data-dismiss="modal">&times;</button>
      <h4 class="ls-modal-title">ID</h4>
    </div>
    <div class="ls-modal-body">
      <div class="row">
        <table class="col-md-12 ls-table ls-table-striped" border="0">
          <tr>
            <th>Field</th>
            <th>Value</th>
          </tr>
          <?php foreach (json_decode($item['json_id_data'], true) as $field => $value): ?>
          <tr>
            <td><?php echo $field ?></td>
            <td><?php echo $value ?></td>
          </tr> 
          <?php endforeach ?>
        </table>
      </div>
    </div>
    <div class="ls-modal-footer">
    </div>
  </div>
</div>

<?php endforeach ?>