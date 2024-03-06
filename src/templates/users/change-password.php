<main class="ls-main ">
  <div class="container-fluid">

    <h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>  
    
    <?php include($base_path.'/templates/alert-template.php') ?>
    
    <div class="row">
      
      <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="ls-form ls-form-horizontal">

        <fieldset>

          <label class="ls-label col-md-6">
            <b class="ls-label-text">Nova senha</b>
            <input type="text" name="registry[password]" placeholder="Nova Senha" class="ls-field" 
            value="<?php echo $registry['password'] ?>" 
            required >
          </label>

          <label class="ls-label col-md-6">
            <b class="ls-label-text">Confirmar senha</b>
            <input type="text" name="registry[password_second]" placeholder="Confirmar" class="ls-field" 
            value="<?php echo $registry['password_second'] ?>" 
            required >
          </label>

        </fieldset>
        
        <div class="ls-actions-btn ls-txt-right">
          <button class="ls-btn ls-btn-primary" name="form[op]" value="update">Alterar</button>
          <button class="ls-btn-danger" onclick="window.close();" >Fechar</button>
        </div>
      </form>
    </div>

  </div>
</main>