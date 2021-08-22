'<?php

// cabeçalhos obrigatórios
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objetos/produto.php';
  
// a conexão do banco de dados estará aqui
$database = new Database();
$db = $database->getConnection();


// incializar o objeto
$produto = new Produto($db);


// ler os produtos estará aqui  

// consultar produtos
$stmt = $produto->ler();
$num = $stmt->rowCount();



// verifique se mais de 0 registro encontrado
if ($num>0) {
    # code...
    // array de produtos
    $categorias_arr = array();
    $categorias_arr["registros"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        # code...
        // extrair linha
        // fetch() é mais rápido que fatchAll()
        extract($row);

        $categoria_item = array(
            "id" => $id,
            "nome" => $nome,
            "descricao" => html_entity_decode($descricao)
        );

        array_push($categorias_arr["registros"], $categoria_item);
    }

    // define código resposta  - 200 OK
    http_response_code(200);

    echo json_encode($categorias_arr);
} else {
    # code...
     // definir o código de resposta
     http_response_code(404);

     //diga ao usuário que nenhum produto foi encontrado
     echo json_encode(
         array("message" => "Categoria não encontrado!.")
     );
}


?>