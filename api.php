<?php
//configuração
header("Content-Type: application/json;charset=utf-8");
//DEFINE A RESPOSTA DA API, NESTE CASO JSON


header ("Access-Control-Allow-Origin: *");
//DEFINE O ACESSO A API, NESSE * QUER DIZER TODAS AS ORIGEM


header ("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
//DEFINE OS MÉTODOS QUE PODEM SER FEITOS NESSA API


require "config.php";


$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];


//variável para capturar as informações das requisições
$corpo = json_decode(file_get_contents("php://input"), true) ?? [];


function teste(){
    echo json_encode (["mensagem" => "Back-end respondendo com sucesso!"]);
    exit;
}




//funções: onde fica o crud
function createUsuarios($con, $dados){
    $stmt = $con->prepare("INSERT INTO USUARIOS (NOME, USERNAME, EMAIL, SENHA) VALUES (?,?,?,?)");
    $stmt -> execute([$dados["nome"], $dados["username"], $dados["email"], $dados["senha"]]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Usuário criado com sucesso!", "id" => $con->lastInsertId()]);
}


function readUsuarios($con){
    $stmt = $con->query("SELECT * FROM Usuarios");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function updateUsuarios($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Usuarios SET nome = ?, username = ?, email = ?, senha = ? WHERE idUsuario = ?");
    $stmt -> execute([$dados["nome"], $dados["username"], $dados["email"], $dados["senha"], $id]);
    echo json_encode(["mensagem" => "Usuário alterado com sucesso!"]);
}


function deleteUsuarios ($con, $id){
    $stmt = $con->prepare("DELETE FROM Usuarios WHERE idUsuarios = ?");
    $stmt ->execute([$id]);
    echo json_encode(["mensagem" => "Usuário removido com sucesso!"]);
}


function createPublicacoes($con, $dados){
    $stmt = $con->prepare("INSERT INTO Publicacoes ID_USUARIO, LEGENDA, IMAGEM_URL) VALUES (?,?,?)");
    $stmt -> execute([$dados["id_usuario"], $dados["legenda"], $dados["imagem_url"]]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Publicação criada com sucesso!", "id" => $con->lastInsertId()]);
}


function readPublicacoes($con){
    $stmt = $con->query("SELECT * FROM Publicacoes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function updatePublicacoes($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Publicacoes SET id_usuario = ?, legenda = ?, imagem_url = ? WHERE idPublicacao = ?");
    $stmt -> execute([$dados["nome"], $dados["cargo"], $dados["salario"], $id]);
    echo json_encode(["mensagem" => "Publicação alterada com sucesso!"]);
}


function deletePublicacoes ($con, $id){
    $stmt = $con->prepare("DELETE FROM Publicacoes WHERE idPublicacao = ?");
    $stmt ->execute([$id]);
    echo json_encode(["mensagem" => "Publicação removida com sucesso!"]);
}


function createCurtidas($con, $dados){
    $stmt = $con->prepare("INSERT INTO Curtidas (id_usuario, id_publicacao) VALUES (?, ?)");
    $stmt -> execute([$dados["id_usuario"], $dados["id_publicacao"]]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Curtida criada com sucesso!", "id" => $con->lastInsertId()]);
}


function readCurtidas($con){
    $stmt = $con->query("SELECT * FROM Curtidas");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function updateCurtidas($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Curtidas SET id_usuario = ?, id_publicacao = ? WHERE idCurtida = ?");
    $stmt -> execute([$dados["origem"], $dados["destino"], $dados["distancia"], $id]);
    echo json_encode(["mensagem" => "Curtida alterada com sucesso!"]);
}


function deleteCurtidas ($con, $id){
    $stmt = $con->prepare("DELETE FROM Curtidas WHERE idCurtida = ?");
    $stmt ->execute([$id]);
    echo json_encode(["mensagem" => "Curtida removida com sucesso!"]);
}






// rotas nomeadas
 if ($rota === "usuarios"){
    switch($metodo){
        case "POST":
            createUsuarios($con, $corpo);
            break;
        case "GET":
            readUsuarios($con);
            break;
        case "PUT":
            updateUsuarios($con, $_GET["id"], $corpo);
            break;
        case "DELETE":
            deleteUsuarios($con, $_GET["id"]);
            break;


        default:
        teste();
    }
 }


 else if ($rota=== "publicacoes"){
    switch($metodo){
        case "POST":
            createPublicacoes($con, $corpo);
            break;


        case "GET":
            readPublicacoes($con);
            break;


        case "PUT":
            updatePublicacoes($con, $_GET["id"], $corpo);
            break;


        case "DELETE":
            deletePublicacoes($con, $_GET["id"]);
            break;


        default:
        teste();
    }


 }


else if ($rota=== "curtidas"){
    switch($metodo){
        case "POST":
            createCurtidas($con, $corpo);
            break;


        case "GET":
            readCurtidas($con);
            break;


        case "PUT":
            updateCurtidas($con, $_GET["id"], $corpo);
            break;


        case "DELETE":
            deleteCurtidas($con, $_GET["id"]);
            break;


        default:
        teste();
    }
 }
