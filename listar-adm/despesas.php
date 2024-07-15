<?php
include_once('conexao.php');

// Consulta para obter os tipos de despesas
$sql = "SELECT id, tipo FROM tipos_despesas";
$result = $conexao->query($sql);
$tipos_despesas = [];
while ($row = $result->fetch_assoc()) {
    $tipos_despesas[] = $row;
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Despesa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }
        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Cadastro de Despesa</h2>

<form method="post" action="processar_despesa.php">
    <label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" required>

    <label for="valor">Valor:</label>
    <input type="number" step="0.01" id="valor" name="valor" required>

    <label for="data">Data:</label>
    <input type="date" id="data" name="data" required>

    <label for="tipo_despesa">Tipo de Despesa:</label>
    <select id="tipo_despesa" name="tipo_despesa" required>
        <option value="">Selecione</option>
        <?php
        foreach ($tipos_despesas as $tipo) {
            echo "<option value='{$tipo['id']}'>{$tipo['tipo']}</option>";
        }
        ?>
    </select>

    <button type="submit">Cadastrar</button>
</form>

</body>
</html>
