<?php 

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/event-manager', function () {

	$this->any('', function ($Request, $Response, $args) {
		$user = $this->session->get('auth');
		$post = $Request->getParsedBody();
		$results = [];

		$results = $this->mysql->fetchAll('SELECT * FROM event_database ORDER BY id DESC LIMIT 30');
		
		foreach ($results as $index => $item) {
			$item['alert'] = 'ls-color-info';

			if ($item['log'] == 'Evento Executado') {
				$item['alert'] = 'ls-color-success';
			}

			if (strlen($item['log']) > 16) {
				$item['alert'] = 'ls-background-danger';	
			}
			
			$results[$index] = $item;
		}

		$phpView = $this->renderer;
		$phpView->addAttribute('title', 'Event Manager');
		$phpView->addAttribute('user', $user);
		$phpView->setLayout('default.php');

		$phpView = $this->renderer->render($Response, 'event-manager/main.php', [						
			'results'	=> $results,
			"messages" => $this->message->getMessages(),
			"user" => $this->session->get('auth'),
			"post"	=> $post
		]);
		return $phpView;
	});

})->add($middleware['auth']);