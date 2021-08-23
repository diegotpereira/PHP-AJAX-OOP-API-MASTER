'<?php

// cabeçalhos obrigatórios
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");

include_once '../config/database.php';
include_once '../objetos/categoria.php';
  
// a conexão do banco de dados estará aqui
$database = new Database();
$db = $database->getConnection();


// incializar o objeto
$categoria = new Categoria($db);

// consultar categorias
$stmt = $categoria->lerTodas();
$num = $stmt->rowCount();

// verifique se mais de 0 registro encontrado
if ($num>0) {
    # code...
    // array de categorias
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