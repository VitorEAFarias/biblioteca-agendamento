<?php

require('../src/conn.php');

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/login', function () {

	$this->post('/auth', function ($request, $response, $args) {
		$post = $request->getParsedBody();

		if (empty($post['email']) or empty($post['password'])) {
			$this->flash->addMessage('ls-alert-danger', 'E-mail e senha são obrigatórias');
			return $response->withStatus(302)->withHeader('Location', '/');
		}

		if (!empty($post['simula'])) {
			$simula = $post['simula'];
			$postUser = $post['simula'];
		} else {
			$simula = '';
			$postUser = $post['email'];
		}

		try {
			$ch =  curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://controleacesso.butantan.gov.br/ServicoAcesso.asmx/AutenticarGeral");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt(
				$ch,
				CURLOPT_POSTFIELDS,
				http_build_query([
					'Login' => $post['email'],
					'Senha' => $post['password'],
					'SistemaId' => '289',
					'Navegador' => '',
					'IP' => '',
					'UrlRequisicao' => '',
					'UsuarioSimular' => $simula,
				])
			);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			$error_curl = curl_error($ch);
			$error_no = curl_errno($ch);
			$curl_info = curl_getinfo($ch);

			curl_close($ch);

			// if ($error_curl or $error_no) {
			// 	echo json_encode(
			// 		array(
			// 			"message" => "Não foi possivel fazer a requisição.",
			// 			"error" => $error_curl,
			// 			"error_no" => $error_no,
			// 			"info" => $curl_info
			// 		)
			// 	);
			// 	exit;
			// }
			$oXML = new SimpleXMLElement($server_output);

			$json  = json_encode($oXML);
			$configData = json_decode($json, true);

			if ($oXML->ErroMsg[0] == 'Acesso realizado') {

				try {
					$PDO = new PDO("sqlsrv:Server=" . SERVER_HOST . ";database=" . SERVER_DBNAME, SERVER_USERNAME, SERVER_PASSWORD);
					$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					// $stmt = $PDO->query("EXEC [dbo].[USP_VALIDA_EVENTO]");
					// $stmt->execute();
					echo "Connected successfully <br>";
				} catch (PDOException $e) {
					echo "Connection failed: " . $e->getMessage();
				}

				$registry = "SELECT * FROM users WHERE ad_user = '" . $postUser . "' 
					and status='1' and JSON_VALUE(role,'$.id') NOT IN ('2','3')";
				$result = $PDO->query($registry);

				$rows = $result->fetchAll(PDO::FETCH_ASSOC);
				//var_dump($rows);
				//exit;
				$compar = count($rows);

				switch ($compar) {
					case 1:
						foreach ($rows as $value) {

							$_SESSION["token"] = md5($post['email'] . $post['password']);
							setcookie("user", $_SESSION["token"]);

							$authToken = md5(json_encode(
								[
									'name' 	=> $value['nome'],
									'email' 	=> $value['email'],
									'password' 	=> $value['password']
								]
							) . $this->jwt['secret']);

							$base64Token = [
								'name' 	=> 	$value['nome'],
								'authToken' => $authToken
							];

							$token = base64_encode(json_encode($base64Token));

							$this->session->set('auth', [
								'token' => $token,
								'name' => $value['nome'],
								'id' => $value['id'],
								'user_adm' => '1',
								'role' => json_decode($value['role'], true),
							]);
						}

						return $response->withStatus(302)->withHeader('Location', '/dashboard');

						break;

					default:

						$_SESSION["token"] = md5($post['email'] . $post['password']);
						setcookie("user", $_SESSION["token"]);

						$authToken = md5(json_encode(
							[
								'name' 	    => $postUser,
								'email' 	=> $post['email'],
								'password' 	=> $register['password']
							]
						) . $this->jwt['secret']);

						$base64Token = [
							'name' 	=> 	$postUser,
							'authToken' => $authToken
						];

						$token = base64_encode(json_encode($base64Token));


						$this->session->set('auth', [
							'token' => $token,
							'name' => $postUser,
							'id' => $postUser,
							'password' => $post['password'],
							'user_adm' => '0'
						]);

						$user = $this->session->get('auth');


						return $response->withStatus(302)->withHeader('Location', '/dashboard');
						break;
				}
			} else
				return $response->withStatus(302)->withHeader('Location', '/?msg=Acesso restrito a funcionários do Instituto Butantan!');
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
			exit;
		}





		if (!$register) {
			$this->flash->addMessage('ls-alert-danger', 'E-mail e senha são obrigatórias');
			return $response->withStatus(302)->withHeader('Location', '/');
		}
	});

	// $this->get('/teste', function ($request, $response, $args) {
	// 	define('SERVER_HOST', '');
	// 	define('SERVER_DBNAME', '');
	// 	define('SERVER_USERNAME', '');
	// 	define('SERVER_PASSWORD', '');

	// 	try {
	// 		$PDO = new PDO("sqlsrv:Server=" . SERVER_HOST . ";database=" . SERVER_DBNAME, SERVER_USERNAME, SERVER_PASSWORD);

	// 		$stmt = $PDO->query("EXEC [dbo].[USP_VALIDA_EVENTO]");
	// 		$stmt->execute();
	// 		// $PDO->query("DECLARE	@return_value int
	// 		// EXEC @return_value = [dbo].[USP_VALIDA_EVENTO]");
	// 		// $stmt = $PDO->prepare("EXEC USP_VALIDA_EVENTO");
	// 		// $stmt->execute();
	// 	} catch (Exception $e) {
	// 		echo $e->getMessage();
	// 		exit;
	// 	}
	// });

	$this->get('/logoff', function ($request, $response, $args) {
		$this->session->delete('auth');
		$this->flash->addMessage('ls-alert-success', '<b>Sessão Finalizada</b>');
		return $response->withStatus(302)->withHeader('Location', '/');
	});
})->add($middleware['syncToSession']);
