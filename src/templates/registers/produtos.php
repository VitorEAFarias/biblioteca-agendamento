<main class="ls-main ">
  <div class="container-fluid">
    <h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>

    <?php include($base_path.'templates/alert-template.php') ?>
    
    <div class="row ls-box-filter">
      <form action="/cadastro/produtos" method="post" class="ls-form ls-form-horizontal">
          
        <label class="ls-label col-md-4">
          <b class="ls-label-text">Classe</b>
          <div class="ls-custom-select">
            <select class="ls-custom" name="form[product_class_id]" >
              <option selected="selected" value="%">Qualquer classe</option>
              <?php foreach ($post['form']['selects']['products_class'] as $item): ?>
                <?php $selected = ($post['form']['product_class_id'] == $item['id'] ? 'selected' : '') ?>
                <option <?php echo $selected ?> value="<?php echo $item['id'] ?>">
                  <?php echo $item['name'] ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
        </label>

        <label class="ls-label col-md-8">
          <b class="ls-label-text">Fornecedor</b>
          <div class="ls-custom-select">
            <select class="ls-custom" name="form[provider_id]">
              <option selected="selected" value="%">Qualquer Fornecedor</option>
              <?php foreach ($post['form']['selects']['providers'] as $item): ?>
                <?php $selected = ($post['form']['provider_id'] == $item['id'] ? 'selected' : '') ?>
                <option <?php echo $selected ?> value="<?php echo $item['id'] ?>">
                  <?php echo utf8_encode($item['name']) ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
        </label>

        <label class="ls-label col-md-2">
          <b class="ls-label-text">Código</b>
          <input type="text" name="form[id]" placeholder="Código" class="ls-field" 
          value="<?php echo $post['form']['id'] ?>">
        </label>

        <label class="ls-label col-md-2">
          <b class="ls-label-text">Medida</b>
          <input type="text" name="form[measures]" placeholder="Medida" class="ls-field" 
          value="<?php echo $post['form']['measures'] ?>">
        </label>

        <label class="ls-label col-md-2">
          <b class="ls-label-text">Modelo</b>
          <input type="text" name="form[model]" placeholder="Modelo" class="ls-field" 
          value="<?php echo $post['form']['model'] ?>">
        </label>

        <label class="ls-label col-md-2">
          <b class="ls-label-text">Watts</b>
          <input type="text" name="form[watts]" placeholder="Watts" class="ls-field" 
          value="<?php echo $post['form']['watts'] ?>">
        </label>

        <label class="ls-label col-md-4 ls-txt-right"> 
          <button type="submit" name="form[op]" value="search" class="ls-btn-primary ls-ico-search">Filtrar</button>
          <a href="/cadastro/produtos/adicionar" class="ls-btn ls-ico-plus" target="_blank">Cadastrar</a>
        </label>

        

      </form>
    </div>

    <div class="row">
      <table class="col-md-12 ls-table ls-table-striped" border="0">
        <tr>
          <th width="9%">Cód.</th>
          <th width="20%">Nome</th>
          <th>Watts</th>
          <th>Volts</th>
          <th>Medida</th>
          <th>Modelo</th>
          <th></th>
        </tr>
        <?php foreach ($results as $index => $item): ?>
        <tr>
          <td><?php echo $item['id'] ?></td> 
          <td><?php echo utf8_encode($item['name']) ?></td> 
          <td><?php echo utf8_encode($item['watts']) ?></td> 
          <td><?php echo utf8_encode($item['volts']) ?></td> 
          <td><?php echo utf8_encode($item['measures']) ?></td> 
          <td><?php echo utf8_encode($item['model']) ?></td> 
          <td>
            <div class="ls-txt-center ls">
              <div data-ls-module="dropdown" class="ls-dropdown">
                <a href="#" class="ls-btn-primary">Ações</a>
                <ul class="ls-dropdown-nav">
                  <li>
                    <a href="<?php echo '/cadastro/produtos/'.$item['id'] ?>" target="_blank" >Editar</a>
                  </li>
                  <li>
                    <a href="<?php echo '/cadastro/produtos/copiar/'.$item['id'] ?>" target="_blank" >Copiar</a>
                  </li>
                  <li>
                    <a data-ls-module="modal" data-target="<?php echo '#'.$index.'-desenho' ?>">Desenhos</a>
                  </li>
                </ul>
              </div>  
            </div>
          </td>
        </tr>
        <?php endforeach ?>
      </table>
      <small>Os 100 primeiros resultados da pesquisa realizada em <?php echo date('d/m/Y') ?></small>
    </div>

  </div>
</main>

<?php foreach ($results as $index => $item): ?>

<div class="ls-modal" id="<?php echo $index.'-desenho' ?>">
  <div class="ls-modal-box">
    <div class="ls-modal-header">
      <button data-dismiss="modal">&times;</button>
      <h4 class="ls-modal-title">Desenho do produto: <?php echo $item['id'] ?></h4>
    </div>
    <div class="ls-modal-body">
      <div class="row">
        <div class="col-md-12">
          <?php if (@file_get_contents('http://watternes.com.br/desenhos-tecnicos/'.$item['id'].'.jpg')): ?>
            <img src="<?php echo 'http://watternes.com.br/desenhos-tecnicos/'.$item['id'].'.jpg' ?>" width="100%">  
          <?php endif ?>
        </div>
      </div>
    </div>
    <div class="ls-modal-footer">
    </div>
  </div>
</div>

<?php endforeach ?>