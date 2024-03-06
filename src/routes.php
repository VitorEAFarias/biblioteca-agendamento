<?php
// Routes
//Normalmente aqui ficaria todas as rodas mas para motivos de facilidade eu criei um interador que 
//vai no dir. routes e já adiciona todas as rotas e suas respectivas logicas.

$dir = new FilesystemIterator(__DIR__.'/routes/api');
foreach ($dir as $file) {
	include(__DIR__.'/routes/api/'.$file->getFilename());
}


$dir = new FilesystemIterator(__DIR__.'/routes');
foreach ($dir as $file) {
	include(__DIR__.'/routes/'.$file->getFilename());
}
