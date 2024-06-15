<?php
    include_once('conexao.php');

    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id']) && isset($data['estoque'])) {
        $id = $data['id'];
        $estoque = $data['estoque'];

        $sql = "UPDATE clientes SET estoque = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ii", $estoque, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        $stmt->close();
        $conexao->close();
    } else {
        echo json_encode(['success' => false]);
    }
?>
