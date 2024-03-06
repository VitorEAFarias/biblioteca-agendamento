<main class="ls-main ">
  <div class="container-fluid">
    <h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>
    
    <div class="row ls-box-filter">
    </div>

    <div class="row">
      <table class="col-md-12 ls-table ls-table-striped" border="0">
        <tr>
          <th width="10%">Còd.</th>
          <th width="20%">Name</th>
          <th>E-mail.</th>
          <th>Função</th>
          <th></th>
        </tr>
        <?php foreach ($results as $item): ?>
        <tr>
          <td><?php echo $item['id'] ?></td> 
          <td><?php echo $item['name'] ?></td> 
          <td><?php echo $item['email'] ?></td> 
          <td><?php echo $item['role'] ?></td> 
          <td>
            <div class="ls-group-btn ls-group-active ls-txt-center ls">
              <div data-ls-module="dropdown" class="ls-dropdown">
                <a href="#" class="ls-btn-primary">Ações</a>
                <ul class="ls-dropdown-nav">
                  <!-- <li><a href="<?php echo '/cadastro/clientes/'.$item['id'] ?>" target="_blank" >Editar</a></li> -->
                  <li><a href="<?php echo '/cadastro/usuarios/alterar-senha/'.$item['id'] ?>" target="_blank" >Atualizar Senha</a></li>
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