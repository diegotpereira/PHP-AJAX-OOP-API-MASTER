<?php 
// mostrar relatório de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Url página Home
$home_url = "localhost/api/";

// página fornecida no parâmetro de URL, a página padrão é uma
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// definir o número de registros por página
$registros_por_pagina = 5;

// calcular a cláusula LIMIT da consulta
$numero_do_registro = ($registros_por_pagina * $page) - $registros_por_pagina;

?>

