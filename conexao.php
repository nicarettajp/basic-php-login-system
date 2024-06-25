<?php

$host = 'localhost';
$usuario = 'root';
$senha = '';
$database = 'test';

$mysqli = new mysqli($host, $usuario, $senha, $database);

if ($mysqli->connect_errno) {
    die('Falha ao conectar ao banco de dados: ' . $mysqli->connect_error);
}

// Definir o charset para utf8
$mysqli->set_charset('utf8');