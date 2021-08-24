<?php
// cabeçalhos obrigatórios
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header("HTTP/1.1 200 OK");
die();
}


include_once '../config/database.php';
include_once '../objetos/produto.php';

// a conexão do banco de dados estará aqui
$database = new Database();
$db = $database->getConnection();

// incializar o objeto
$produto = new Produto($db);

// obter dados postados
$data = json_decode(file_get_contents("php://input"));


if (
    !empty($data->nome) &&
    !empty($data->preco) &&
    !empty($data->descricao) &&
    !empty($data->categoria_id)
) {
    # code...
    //definir valores de propriedade do produto
    $produto->nome = $data->nome;
    $produto->preco = $data->preco;
    $produto->descricao = $data->descricao;
    $produto->categoria_id = $data->categoria_id;
    $produto->criado = date('Y-m-d H:i:s');

    // criar o produto
    if ($produto->criar()) {
        # code...
        // defina código de resposta 201
        http_response_code(201);

        // diga ao usuário
        echo json_encode(array("message" => "Produto criado com sucesso!."));

    // se não for possível criar o produto, diga ao usuário
    } else {
        # code...
        // efinir código de resposta - 503 serviço indisponível
        echo http_response_code(503);

        // diga ao usuário
        echo json_encode(array("message" => "Incapaz de criar o produto."));

    }
    // diga que os dados do usuário estão incompletos
} else {
    # code...
    // define o código da resposta - 400 bad request
    http_response_code(400);
  
    // diga ao usuário
    echo json_encode(array("message" => "Incapaz de criar o produto. Os dados estão incompletos."));
}
