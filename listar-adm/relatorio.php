<?php
session_start();
include_once('conexao.php');

// Consulta para obter a soma dos valores e quantidades de cada usuário
$sql = "SELECT c.usuario_id, u.nome, SUM(c.valor) AS total_valor, COUNT(*) AS total_quantidade 
        FROM carrinho c
        JOIN usuarios u ON c.usuario_id = u.id
        GROUP BY c.usuario_id";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:#313b73ff;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        table {
            width: 50%;
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
            width: 99%;
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
        .hidden {
            display: none;
            }

            #options a {
                display: block;
                margin: 5px 0;
            }
    </style>
   
</head>
<body>
    <header>
        <!--criei uma class para usar no css e não ter conflito com outros links-->
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu Adm</a>

    </header>
   
    <nav id="menu">
        <a href="#" onclick="facharMenu()">&times; Fechar</a>
        <a href="http://localhost/teste-usuario2/listar-adm/painel.html">Voltar</a>
        <a href="http://localhost/teste-usuario2/adm/index.php">Cadastrar User</a>
        <a href="#">Contato</a>
        <!--<a href="#">Mais opções</a>-->
        <a href="#" id="showOptions">Mais opções</a>
        <div id="options" class="hidden">
            <a href="http://localhost/teste-usuario2/index.php">Menu User</a>
            <a href="Sair.php">Sair</a>
            <a href="#"></a>
            <a href="#"></a>
        </div>
    </nav>

    <main id="conteudo">

            <div class="center">
                

                <div>

                    <section>
                        <h1>Relatório de Vendas</h1>
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>Usuário ID</th>
                                    <th>Nome do Usuário</th>
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
                                    echo "<td>" . $row['total_valor'] . "</td>";
                                    echo "<td>" . $row['total_quantidade'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
        
                    </section>

            </div>

    </main>
    
    <script>

        document.getElementById('showOptions').addEventListener('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do link
            var options = document.getElementById('options');
            if (options.classList.contains('hidden')) {
                options.classList.remove('hidden');
            } else {
                options.classList.add('hidden');
            }
        });

        function abrirMenu() {
            document.getElementById('menu').style. height = '100%';
            document.getElementById('conteudo').style.marginLeft = '17%';
        }
        function facharMenu(){
            document.getElementById('menu').style. height = '0%'
            document.getElementById('conteudo').style.marginLeft = '0%';
        }
        
    </script>

</body>
</html>


