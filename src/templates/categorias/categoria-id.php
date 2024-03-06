<main class="ls-main ">
  <div class="container-fluid">

    <?php include($base_path . '/templates/alert-template.php') ?>

    <div class="row mt-4">

      <form action="<?php echo $action ?>" method="post" class="ls-form ls-form-horizontal mt-3">
        <div class="row form-content">
          <?php
          if ($operator == 'create') { ?>
            <h3 style="color: #0f4192; font-weight: bold">Cadastro de Categoria</h3>
          <?php  } else { ?>
            <h3 style="color: #0f4192; font-weight: bold">Edição de Categoria</h3>
          <?php   } ?>

          <label class="ls-label col-md-4 mt-3">
            <b class="ls-label-text">Categoria</b>
            <input type="text" name="registry[nome]" placeholder="Nome" class="ls-field" value="<?php echo $registry['nome'] ?>" required>
          </label>


          <div class="d-flex align-items-center justify-content-end">
            <a href="/categorias"><button class="btn btn-voltar" type="button">Voltar</button></a>

            <?php if ($operator == 'edit') : ?>
              <button class="btn btn-executar" name="form[op]" value="update">Alterar</button>
            <?php endif ?>

            <?php if ($operator == 'create') : ?>
              <button class="btn btn-executar" name="form[op]" value="create">Cadastrar</button>
            <?php endif ?>

          </div>
        </div>

      </form>
    </div>

  </div>
</main>