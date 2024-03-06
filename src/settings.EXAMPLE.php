<?php
//Aqui fica todas as configurações em formato de array, esses objs. serão adicionados como parametros dentro das dependecies.php
//Por exemplo dbh=>vai enviar url como parametro que vai fazer a conexão
//logger e renderer são duas dependencias basicas um faz um log dentor do dir logs e a outras busca as views redenrizadas dentro do 
// dir templates.
return [

    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../src/templates/',
            'base_path' => __DIR__
        ],

        // Renderer settings
        'mail_template' => [
            'path' => __DIR__ . '/../src/templates/email/',
        ],

        //JWT config
        'jwt' => [
            'secret_key' => '',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            // 'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            // 'level' => \Monolog\Logger::DEBUG,
        ],

        //Doctrine/Mysql
        'mysql' => [
            'dbname' => '',
            'user' => '',
            'password' => '',
            'host' => '',
            //'driver' => 'pdo_mysql',
            'driver' => 'pdo_sqlsrv',
            'charset' => 'UTF8'
        ],

        /*
		'mysql' => [
            'url' => '',
        ],*/

        //Phpmailer
        'mailer' => [
            'host'      => '',
            'username'  => '',
            'password'  => '',
        ],
    ],
];
