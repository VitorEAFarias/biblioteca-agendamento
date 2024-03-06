<!DOCTYPE html>
<html>
<head>
	<title>OS Vencem Hoje</title>
	<style type="text/css">
	table{width: 100%; min-width: 600px;}
	table tr th{text-align: left;}
	#topbar{background-color: #000;  color: #FFF; padding: 6px 0px;}
	#main{width: 600px !important; margin: 0px auto; overflow: hidden;}
	#banner{margin:0;padding: 6px 0px; width:100% !important;}
	#banner img{margin: 0 auto; text-align: center;}
	#footer{background-color: #000;  color: #FFF; margin-top: 6px; padding-top: 4px;}
	#inner{width: 600px !important; margin: 0px auto;}
	.text-center{text-align: center;}
	.text-right{text-align: right;}
	.left{float: left;}
	.row{padding: 6px 0px; margin-bottom: 9px;}
	.col1, .col2, .col3, .col4, .col5, .col6{float: left;}
	.col1{width: 100px;}
	.col2{width: 200px;}
	.col3{width: 300px;}
	.col4{width: 400px;}
	.col5{width: 500px;}
	.col6{width: 600px;}
	</style>
</head>
<body>

	<div id="topbar">
		<div id="inner">
			<div class="row">
				<div class="col3">sariweb.com.br</div>
				<div class="col3">Bot Watternes</div>
			</div>
		</div>
	</div>
	
	<div id="main">
		<div class="row text-center">
			<h3>Ordens de Serviço - <?php echo date('d/m/Y') ?></h3>
			<h5>Que vencem hoje e ainda não foram atendidas.</h5>
		</div>
		<div class="row">
			<table border="1">
				<tr>
					<th>Num. OS</th>
					<th>Produto</th>
					<th>Num. Pedido</th>
					<th>Qtd.Soli.</th>
					<th>Qtd.Fabricada</th>
					<th>Data</th>
					<th>Entrega</th>
				</tr>
				<?php foreach ($param['orders'] as $key => $order): ?>
				<tr>
					<td><?php echo round($order['numord']) ?></td>
					<td><?php echo round($order['codprod']) ?></td>
					<td><?php echo round($order['numped']) ?></td>
					<td><?php echo round($order['qtdsoli']) ?></td>
					<td><?php echo round($order['qtdfabr']) ?></td>
					<td><?php echo date('d/m/Y', strtotime($order['datord'])) ?></td>
					<td><?php echo date('d/m/Y', strtotime($order['dtentr'])) ?></td>
				</tr>					
				<?php endforeach ?>
			</table>
		</div>
	</div>

	<div id="footer">
		<div id="inner">
		<div class="row">
			<div class="col3 text-center">www.sariweb.com.br</div>
			<div class="col3 text-center">Dúvidas: suporte@sariweb.com.br</div>
		</div>
		<div class="row text-center">
			<p>Copyright © <?php echo date("Y") ?>SARIWEB, All rights reserved.</p>
		</div>
	</div>

</body>
</html>