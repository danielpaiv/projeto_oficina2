<?php
session_start();

if (isset($_POST['submit']) && !empty($_POST['nome']) && !empty($_POST['senha'])) {
    include_once('config.php');
    $nome = $_POST['nome']; 
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE nome = ? AND senha = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $nome, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        unset($_SESSION['nome']);
        unset($_SESSION['senha']);
        header('Location: index.php');
    } else {
        $user_data = $result->fetch_assoc();
        $_SESSION['user_id'] = $user_data['id']; // Armazena o user_id na sessão
        $_SESSION['nome'] = $user_data['nome'];
        $_SESSION['senha'] = $user_data['senha'];
        header('Location: formulario.php');
    }
} else {
    header('Location: index.php');
}
?>