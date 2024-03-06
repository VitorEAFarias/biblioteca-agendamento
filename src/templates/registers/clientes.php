<main class="ls-main ">
  <div class="container-fluid">
    <h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>
    
    <div class="row ls-box-filter">
      <form action="/cadastro/clientes" method="post" class="ls-form ls-form-horizontal">
          
        <label class="ls-label col-md-2">
          <b class="ls-label-text">Categoria</b>
          <div class="ls-custom-select">
            <select class="ls-custom" name="form[category]" >
              <option selected="selected" value="%">Selecione a categoria</option>
              <?php foreach ($post['form']['selects']['categories'] as $item): ?>
                <?php $selected = ($post['form']['category'] == $item['letter'] ? 'selected' : '') ?>
                <option <?php echo $selected ?> value="<?php echo $item['letter'] ?>">
                  <?php echo $item['letter'] ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
        </label>

        <label class="ls-label col-md-4">
          <b class="ls-label-text">Vendedor</b>
          <div class="ls-custom-select">
            <select class="ls-custom" name="form[salesman_id]">
              <option selected="selected" value="%">Selecione a Vendedor</option>
              <?php foreach ($post['form']['selects']['salesmen'] as $item): ?>
                <?php $selected = ($post['form']['salesman_id'] == $item['id'] ? 'selected' : '') ?>
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

        <label class="ls-label col-md-4">
          <b class="ls-label-text">Name</b>
          <input type="text" name="form[name]" placeholder="Name" class="ls-field" 
          value="<?php echo $post['form']['name'] ?>">
        </label>

        <label class="ls-label col-md-12 ls-txt-right"> 
          <button type="submit" name="form[op]" value="search" class="ls-btn ls-btn-primary">Filtrar</button>
          <!-- <a href="/cadastro/produtos/adicionar" class="ls-btn" target="_blank">Cadastrar</a> -->
        </label>

        

      </form>
    </div>

    <div class="row">
      <table class="col-md-12 ls-table ls-table-striped" border="0">
        <tr>
          <th width="10%">Còd.</th>
          <th width="40%">Name</th>
          <th>Vendedores.</th>
          <th width="5%">Cat.</th>
          <th></th>
        </tr>
        <?php foreach ($results as $item): ?>
        <tr>
          <td><?php echo $item['id'] ?></td> 
          <td><?php echo utf8_encode($item['name']) ?></td> 
          <td><?php echo utf8_encode($item['salesman_name']) ?></td> 
          <td><?php echo utf8_encode($item['category']) ?></td> 
          <td>
            <div class="ls-group-btn ls-group-active ls-txt-center ls">
              <div data-ls-module="dropdown" class="ls-dropdown">
                <a href="#" class="ls-btn-primary">Ações</a>
                <ul class="ls-dropdown-nav">
                  <li><a href="<?php echo '/cadastro/clientes/'.$item['id'] ?>" target="_blank" >Editar</a></li>
                </ul>
              </div>  
            </div>
          </td>
        </tr>
        <?php endforeach ?>
      </table>
      <small>Os 50 primeiros resultados da pesquisa realizada em <?php echo date('d/m/Y') ?></small>
    </div>

  </div>
</main>