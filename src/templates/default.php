<?php
$url = $_SERVER['REQUEST_URI'];
$page = basename(parse_url($url, PHP_URL_PATH));
?>

<!DOCTYPE html>
<html class="ls-theme-gray">

<head>
  <title><?= $title ?> - Biblioteca</title>
  <meta charset="utf-8">
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

  <!-- Incluí os estilos CSS -->
  <link rel="stylesheet" href="/assets/css/bootstrap.css">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <!-- Locaweb -->
  <link href="https://cdn.fundacaobutantan.org.br/locaweb/3.10.0/stylesheets/locastyle.css" rel="stylesheet" type="text/css">
  <script src="https://cdn.fundacaobutantan.org.br/locaweb/3.10.0/javascripts/locastyle.js" type="text/javascript"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

  <link rel="icon" sizes="192x192" href="assets/img/ico-boilerplate.png">
  <link rel="apple-touch-icon" href="assets/img/ico-boilerplate.png">

  <!-- Incluí os scripts JS -->
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>

</head>

<style>
  .ls-main {
    height: auto !important;
    margin-bottom: 30px !important;
  }

  ol,
  ul {
    padding-left: 0rem !important;
  }
</style>

<body>

  <?php require(__DIR__ . '/menu/menu.php') ?>
  <?php require(__DIR__ . '/menu/sidebar.php') ?>
  <?= $content ?>

  <!-- <script src="https://cdn.fundacaobutantan.org.br/locaweb/3.10.0/javascripts/locastyle.js" type="text/javascript"></script> -->

</body>

<footer style="background-color: white; z-index: 101; position: relative; display: flex; align-items: center; justify-content: center; flex-direction: column; box-shadow: -1px -1px 1px rgba(0,0,0,0.3)" class="py-4">
  <div style="display: flex; align-items: center; justify-content: center;">
    <img src="/assets/img/logo-footer-biblioteca.png" alt="Logo Biblioteca" width="65px" style="margin-right: 20px;">
    <img src="/assets/img/logo-ib.png" alt="Logo Instituto Butantan" width="110px" style="margin-right: 20px;">
    <img src="/assets/img/logo_fb.png" alt="Logo Fundação Butantan" width="150px">
  </div>
  <div style="margin-top: 10px;">
    <span>Criado por Tic Desenvolvimento. Todos os direitos reservados ao © Instituto Butantan 2023</span>
  </div>
</footer>

<?php if (isset($_GET['msg'])) {  ?>
  <style>
    .ls-modal {
      background: rgba(0, 0, 0, 0.5);
      align-items: center;
      justify-content: center;
      z-index: 9999;
      height: 100vh;
    }

    .ls-modal-box {
      box-shadow: none !important;
    }
  </style>

  <div class="ls-modal ls-opened" id="myAwesomeModal">
    <div style="display: flex; align-items: center; justify-content: center; height: 80%;">
      <div class="ls-modal-box">
        <div class="ls-modal-header" style="border-radius: 25px;">
          <button data-dismiss="modal" id="btn-fechar" style="font-size: 30px; background-color: #E5E5E5; border-radius: 50%; padding: 1px 8px">&times;</button>
          <div class="text-center my-4">
            <i class="far fa-check-circle" style="font-size: 40px; color: #2ebb17"></i>
            <h4 class="mt-3 fw-bold"><?= $_GET['msg'] ?></h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.onclick = function() {
      document.querySelector("#myAwesomeModal").classList.remove("ls-opened");
    };
  </script>
<?php } ?>

</html>