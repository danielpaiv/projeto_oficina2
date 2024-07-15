<?php
    session_start();
    include_once('conexao.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    $user_id = $_POST['user_id'];
    $data_consulta = isset($_POST['data_consulta']) ? $_POST['data_consulta'] : date('Y-m-d');

    // Consulta para obter os totais de serviços por data específica
    $sql = "SELECT usuario_id, 
                servico,
                SUM(valor) AS total_valor,
                COUNT(*) AS total_quantidade 
            FROM carrinho 
            WHERE usuario_id = ? AND DATE(data_insercao) = ?
            GROUP BY usuario_id, servico";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("is", $user_id, $data_consulta);
    $stmt->execute();
    $result = $stmt->get_result();

    // Consulta para obter o total geral de valores e quantidades
    $sql_total = "SELECT SUM(valor) AS total_geral_valor, SUM(total_quantidade) AS total_geral_quantidade 
    FROM (
        SELECT SUM(valor) AS valor, COUNT(*) AS total_quantidade 
        FROM carrinho 
        WHERE usuario_id = ? AND DATE(data_insercao) = ?
        GROUP BY usuario_id, servico
    ) AS subquery";

$stmt_total = $conexao->prepare($sql_total);
$stmt_total->bind_param("is", $user_id, $data_consulta);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total = $result_total->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
    <style>
        /* Seu CSS existente */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #313b73ff;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .print-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
        }

        .print-button:hover {
            background-color: #45a049;
        }
        a{
            text-decoration:none;

        }
        .btn-abrir{
            color: white;
            font-size: 20px;
            border:solid 1px;
            padding: 3px;;
            text-decoration: none;
            top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <a href="relatorio_vendas_por_servico.php"class="btn-abrir">Voltar</a>
    </header>

    
    
    <h1>Relatório de Vendas</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Usuário ID</th>
                <th>Serviço</th>
                <th>Total Valor</th>
                <th>Total Quantidade</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['usuario_id'] . "</td>";
                echo "<td>" . $row['servico'] . "</td>";
                echo "<td>" . $row['total_valor'] . "</td>";
                echo "<td>" . $row['total_quantidade'] . "</td>";
                echo "</tr>";
            }
            // Exibir total geral
            echo "<tr>";
            echo "<td colspan='2'><strong>Total Geral</strong></td>";
            echo "<td><strong>" . $total['total_geral_valor'] . "</strong></td>";
            echo "<td><strong>" . $total['total_geral_quantidade'] . "</strong></td>";
            echo "</tr>";
            ?>
        </tbody>
    </table>
    <a href="javascript:window.print()" class="print-button">Imprimir Relatório</a>
</body>
</html>
