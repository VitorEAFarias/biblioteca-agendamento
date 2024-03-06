<?php  
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/v1/censo', function () {

	$this->post('/asbl', function ($Request, $Response, $args) {

		$post = $Request->getParsedBody();

		$address['asbl'] = $post['asbl'];

		if (empty($address['asbl'])) {
			return $Response->withJson([]);
		}

		$results = $this->mysql->fetchAll(
			'SELECT asbl, street_1, was_visited, letter FROM censo_db 
			WHERE asbl LIKE :asbl
			ORDER BY asbl ASC', 
			[
				':asbl' => $address['asbl'].'%'
			]
		);

		return $Response->withJson($results);

	});

});