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

// consultar produtos
$stmt = $produto->ler();
$num = $stmt->rowCount();

// verifique se mais de 0 registro encontrado
if ($num>0) {
    # code...
    // array de produtos
    $produtos_arr = array();
    $produtos_arr["registros"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        # code...
        // extrair linha
        // fetch() é mais rápido que fatchAll()
        extract($row);

        $produto_item = array(
            "id" => $id,
            "nome" => $nome,
            "descricao" => html_entity_decode($descricao),
            "preco" => $preco,
            "categoria_id" => $categoria_id,
            "categoria_nome" => $categoria_nome,
        );

        array_push($produtos_arr["registros"], $produto_item);
    }

    // define código resposta  - 200 OK
    http_response_code(200);

    echo json_encode($produtos_arr);
} else {
    # code...
     // definir o código de resposta
     http_response_code(404);

     //diga ao usuário que nenhum produto foi encontrado
     echo json_encode(
         array("message" => "Produto não encontrado!.")
     );
}


?>