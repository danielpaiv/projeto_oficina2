<?php
header('Content-Type: application/json');

// Definindo informações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banco_dados";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Conexão falhou: ' . $conn->connect_error]);
    exit;
}

// Capturar os dados do carrinho enviados pelo cliente
$input = file_get_contents('php://input');
$carrinho = json_decode($input, true);

// Verificar se $carrinho é um array válido
if (!is_array($carrinho)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados inválidos recebidos.']);
    exit;
}

$usuario_id = 1; // Supondo que você tem o ID do usuário armazenado na sessão ou em outra variável

// Preparar a declaração SQL para inserir os itens do carrinho
$stmt = $conn->prepare("INSERT INTO carrinho (usuario_id, servico_id, nome, cnpj, telefone, servico, data_serv, cidade, estado, endereco, valor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Falha na preparação da declaração SQL: ' . $conn->error]);
    exit;
}

$stmt->bind_param("iissssssssd", $usuario_id, $servico_id, $nome, $cnpj, $telefone, $servico, $data_serv, $cidade, $estado, $endereco, $valor);

foreach ($carrinho as $item) {
    $servico_id = $item['id'];
    $nome = $item['nome'];
    $cnpj = $item['cnpj'];
    $telefone = $item['telefone'];
    $servico = $item['serviço'];
    $data_serv = $item['data_serv'];
    $cidade = $item['cidade'];
    $estado = $item['estado'];
    $endereco = $item['endereco'];
    $valor = $item['valor'];
    
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Falha na execução da declaração SQL: ' . $stmt->error]);
        exit;
    }
}

$stmt->close();
$conn->close();

echo json_encode(['status' => 'sucesso', 'mensagem' => 'Compra finalizada com sucesso!']);
?>