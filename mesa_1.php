<?php
session_start();
include_once('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit;
}

$nome = $_SESSION['nome'];
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Vendas</title>
    <style>
        /* Seu CSS aqui */
        
           /* Seu CSS aqui */
        
           body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0px;
            background-color: #137897;

        }
        a{
            text-decoration: none;
        }
        header{
             background-color: rgb(21, 4, 98);
            padding: 1px;
            display: flex;
            justify-content: space-between;
            width: 0px;
            margin-left: 0px;
            margin-top: 1px;;
            
        }
        .btn-abrir{
            color: white;
            font-size: 30px;
        }
        nav{
            height: 0%;
            width: 250px;
            background-color: rgb(21, 4, 98  ) ;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            overflow: hidden;
            transition: width 0.3s;
        }
        nav a{
            color: white;
            font-size: 25px;
            display: block;
            padding: 12px 10px 12px 32px;
        }
        nav a:hover{
            color: rgb(21, 4, 98  );
            background-color: white;
        }
        main{
            padding: 10px;
            transition: margin-left 0.5s;
        }
        table,th,td{
            border: 1px solid black;
            border-collapse:collapse ;
        }
        th,td{
            padding: 5px 10px;
        }
        th{
            background-color: rgb(21, 4, 98);
            color: white;
        }
        /*odd aplicado em todos elementos inpares*/
        table tr:nth-child(odd){
            background-color: #ddd;

        }
        /*odd aplicado em todos elementos pares*/
        table tr:nth-child(even){
            background-color:white ;

        }
        div{
            display: inline-block;
            background-color: #060642 ;
            padding: 5px;
            text-align: center;
            width: 98.9%;
        }
        legend{
            color: white;
        }
        h3{
            color: blue;
        }
        p{
            color: white;
        }

        .table{
            background: rgba(0, 0, 0, 0.9);
        
            border-radius: 18px 18px 0 0;
            color: white;
            padding: 15px;
            font-size: 14px;
            text-align: center;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif 

        }
        tbody{
            color: black;
            font-size: 14px;
            background-color: yellow;
            text-align: center;
        }
            
        nav {
        margin-bottom: 30px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            cursor: pointer;
        }

        button a {
            color: white;
            text-decoration: none;
        }

        button:hover {
            background-color: #45a049;
        }

        #m-5 {
            margin: 20px;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
            color:white;
            padding: ;
        }

        #clientesTabela {
            width: 100%;
            border-collapse: collapse;
            left:50px;
        }

        #clientesTabela th, #clientesTabela td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #clientesTabela th {
            background-color: #000000;
            text-align: left;
        }
        h2{
            color:#f9f9f9;
        }

        #carrinho {
            border: 1px solid #ddd;
            padding: 10px;
            background-color: blue;
            width: 30%;
            top: 120px;
        }
        #carrinho h2 {
            margin-top: 150px;
        }

        #listaCarrinho {
            list-style-type: none;
            padding: 0;
        }

        #listaCarrinho li {
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }

        #listaCarrinho li:last-child {
            border-bottom: none;
        }
        li{
            border: 1px solid #ddd;
            padding: 10px;
            background-color: yellow;
            text-align: left;
            margin: 20px;
            width: 90%;
            border-collapse: collapse;
        }
        /*@media screen and (max-width: 400px) {
            body {
                font-size: 8px;
            }

            .table {
                font-size: 5px;
                padding: 10px;
                width: 56%;
            }

            #clientesTabela th, #clientesTabela td {
                padding: 4px;
                font-size: 6px;
                width: 90%;
            }

            button {
                padding: 5px 10px;
                font-size: 12px;
            }

            #carrinho {
                width: 96%;
                padding: 5px;
            }

            #listaCarrinho li {
                padding: 3px 0;
            }
            .box{
                width: 56%;
                top: 50;
                
            }
            }
            .hidden {
            display: none;
            }

            #options a {
                display: block;
                margin: 5px 0;
            }*/
        .fixed-info {
            position: ;
            top: 0;
            left: 0%;
            width: 52%;
            background-color: black;
            padding: 0px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .fixed{
            position: fixed;
            width: 99%;
            top: 0;
        }
        .m-5{
            position: ;
            width: 98%
        }

        @media (max-width: 800px) {
            table {
                width: 100%;
                font-size: 16px;
            }

            th, td {
                font-size: 16px;
            }

            header {
                columns:3;
                flex-direction: column;
                align-items: flex-start;
                margin-left: 3px;
                
            }

            .btn-abrir, .btn-b {
                font-size: 18px;
            }

            nav {
                width: 200px;
            }

            nav a {
                font-size: 20px;
            }
            div{
                margin-top: 100px;
                margin-left: 5px;
            }
            .btn-abrir{
                color: white;
                font-size: 30px;
            }
            #carrinho {
            border: 1px solid #ddd;
            padding: 10px;
            background-color: blue;
            width: 95%;
        }
        }

        @media (max-width: 400px) {
            table {
                width: 100%;
                font-size: 6px;
            }

            th, td {
                font-size: 6px;
            }
            header {
                flex-direction: column;
                align-items: flex-start;
                margin-left: 0px;
                
            }

            .btn-abrir, .btn-b {
                font-size: 16px;
            }

            nav {
                width: 150px;
            }

            nav a {
                font-size: 18px;
            }
            div{
                margin-top: 20px;
                margin-left: -10px;
            }
            #carrinho {
                width: 95%;
                padding: 5px;
                margin-left: 2px;
                margin-top: 80px;
            }

            #listaCarrinho li {
                padding: 3px 0;
            }
            .fixed{
            position: fixed;
            width: 99%;
            top: 0;
             display: flex;
            justify-content: space-between;
            
            }
            #filtroNome{
                color:white;
            }
            .m-5{
                width: 115%;
            }
            
            .btn-abrir{
                color: white;
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <header class="fixed">
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu</a>
        <p>Nome: <?php echo $nome; ?></p><p>ID: <?php echo $user_id; ?></p>
        <h2>Mesa 1</h2>
    </header>
    
    <nav id="menu">
        <a href="#" onclick="facharMenu()">&times; Fechar</a>
        <a href="vendas.php">Minhas vendas</a>
        <a href="#" id="showOptions">Mais opções</a>
        <div id="options" class="hidden">
            <a href="meuRelatorio.php">Relatorio por administradora</a>
            <a href="relatorio_vendas_por_servico.php">Relatório por itens</a>
            <a href="painel.php">Painel</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>
    <br>
    <main id="conteudo">
        <div id="carrinho" class="carrinho">
            <h2>Carrinho de Serviços</h2>
            <ul id="listaCarrinho"></ul>
            <button onclick="finalizarCompra()">Finalizar Compra</button>
        </div>
        <br>
        <br>
        <div class="m-5">
            <label for="filtroNome">Filtrar por nome:</label>
            <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">
            <br>
            <br>
            <table id="clientesTabela" class="box">
                <thead>
                    <tr class="table">
                        <th scope="col">id</th>
                        <th scope="col">servico</th>
                        <th scope="col">Data cadastro</th>
                        <th scope="col">valor</th>
                        <th scope="col">estoque</th>
                        <th scope="col">Adicionar ao Carrinho</th>
                        <th>Inserir Dados</th>
                    </tr>
                </thead>
                <tbody class="box">
                    <?php
                    $sql = "SELECT * FROM clientes ORDER BY id DESC";
                    $result = $conexao->query($sql);
                    while ($user_data = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $user_data['id'] . "</td>";
                        //echo "<td>".$user_data['user_id']."</td>";
                        //echo "<td>" . $user_data['nome'] . "</td>";
                        //echo "<td>" . $user_data['cnpj'] . "</td>";
                        //echo "<td>" . $user_data['telefone'] . "</td>";
                        echo "<td>" . $user_data['servico'] . "</td>";
                        echo "<td>" . $user_data['data_serv'] . "</td>";
                        //echo "<td>" . $user_data['cidade'] . "</td>";
                        //echo "<td>" . $user_data['estado'] . "</td>";
                        //echo "<td>" . $user_data['endereco'] . "</td>";
                        //echo "<td>" . $user_data['forma_pagamento'] . "</td>";
                        echo "<td>" . $user_data['valor'] . "</td>";
                        echo "<td>" . $user_data['estoque'] . "</td>";
                        echo "<td><button onclick='adicionarAoCarrinho(" . json_encode($user_data) . ")'>Adicionar</button></td>";
                        echo "<td>
                        
                        <a class= 'btn btn-primary' href='edit.php?id=$user_data[id]'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                        </svg>
                        </a>
                        
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        document.getElementById('showOptions').addEventListener('click', function(event) {
            event.preventDefault();
            var options = document.getElementById('options');
            if (options.classList.contains('hidden')) {
                options.classList.remove('hidden');
            } else {
                options.classList.add('hidden');
            }
        });

        function abrirMenu() {
            document.getElementById('menu').style.height = '100%';
            document.getElementById('conteudo').style.marginLeft = '16%';
        }

        function fecharMenu() {
            document.getElementById('menu').style.height = '0%';
            document.getElementById('conteudo').style.marginLeft = '0%';
        }

        const userId = <?php echo json_encode($user_id); ?>;
        let carrinho = JSON.parse(localStorage.getItem('carrinho_mesa_1_' + userId)) || [];

        function adicionarAoCarrinho(servico) {
            if (servico.estoque > 0) {
                carrinho.push(servico);
                atualizarCarrinho();

                fetch('atualizar_estoque.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: servico.id, estoque: servico.estoque - 1 }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        servico.estoque -= 1;
                        localStorage.setItem('carrinho_mesa_1_' + userId, JSON.stringify(carrinho));
                        setTimeout(() => {
                            alert("Serviço adicionado ao carrinho! Certifique-se de perguntar ao cliente se vai querer dados na nota.");
                            window.location.reload();
                        }, 100);
                    } else {
                        alert("Erro ao atualizar o estoque.");
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            } else {
                alert("Estoque esgotado!");
            }
        }

        function carregarCarrinho() {
            const carrinhoLocal = localStorage.getItem('carrinho_mesa_1_' + userId);
            if (carrinhoLocal) {
                carrinho = JSON.parse(carrinhoLocal);
                atualizarCarrinho();
            }
        }

        window.onload = carregarCarrinho;

        function atualizarCarrinho() {
            const listaCarrinho = document.getElementById('listaCarrinho');
            listaCarrinho.innerHTML = '';

            carrinho.forEach(servico => {
                const li = document.createElement('li');
                li.textContent = `${servico.servico} - ${servico.valor}`;
                listaCarrinho.appendChild(li);
            });

            localStorage.setItem('carrinho_mesa_1_' + userId, JSON.stringify(carrinho));
        }

        function finalizarCompra() {
            if (carrinho.length === 0) {
                alert("Seu carrinho está vazio. Adicione itens antes de finalizar a compra.");
                return;
            }

            console.log('Dados a serem enviados:', JSON.stringify(carrinho)); // Verificar dados enviados
            fetch('processar_carrinho.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(carrinho),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                alert("Compra finalizada com sucesso!");

                localStorage.setItem('carrinhoFinalizado_mesa_1_' + userId, JSON.stringify(carrinho));

                carrinho = []; // Limpar o carrinho
                localStorage.removeItem('carrinho_mesa_1_' + userId); // Limpar o localStorage
                atualizarCarrinho();
                window.location.href = "imprimir copy.php"; // Redirecionar para a página de vendas
            })
            .catch((error) => {
                console.error('Erro ao enviar dados:', error);
                alert("Erro ao finalizar a compra. Por favor, tente novamente.");
            });
        }

        function cancelarVenda() {
            if (confirm("Você tem certeza que deseja cancelar a venda?")) {
                carrinho.forEach(servico => {
                    fetch('atualizar_estoque.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: servico.id, estoque: servico.estoque + 1 }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            servico.estoque += 1;
                        } else {
                            alert("Erro ao restaurar o estoque do serviço com ID: " + servico.id);
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                });

                carrinho = [];
                localStorage.removeItem('carrinho_mesa_1_' + userId);
                alert("Venda cancelada!");
                window.location.reload();
            }
        }

        function exibirBotoesVenda() {
            const botoesContainer = document.getElementById('botoesVenda');
            botoesContainer.innerHTML = '<button onclick="cancelarVenda()">Cancelar Venda</button>';
        }

        function confirmarVenda() {
            alert("Venda confirmada!");
            carrinho = [];
            localStorage.removeItem('carrinho_mesa_1_' + userId);
            window.location.reload();
        }

        exibirBotoesVenda();

        function filtrarPorNome() {
            const input = document.getElementById('filtroNome');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[1]; // coluna "Nome"
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>
</html>
