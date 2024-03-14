<?php


$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer(
        $settings['template_path'],
        ['base_path' => $settings['base_path']]
    );
};

// mail renderer
$container['mail_template'] = function ($c) {
    $settings = $c->get('settings')['mail_template'];
    class MailTemplate
    {
        public $baseTemplate;

        public function __construct($baseTemplate)
        {
            $this->baseTemplate = $baseTemplate;
        }

        public function getTemplateByName($templateName, $param)
        {
            ob_start();
            include($this->baseTemplate . $templateName);
            $html = utf8_decode(ob_get_clean());
            return $html;
        }
    }

    return new MailTemplate($settings['path']);
};

// monolog
$container['logger'] = function ($c) {
    // $settings = $c->get('settings')['logger'];
    // $logger = new Monolog\Logger($settings['name']);
    // $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    // $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    // return $logger;
};
/*
$container['errorHandler'] = function ($c) {
    return function ($Request, $Response, $exception) use ($c) {
        return $Response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('
                <div style="text-align: center"><h3>Houve um erro de acesso ao banco de dados.</h3><a href="/">Reiniciar aplicativo</a></div>
            ');
    };
};

*/
//doctrine/dbal
$container['mysql'] = function ($c) {
    $settings = $c->get('settings')['mysql'];
    $mysql = \Doctrine\DBAL\DriverManager::getConnection($settings, new \Doctrine\DBAL\Configuration());
    return $mysql;
};

$container['mysqlRH'] = function ($c) {
    $settings = $c->get('settings')['mysqlRH'];
    $mysqlRH = \Doctrine\DBAL\DriverManager::getConnection($settings, new \Doctrine\DBAL\Configuration());
    return $mysqlRH;
};

//PHP Mailer



$container['mailer'] = function ($c) {
    $settings = $c->get('settings')['mailer'];

    $mail = new \PHPMailer\PHPMailer\PHPMailer();
    $mail->SMTPDebug = 0;
    $mail->Host       = 'smtp-relay.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'alerta.sistemas1@butantan.gov.br';
    $mail->Password   = 'info*1962';
    $mail->isSMTP();
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->CharSet = 'ISO-8859-1';
    $mail->Encoding = 'base64';
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ]
    ];
    $mail->setFrom($settings['username'], 'Agendamentos');
    $mail->isHTML(true);

    return $mail;
};



$container['jwt'] = function ($c) {
    $settings = $c->get('settings')['jwt'];
    $jwt['secret'] = $settings['secret_key'];
    return $jwt;
};

//Flash Message
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};


$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};

$container['convert'] = function ($c) {
    class Convert
    {
        function date($date)
        {
            $ary = explode('/', $date);
            return $ary[2] . '-' . $ary[1] . '-' . $ary[0];
        }
        function money($money)
        {
            return 'R$' . number_format($money, 2, ',', '.');
        }

        function id($id)
        {
            return (int) abs($id);
        }

        function checkIfExist($value, $replace = '%')
        {
            return (isset($value) ? $value : $replace);
        }

        function checkIsNullOrEmpty($value, $replace)
        {
            return (is_null($value) || empty($value) ? $replace : $value);
        }
    }

    return new Convert();
};
