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
                    <th>Quantidade</th>
                    <th>Forma de Pagamento</th>
                    <th>Valor Unitário</th>
                    <th>Valor (R$)</th>
                </tr>
            </thead>
            <tbody id="listaServicos"></tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="4">Total</td>
                    <td id="totalValue"></td>
                </tr>
            </tfoot>
        </table>
        <button onclick="window.print()">Imprimir</button>
    </div>

    <script>
      // Obtém os dados do carrinho do localStorage, ou inicializa com um array vazio
const carrinho = JSON.parse(localStorage.getItem('carrinhoFinalizado')) || [];
const listaServicos = document.getElementById('listaServicos');
const totalValue = document.getElementById('totalValue');

let total = 0;

// Agrupar serviços por nome, tipo de serviço e forma de pagamento
const servicosAgrupados = carrinho.reduce((acc, servico) => {
    const key = `${servico.nome}-${servico.servico}-${servico.forma_pagamento}`;
    if (!acc[key]) {
        acc[key] = { ...servico, quantidade: 0, valorTotal: 0 };
    }
    acc[key].quantidade += 1;
    acc[key].valorTotal += parseFloat(servico.valor); // Adiciona o valor do serviço ao valor total
    return acc;
}, {});

// Adicionar os serviços agrupados na tabela e calcular o total geral
Object.values(servicosAgrupados).forEach(servico => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>${servico.nome}</td>
        <td>${servico.servico}</td>
        <td>${servico.quantidade}</td>
        <td>${servico.forma_pagamento}</td>
        <td>${parseFloat(servico.valor).toFixed(2)}</td> <!-- Mostra o valor unitário do serviço -->
        <td>${servico.valorTotal.toFixed(2)}</td> <!-- Mostra o valor total do serviço -->
    `;
    listaServicos.appendChild(tr);

    total += servico.valorTotal; // Adiciona o valor total do serviço ao total geral
});

// Exibir o valor total geral
totalValue.textContent = total.toFixed(2);

// Limpar o localStorage após carregar os dados
localStorage.removeItem('carrinhoFinalizado');
    </script>
</body>
</html>
