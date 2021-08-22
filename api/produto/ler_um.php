<?php

// cabeçalhos obrigatórios
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objetos/produto.php';
  
// a conexão do banco de dados estará aqui
$database = new Database();
$db = $database->getConnection();


// incializar o objeto
$produto = new Produto($db);


// definir a propriedade ID do registro para ler
$produto->id = isset($_GET['id']) ? $_GET['id'] : die();

//leia os detalhes do produto a ser editado
$produto->lerUm();

if ($produto->nome != null) {
    # code...
    // array de produtos
    $produto_arr = array(
        "id" => $produto->id,
        "nome" => $produto->nome,
        "descricao" => $produto->descricao,
        "preco" => $produto->preco,
        "categoria_id" => $produto->categoria_id,
        "categoria_nome" => $produto->categoria_nome,
    );

    // define código resposta  - 200 OK
    http_response_code(200);

    echo json_encode($produto_arr);
} else {
    # code...
     // definir o código de resposta
     http_response_code(404);

     //diga ao usuário que nenhum produto foi encontrado
     echo json_encode(
         array("message" => "Produto não existe!.")
     );
}
