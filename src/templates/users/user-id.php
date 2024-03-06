<main class="ls-main ">
  <div class="container-fluid">

    <?php include($base_path . '/templates/alert-template.php') ?>

    <div class="row mt-4">

      <form action="<?php echo $action ?>" method="post" class="ls-form ls-form-horizontal mt-3">
        <div class="row form-content">
          <?php
          if ($operator == 'create') { ?>
            <h3 style="color: #0f4192; font-weight: bold">Cadastro de Usuários</h3>
          <?php  } else { ?>
            <h3 style="color: #0f4192; font-weight: bold">Edição de Usuário</h3>
          <?php   } ?>

          <?php if ($operator['type'] == 'edit') : ?>
            <label class="ls-label col-md-2">
              <b class="ls-label-text">Código</b>
              <input type="text" name="registry[id]" placeholder="Código" class="ls-field" disabled value="<?php echo $registry['id'] ?>" <?php echo ($operator['type'] == 'edit' ? 'disabled' : '') ?> required>
            </label>
          <?php endif ?>


          <label class="ls-label col-md-4">
            <b class="ls-label-text">Nome</b>
            <input type="text" name="registry[nome]" placeholder="Nome" class="ls-field" value="<?php echo $registry['nome'] ?>" required>
          </label>

          <label class="ls-label col-md-4">
            <b class="ls-label-text">E-mail</b>
            <input type="text" name="registry[email]" placeholder="E-mail" class="ls-field" value="<?php echo $registry['email'] ?>" required>
          </label>

          <label class="ls-label col-md-4 col-sm-4">
            <b class="ls-label-text">Função</b>
            <div class="ls-custom-select">
              <select class="ls-custom" name="registry[role]">
                <option selected="selected" value="%">Escolher opção</option>

                <?php foreach ($post['form']['selects']['users_roles'] as $item) : ?>
                  <?php $selected = ($registry['role']['id'] == $item['id'] ? 'selected' : '') ?>
                  <option <?php echo $selected ?> value="<?php echo $item['id'] ?>">
                    <?php echo $item['role'] ?>
                  </option>

                <?php endforeach ?>

              </select>
            </div>
          </label>

          <label class="ls-label col-md-4">
            <b class="ls-label-text">E-mail para notificações</b>
            <input type="text" name="registry[emailGroup]" placeholder="Email para notificações" class="ls-field" value="<?php echo $registry['emailGroup'] ?>" required>
          </label>

          <label class="ls-label col-md-4">
            <b class="ls-label-text">Usuario AD</b>
            <input type="text" name="registry[ad_user]" placeholder="Usuario AD" class="ls-field" value="<?php echo $registry['ad_user'] ?>" required>
          </label>

          <div class="ls-label col-md-2 col-sm-2">
            <p><b class="ls-label-text">Pode logar</b></p>
            <label class="ls-label-text">
              <input type="radio" name="registry[logar]" value="1" <?php echo ($registry['logar'] == '1' ? 'checked' : '') ?>> Sim
            </label>
            <label class="ls-label-text">
              <input type="radio" name="registry[logar]" value="0" <?php echo ($registry['logar'] == '0' ? 'checked' : '') ?>> Não
            </label>
          </div>

          <div class="ls-label col-md-2 col-sm-2">
            <p><b class="ls-label-text">Recebe email</b></p>
            <label class="ls-label-text">
              <input type="radio" name="registry[recebeEmail]" value="1" <?php echo ($registry['recebeEmail'] == '1' ? 'checked' : '') ?>> Sim
            </label>
            <label class="ls-label-text">
              <input type="radio" name="registry[recebeEmail]" value="0" <?php echo ($registry['recebeEmail'] == '0' ? 'checked' : '') ?>> Não
            </label>
          </div>

          <input type="hidden" name="registry[password]" placeholder="Usuario AD" class="ls-field" value="uN*6K@RKiLy$">

          <div class="d-flex align-items-center justify-content-end">
            <a href="/users"><button class="btn btn-voltar" type="button">Voltar</button></a>

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