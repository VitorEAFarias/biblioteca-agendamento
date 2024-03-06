<style>
	.ls-sidebar {
		height: 100vh !important;
		z-index: 100;
		overflow-x: visible;
		top: 0 !important;
	}

	.ls-menu {
		margin-top: 30px;
	}

	.ls-menu ul {
		z-index: 9999;
	}

	.ls-menu ul {
		overflow-x: hidden;
		padding-left: 0 !important;
	}

	.ls-menu li {
		border-bottom: none;
	}

	.ls-menu .link-ativo {
		border-left: 5px solid #4463B0;
		background-color: #e6e4d7;
	}

	.ls-sidebar-toggled .ls-sidebar {
		width: 57px;
	}

	.ls-menu ul li a {
		font-size: 16px;
	}

	.ls-menu ul li a,
	.ls-menu ul li a:before {
		color: #0A0099 !important;
	}

	.menu-text {
		margin-left: 15px;
	}

	.ls-theme-gray .ls-submenu-parent.ls-active,
	html .ls-submenu-parent.ls-active {
		background-color: #e6e4d7;
	}

	.ls-theme-gray .ls-menu a:hover,
	html .ls-menu a:hover,
	.ls-theme-gray .ls-menu a:focus,
	html .ls-menu a:focus {
		background-color: #e6e4d7;
		border-left: 5px solid #4463B0;

	}

	.ls-sidebar .ls-menu .ls-sidebar-inner {
		overflow-x: visible;
	}

	.ls-sidebar .ls-sidebar-toggle:before {
		font-size: 11px;
		color: white;
	}

	.ls-sidebar .ls-sidebar-toggle {
		position: absolute;
		top: 46px !important;
		padding: 0;
		margin: 0 !important;
		width: 30px;
		height: 30px;
		background-color: #4463B0;
		top: 0px;
		right: -12px;
		border-radius: 50%;
		border: none !important;
		display: flex;
		text-align: center;
		align-items: center;
		justify-content: center;
		padding-top: 1px;
		padding-left: 1px;
		z-index: 300 !important;
		color: white !important;
	}

	.ls-sidebar .ls-sidebar-toggle:hover {
		background-color: #4463B0;
		color: white;
	}

	.ls-sidebar-toggled .ls-menu {
		overflow: hidden;
	}

	#img-menu {
		display: none;
	}

	#img-menu-fechado {
		display: none;
	}

	.ls-sidebar-toggled .ls-menu #menu-logos #img-menu-aberto {
		display: none;
	}

	.ls-sidebar-toggled .ls-menu #menu-logos #img-menu-fechado {
		margin: 0 !important;
		padding: 10px 10px !important;
		display: block;
	}

	@media only screen and (max-width: 768px) {

		.ls-sidebar .ls-sidebar-toggle {
			display: none;
		}
	}

	.ls-ico-shaft-left:before,
	.ls-ico-shaft-left:after {
		content: "\e60e";
	}

	/* width */
	::-webkit-scrollbar {
		width: 5px;
	}

	/* Track */
	::-webkit-scrollbar-track {
		background: #e6e4d7;
	}

	/* Handle */
	::-webkit-scrollbar-thumb {
		background: #D2D2D2;
		border-radius: 5px;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
		background: #D2D2D2;
		border-radius: 5px;
	}
</style>


<aside class="ls-sidebar" style="background-color: #e6e4d7; ">
	<div class="ls-sidebar-inner">
		<nav class="ls-menu">
			<div id="menu-logos">
				<a href="/dashboard" id="img-menu-aberto"><img src="/assets/img/logo-biblioteca.png" width="120px"></a>
				<a href="/dashboard" id="img-menu-fechado"><img src="/assets/img/logo-pequeno.png" width="45px"></a>
			</div>
			<ul>
				<li class="<?= strpos($_SERVER['REQUEST_URI'], 'dashboard') ? ' link-ativo' : '' ?>" aria-expanded="true" aria-hidden="false">
					<a href="/dashboard" class="ls-ico-home" title="Painel" role="menuitem"><span class="menu-text">Home</span></a>
				</li>

				<?php if ($user['user_adm'] == 1 and $user['role']['access'] == 0) : ?>

					<li class="<?= strpos($_SERVER['REQUEST_URI'], 'users') ? ' link-ativo' : '' ?>" aria-expanded="true" aria-hidden="false">
						<a href="/users" class="ls-ico-users" title="Desenvolvedor" role="menuitem"><span class="menu-text">Operadores</span></a>
					</li>

					<li class="<?= strpos($_SERVER['REQUEST_URI'], 'categorias') ? ' link-ativo' : '' ?>" aria-expanded="true" aria-hidden="false">
						<a href="/categorias" class="ls-ico-text" title="Desenvolvedor" role="menuitem"><span class="menu-text">Categorias</span></a>
					</li>

					<li class="<?= strpos($_SERVER['REQUEST_URI'], 'salas') ? ' link-ativo' : '' ?>" aria-expanded="true" aria-hidden="false">
						<a href="/salas" class="ls-ico-screen" role="menuitem"><i class="fa-sharp fa-regular fa-loveseat"></i><span class="menu-text">Salas e Auditório</span></a>
					</li>

					<li class="<?= strpos($_SERVER['REQUEST_URI'], 'field-search-form') ? ' link-ativo' : '' ?>" aria-expanded="true" aria-hidden="false">
						<a href="/field-search-form/all" class="ls-ico-docs" title="Painel" role="menuitem"><span class="menu-text">Relatórios</span></a>
					</li>

				<?php endif ?>

				<li class="<?= strpos($_SERVER['REQUEST_URI'], 'agendamentos') ? ' link-ativo' : '' ?>" aria-expanded="true" aria-hidden="false">
					<a href="/agendamentos" class="ls-ico-calendar" title="Painel" role="menuitem"><span class="menu-text">Agenda</span></a>
				</li>

				<li class="<?= strpos($_SERVER['REQUEST_URI'], 'contato') ? ' link-ativo' : '' ?>" aria-expanded="true" aria-hidden="false">
					<a href="/contato" class="ls-ico-envelope" title="Painel" role="menuitem"><span class="menu-text">Contato</span></a>
				</li>

			</ul>
		</nav>
	</div>
</aside>