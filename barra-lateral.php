<?php
    session_start();
    include_once('conexao.php');

    // Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php'); // Redireciona para a página de login se não estiver logado
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Consulta os dados apenas do usuário logado
    $sql = "SELECT * FROM carrinho WHERE usuario_id = ? ORDER BY id DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();


?>





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu lateral</title>
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
            width: 98.3%;
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
        @media screen and (max-width: 400px) {
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
        }

    </style>
</head>
<body>
   

        <header>
        <!--criei uma class para usar no css e não ter conflito com outros links-->
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu</a>

    </header>
   
    <nav id="menu">
        <a href="#" onclick="facharMenu()">&times; Fechar</a>
        <a href="listauser.php">Voltar</a>
        <a href="sair.php">Sair</a>
        <a href="#">Contato</a>
        <a href="#">Mais opções</a>
    </nav>

    <main id="conteudo">
       
        <div class="m-5">
            <label for="filtroNome">Filtrar por nome:</label>
            <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">

            <label for="filtroData"><b>Data de Serviço</b></label>
            <input type="date" id="filtroData" onchange="filtrarPorData()">
            <br><br>
            <table id="clientesTabela" class="box">
                <thead>
                    <tr class="table">
                        <th scope="col">id</th>
                        <th scope="col">user_id</th>
                        <th scope="col">usuario_id</th>
                        <th scope="col">servico_id</th>
                        <th scope="col">nome</th>
                        <th scope="col">cnpj</th>
                        <th scope="col">telefone</th>
                        <th scope="col">servico</th>
                        <th scope="col">data_serv</th>
                        <th scope="col">cidade</th>
                        <th scope="col">estado</th>
                        <th scope="col">endereco</th>
                        <th scope="col">valor</th>
                        <th scope="col">data_insercao</th>
                        <!--<th>Editar</th>-->
                    </tr>
                </thead>
                <tbody class="box">
                    <?php
                    while ($user_data = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$user_data['id']."</td>";
                        echo "<td>".$user_data['user_id']."</td>";
                        echo "<td>".$user_data['usuario_id']."</td>";
                        echo "<td>".$user_data['servico_id']."</td>";
                        echo "<td>".$user_data['nome']."</td>";
                        echo "<td>".$user_data['cnpj']."</td>";
                        echo "<td>".$user_data['telefone']."</td>";
                        echo "<td>".$user_data['servico']."</td>";
                        echo "<td>".$user_data['data_serv']."</td>";
                        echo "<td>".$user_data['cidade']."</td>";
                        echo "<td>".$user_data['estado']."</td>";
                        echo "<td>".$user_data['endereco']."</td>";
                        echo "<td>".$user_data['valor']."</td>";
                        echo "<td>".$user_data['data_insercao']."</td>";
                        //echo "<td></td>";
                        echo "</tr>"; // Fechar a linha da tabela
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </main>
    
    <script>
        function abrirMenu() {
            document.getElementById('menu').style. height = '100%';
            document.getElementById('conteudo').style.marginLeft = '16%';
        }
        function facharMenu(){
            document.getElementById('menu').style. height = '0%'
            document.getElementById('conteudo').style.marginLeft = '0%';
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

        function filtrarPorData() {
            const input = document.getElementById('filtroData').value;
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[13]; // coluna "Data de Serviço"
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.indexOf(input) > -1) {
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