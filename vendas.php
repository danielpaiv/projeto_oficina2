<?php
    session_start();
    include_once('conexao.php');

    date_default_timezone_set('America/Sao_Paulo');
    //date_default_timezone_set('America/Sao_Paulo');
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php'); // Redireciona para a página de login se não estiver logado
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $data_consulta = isset($_GET['data_consulta']) ? $_GET['data_consulta'] :  date('Y-m-d');
    //$data_atual = date('Y-m-d');

    // Consulta os dados apenas do usuário logado
    $sql = "SELECT * FROM carrinho WHERE usuario_id = ? AND DATE(data_insercao) = ? ORDER BY id DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("is", $user_id, $data_consulta);
    $stmt->execute();
    $result = $stmt->get_result();

    //var_dump($result->fetch_assoc());

    //print_r($_SESSION);
    if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['nome']);
        unset($_SESSION['senha']);
        header('Location: index.php');
    }
    $logado = $_SESSION['nome'];
?>





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas vendas</title>
     <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0px;

        }
        a{
            text-decoration: none;
        }
        header{
            background-color: rgb(21, 4, 98  );
            padding: 10px;
        }
        .btn-abrir{
            color: white;
            font-size: 20px;
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
            width: 99.3%;
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
        label{
            color:white;
        }
        #clientesTabela {
            width: 100%;
            border-collapse: collapse;
            left:50px;
        }
        /*@media screen and (max-width: 400px) {
            body {
                font-size: 8px;
            }

            .table {
                font-size: 5px;
                padding: 10px;
            }
            #clientesTabela th, #clientesTabela td {
                padding: 4px;
                font-size: 5px;
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
        }*/
        .hidden {
            display: none;
            }

            #options a {
                display: block;
                margin: 5px 0;
            }
            tbody{
            color: black;
            font-size: 14px;
            background-color: yellow;
            text-align: center;
        }

        @media (max-width: 768px) {
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
                margin-left: 5px;
                
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
        }

        @media (max-width: 400px) {
            table {
                width: 0%;
                font-size: 10px;
            }

            th, td {
                font-size: 10px;
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
                margin-left: 0px;
            }
            input{
                color:white;
            }
        }

    </style>
</head>
<body>
   

        <header>
        <!--criei uma class para usar no css e não ter conflito com outros links-->
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu</a>

    </header>
   
    <nav id="menu">
        <a href="#" onclick="fecharMenu()">&times; Fechar</a>
        <a href="painel.php">Painel</a>
        <a href="sair.php">Sair</a>
        <!--<a href=""></a>
        <a href="#">Mais opções</a>-->

        <a href="#" id="showOptions">Mais opções</a>
            <div id="options" class="hidden">
                <a href="http://localhost/teste-usuario2/listar-adm/index.php">Adm</a>
                
                <a href="meuRelatorio.php">Relatorio por administradora</a>
                
                <a href="relatorio_vendas_por_servico.php">Relatório por itens</a>
                <!--<a href="#">Opção 4</a>-->
            </div>
    </nav>

    <main id="conteudo">
        <div class="m-5">
            <form method="get" action="">
                <label for="data_consulta">Selecionar Data:</label>
                <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $data_consulta; ?>">
                <button type="submit">Consultar</button>
            </form>
            <br>
            <!--<label for="filtroNome">Filtrar por serviços:</label>
            <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">
            <br><br>-->
            <button onclick="imprimirSelecionados()">Imprimir Selecionados</button>
            <br><br>

            <button onclick="filtrarPorDataMaisRecente()">Ultima Venda</button>
            <br><br>
            <table id="clientesTabela" class="box">
                <thead>
                    <tr class="table">
                        <th scope="col"><input type="checkbox" id="selecionarTodos" onclick="selecionarTodos(this)"></th>
                        <th scope="col">id</th>
                       <!-- <th scope="col">user_id</th>
                        <th scope="col">usuario_id</th>-->
                        <th scope="col">servico_id</th>
                        <!--<th scope="col">nome</th>-->
                        <th scope="col">espaco_mesa</th>
                        <!--<th scope="col">cnpj / Cpf</th>
                        <th scope="col">telefone</th>-->
                        <th scope="col">servico</th>
                        <!--<th scope="col">Data cadastro</th>
                        <th scope="col">cidade</th>
                        <th scope="col">estado</th>
                        <th scope="col">endereco</th>-->
                        <th scope="col">forma_pagamento</th>
                        <th scope="col">valor</th>
                        <th scope="col">data_insercao</th>
                        <!--<th>Editar</th>-->
                    </tr>
                </thead>
                <tbody class="box">
                    <?php
                    while ($user_data = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' class='linhaSelecionada' data-json='".json_encode($user_data)."'></td>";
                        echo "<td>".$user_data['id']."</td>";
                        //echo "<td>".$user_data['user_id']."</td>";
                        //echo "<td>".$user_data['usuario_id']."</td>";
                        echo "<td>".$user_data['servico_id']."</td>";
                        //echo "<td>".$user_data['nome']."</td>";
                        echo "<td>".$user_data['espaco_mesa']."</td>";
                        //echo "<td>".$user_data['cnpj']."</td>";
                        //echo "<td>".$user_data['telefone']."</td>";
                        echo "<td>".$user_data['servico']."</td>";
                        //echo "<td>".$user_data['data_serv']."</td>";
                        //echo "<td>".$user_data['cidade']."</td>";
                        //echo "<td>".$user_data['estado']."</td>";
                        //echo "<td>".$user_data['endereco']."</td>";
                        echo "<td>".$user_data['forma_pagamento']."</td>";
                        echo "<td>".$user_data['valor']."</td>";
                        echo "<td>".$user_data['data_insercao']."</td>";
                        echo "<td><button onclick='criarNotaFiscal(".json_encode($user_data).")'>Nota Fiscal</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    
    <script>

        function filtrarPorDataMaisRecente() {
            const tabela = document.getElementById('clientesTabela');
            const linhas = tabela.querySelectorAll('tbody tr');
            
            if (linhas.length === 0) {
                alert('Nenhuma linha encontrada para filtrar.');
                return;
            }

            let dataMaisRecente = new Date(Math.max.apply(null, Array.from(linhas).map(tr => {
                const dataInsercao = tr.querySelector('td:nth-child(8)').textContent;
                return new Date(dataInsercao);
            })));

            linhas.forEach(tr => {
                const dataInsercao = new Date(tr.querySelector('td:nth-child(8)').textContent);
                if (dataInsercao.getTime() === dataMaisRecente.getTime()) {
                    tr.style.display = ''; // Mostra a linha
                } else {
                    tr.style.display = 'none'; // Esconde a linha
                }
            });
        }


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
        function selecionarTodos(checkbox) {
            const checkboxes = document.querySelectorAll('.linhaSelecionada');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
        }

        function imprimirSelecionados() {
            const selecionados = document.querySelectorAll('.linhaSelecionada:checked');
            if (selecionados.length === 0) {
                alert('Nenhuma linha selecionada!');
                return;
            }

            let somaValores = 0;

            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Imprimir Selecionados</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('table { width: 50%; border-collapse: collapse; }');
            printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
            printWindow.document.write('th { background-color: #f2f2f2; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h1>Dados Selecionados</h1>');
            printWindow.document.write('<table>');
            printWindow.document.write('<thead><tr>');
            //printWindow.document.write('<th>id</th>');
            //printWindow.document.write('<th>user_id</th>');
            //printWindow.document.write('<th>usuario_id</th>');
            //printWindow.document.write('<th>servico_id</th>');
            printWindow.document.write('<th>espaco_mesa</th>');
            printWindow.document.write('<th>servico</th>');
            //printWindow.document.write('<th>forma_pagamento</th>');
            printWindow.document.write('<th>valor</th>');
            //printWindow.document.write('<th>data_insercao</th>');
            printWindow.document.write('</tr></thead><tbody>');

            selecionados.forEach(cb => {
                const data = JSON.parse(cb.getAttribute('data-json'));
                somaValores += parseFloat(data.valor);  // Soma os valores

                printWindow.document.write('<tr>');
                //printWindow.document.write('<td>' + data.id + '</td>');
                //printWindow.document.write('<td>' + data.user_id + '</td>');
                //printWindow.document.write('<td>' + data.usuario_id + '</td>');
                //printWindow.document.write('<td>' + data.servico_id + '</td>');
                printWindow.document.write('<td>' + data.espaco_mesa + '</td>');
                printWindow.document.write('<td>' + data.servico + '</td>');
                //printWindow.document.write('<td>' + data.forma_pagamento + '</td>');
                printWindow.document.write('<td>' + data.valor + '</td>');
                //printWindow.document.write('<td>' + data.data_insercao + '</td>');
                printWindow.document.write('</tr>');
            });

            printWindow.document.write('</tbody></table>');
            printWindow.document.write('<h2>Total: ' + somaValores.toFixed(2) + '</h2>');  // Exibe a soma dos valores
            printWindow.document.write('<h2>Total: ' +  + '</h2>');  // Exibe a soma dos valores
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }

        function criarNotaFiscal(user_data) {
            const form = document.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', 'notas.php');
            form.style.display = 'none';

            for (const key in user_data) {
                if (user_data.hasOwnProperty(key)) {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', key);
                    input.setAttribute('value', user_data[key]);
                    form.appendChild(input);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }

        function filtrarPorNome() {
            const input = document.getElementById('filtroNome');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[7]; // coluna "Nome"
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