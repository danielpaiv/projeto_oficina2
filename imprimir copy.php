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
                    <td colspan="5">Total</td>
                    <td id="totalValue"></td>
                </tr>
            </tfoot>
        </table>
        <button onclick="window.print()">Imprimir</button>
    </div>

    <script>
        // Obtém todos os dados de carrinho do localStorage
        const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
        const listaServicos = document.getElementById('listaServicos');
        const totalValue = document.getElementById('totalValue');

        let total = 0;
        const servicosAgrupados = {};

        // Função para processar os carrinhos
        function processarCarrinhos() {
            // Percorre todas as chaves no localStorage
            for (let i = 0; i < localStorage.length; i++) {
                const chave = localStorage.key(i);

                // Verifica se a chave corresponde a um carrinho finalizado
                if (chave.startsWith('carrinhoFinalizado_')) {
                    const carrinho = JSON.parse(localStorage.getItem(chave)) || [];
                    
                    // Agrupa os serviços
                    carrinho.forEach(servico => {
                        const key = `${servico.nome}-${servico.servico}-${servico.forma_pagamento}`;
                        if (!servicosAgrupados[key]) {
                            servicosAgrupados[key] = { ...servico, quantidade: 0, valorTotal: 0 };
                        }
                        servicosAgrupados[key].quantidade += 1;
                        servicosAgrupados[key].valorTotal += parseFloat(servico.valor);
                    });

                    // Limpa o localStorage para essa chave
                    localStorage.removeItem(chave);
                }
            }

            // Adicionar os serviços agrupados na tabela e calcular o total geral
            Object.values(servicosAgrupados).forEach(servico => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${servico.nome}</td>
                    <td>${servico.servico}</td>
                    <td>${servico.quantidade}</td>
                    <td>${servico.forma_pagamento}</td>
                    <td>${parseFloat(servico.valor).toFixed(2)}</td>
                    <td>${servico.valorTotal.toFixed(2)}</td>
                `;
                listaServicos.appendChild(tr);

                total += servico.valorTotal;
            });

            // Exibir o valor total geral
            totalValue.textContent = total.toFixed(2);
        }

        processarCarrinhos();
    </script>
</body>
</html>
