<?php
session_start();
include_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $tipo_despesa = $_POST['tipo_despesa'];

    $sql = "INSERT INTO despesas (descricao, valor, data, tipo_despesa_id) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sdsi", $descricao, $valor, $data, $tipo_despesa);

    if ($stmt->execute()) {
        echo "Despesa cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar despesa: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
}
?>