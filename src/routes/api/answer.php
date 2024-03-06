<?php  
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/v1/answer', function () {

	$this->post('', function ($Request, $Response, $args) {
		$post = $Request->getParsedBody();

		if ($post['auth'] != $this->jwt['secret']) {
			return $Response->withJson([], 401);			
		}

		$answer['id'] = $post['id'];

		if (empty($answer['id'])) {
			return $Response->withJson([], 200);
		}

		$result = $this->mysql->fetchAssoc(
			'SELECT * FROM answer WHERE id = :id', 
			[
				':id' => $answer['id']
			]
		);

		return $Response->withJson($result, 200);

	});

});