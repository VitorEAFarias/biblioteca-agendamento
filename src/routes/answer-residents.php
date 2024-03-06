<?php  
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/v1/answer-residents', function () {

	$this->post('', function ($Request, $Response, $args) {
		$post = $Request->getParsedBody();

		if ($post['auth'] != $this->jwt['secret']) {
			return $Response->withJson([], 401);			
		}

		$answer['id'] = $post['answer_id'];

		if (empty($answer['id'])) {
			return $Response->withJson([], 200);
		}

		$results = $this->mysql->fetchAll(
			'SELECT name, gender, birthday, covid, document, code 
			FROM aswer_residents WHERE answer_id = :id', 
			[
				':id' => $answer['id']
			]
		);

		foreach ($results as $index => $item) {
			$results[$index]['birthday'] = date('d/m/Y', strtotime($item['birthday']));
		}

		return $Response->withJson($results, 200);

	});

});