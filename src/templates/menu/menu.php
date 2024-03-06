<style>
  .ls-user-account .ls-ico-user:after {
    color: black;
  }

  .ls-user-menu ul li a {
    color: black !important;
  }

  .ls-user-menu ul li a:hover {
    color: white !important;
  }

  .ls-ico-menu:before {
    color: gray !important;
  }

  .ls-user-account .ls-user-menu ul {
    margin-bottom: 0 !important;
  }

  @media only screen and (max-width: 768px) {
    .ls-topbar {
      background-color: #F5F5F9 !important;
    }

    #menu-divisor {
      width: 100% !important;
      margin-left: 0 !important;
    }
  }
</style>

<div class="ls-topbar" style="background-color: white;">

  <!-- Barra de Notificações -->
  <div class="ls-notification-topbar">

    <!-- Dropdown com detalhes da conta de usuário -->
    <div data-ls-module="dropdown" class="ls-dropdown ls-user-account" style="background-color: white; padding-right: 45px">
      <a href="#" class="ls-ico-user">
        <span class="ls-name" style="color: black"><?php echo ucfirst($user['name']) ?></span>
      </a>

      <nav class="ls-dropdown-nav ls-user-menu" style="background-color: #F5F5F9; ">
        <ul>
          <li><a href="/login/logoff">Sair</a></li>
        </ul>
      </nav>
    </div>
  </div>

  <span class="ls-show-sidebar ls-ico-menu"></span>

  <!-- <div class="ls-brand-name" style="background-color: #F5F5F9; width: 265px; text-align: center;">
    <a href="/dashboard"><img src="/assets/img/logo_agendamento.png" width="150px"></a>
  </div> -->

  <!-- Nome do produto/marca sem sidebar quando for o pre-painel  -->
  <!-- <hr style="border-top: 2px solid #c1c1c1; margin-top: 0px; width: calc(100% - 340px); margin-left: 300px" id="menu-divisor"> -->
  <hr style="border-top: 2px solid #c1c1c1; margin-top: 0px; width: calc(100% - 75px); margin-left: 75px" id="menu-divisor">
</div>