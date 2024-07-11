<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Nota</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nota de Serviços</h2>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Forma de Pagamento</th>
                    <th>Valor (R$)</th>
                </tr>
            </thead>
            <tbody id="listaServicos"></tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="3">Total</td>
                    <td id="totalValue"></td>
                </tr>
            </tfoot>
        </table>
        <button onclick="window.print()">Imprimir</button>
    </div>

    <script>
        const carrinho = JSON.parse(localStorage.getItem('carrinhoFinalizado')) || [];
        const listaServicos = document.getElementById('listaServicos');
        const totalValue = document.getElementById('totalValue');

        let total = 0;

        carrinho.forEach(servico => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${servico.nome}</td>
                <td>${servico.servico}</td>
                <td>${servico.forma_pagamento}</td>
                <td>${servico.valor}</td>
            `;
            listaServicos.appendChild(tr);

            total += parseFloat(servico.valor);
        });

        totalValue.textContent = total.toFixed(2);

        // Limpar o localStorage após carregar os dados
        localStorage.removeItem('carrinhoFinalizado');
    </script>
</body>
</html>
