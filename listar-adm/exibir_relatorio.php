<?php
    session_start();
    include_once('conexao.php');
    
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    
    $data_consulta = isset($_POST['data_consulta']) ? $_POST['data_consulta'] : date('Y-m-d');
    
    // Consulta para obter os totais de serviços por data específica
    $sql = "SELECT c.usuario_id, u.nome, c.servico, 
                SUM(c.valor) AS total_valor, 
                COUNT(*) AS total_quantidade 
            FROM carrinho c
            JOIN usuarios u ON c.usuario_id = u.id
            WHERE DATE(c.data_insercao) = ?
            GROUP BY c.usuario_id, u.nome, c.servico";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $data_consulta);
    $stmt->execute();
    $result = $stmt->get_result();
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
        <a href="relatorio_vendas_por_servico copy.php"class="btn-abrir">Voltar</a>
    </header>

    <h1>Relatório de Vendas</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Usuário ID</th>
                <th>Nome</th>
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
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . $row['servico'] . "</td>";
                echo "<td>" . $row['total_valor'] . "</td>";
                echo "<td>" . $row['total_quantidade'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="javascript:window.print()" class="print-button">Imprimir Relatório</a>
</body>
</html>
