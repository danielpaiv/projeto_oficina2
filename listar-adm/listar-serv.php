
<?php
    session_start();
//esse codigo é responsável por criptografar a pagina viinculado ao codigo teste login.
include_once('config.php');
//print_r($_SESSION);
if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
$logado = $_SESSION['nome'];

$sql = "SELECT * FROM usuarios ORDER BY id DESC";

//$result = $conexao->query($sql);

//print_r($result);


    include_once('conexao.php');
    //print_r($_SESSION);
   

    $sql = "SELECT * FROM clientes ORDER BY id DESC";

    $result = $conexao->query($sql);

    //print_r($result);

        
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Serviços</title>

    <!--<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
    <script src="filtroNome.js"></script>
    <script src="filtroData.js"></script>!-->
    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            background-color: #137897; 
            /*text-align: center;*/
            
        }
        .table{
            background: rgba(0, 0, 0, 0.9);
        
            border-radius: 18px 18px 0 0;
            color: white;
            padding: 15px;
            font-size: 18px;
            text-align: center;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif 

        }
        tbody{
            color: black;
            font-size: 18px;
            background-color: yellow;
            text-align: center;
        }
            
        nav {
        margin-bottom: 20px;
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
        }

        #clientesTabela {
            width: 99%;
            border-collapse: collapse;
            left:30px;
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
        }
        #carrinho h2 {
            margin-top: blue;
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
            input{
                 background-color: white;
            }
        }
       
        
    </style>

</head>

<body>
    <nav>
    <button><a href="sair.php">Sair</a></button>
    <button><a href="painel.php">Voltar</a></button>
    <button><a href="http://localhost/projeto_oficina/adm/formulario_copy.php">Novo serviço</a></button>
    </nav>



<div class="m-5">

        <label for="filtroNome">Filtrar por Serviços:</label>
        <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">

        <label for="filtroData"><b>Data de Serviço</b></label>
        <input type="date" id="filtroData" onchange="filtrarPorData()">
        <br>
        <br>
        <button onclick="imprimirSelecionados()">Imprimir Selecionados</button>
            <br><br>

            

        <table id="clientesTabela" class="box">
            <thead>
                <tr class="table">
                <th scope="col"><input type="checkbox" id="selecionarTodos" onclick="selecionarTodos(this)"></th>
                <th scope="col">id</th>
                    <!--<th scope="col">nome</th>
                    <th scope="col">cnpj</th>
                    <th scope="col">telefone</th>-->
                    <th scope="col">serviço</th>
                    <th scope="col">data_serv</th>
                    <!--<th scope="col">cidade</th>
                    <th scope="col">estado</th>
                    <th scope="col">endereco</th>-->
                    <th scope="col">valor</th>
                    <th scope="col">estoque</th>
                    <th scope="col">Editar</th>
                </tr>
            </thead>
            <tbody class="box">
                <?php
                    while($user_data = mysqli_fetch_assoc($result))
                    {
                        echo "<tr>";
                        echo "<td><input type='checkbox' class='linhaSelecionada' data-json='".json_encode($user_data)."'></td>";
                        echo "<td>".$user_data['id']."</td>";
                        //echo "<td>".$user_data['nome']."</td>";
                        //echo "<td>".$user_data['cnpj']."</td>";
                        //echo "<td>".$user_data['telefone']."</td>";
                        echo "<td>".$user_data['servico']."</td>";
                        echo "<td>".$user_data['data_serv']."</td>";
                        //echo "<td>".$user_data['cidade']."</td>";
                        //echo "<td>".$user_data['estado']."</td>";
                        //echo "<td>".$user_data['endereco']."</td>";
                        echo "<td>".$user_data['valor']."</td>";
                        echo "<td>".$user_data['estoque']."</td>";
                        
                        echo "<td>
                        
                        <a class= 'btn btn-primary' href='edit copy.php?id=$user_data[id]'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                        </svg>
                        </a>
                        
                        </td>";
                        echo "</td>";
                    }
                ?>


            </tbody>
        </table>
    </div>   
    <script>

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
            printWindow.document.write('body { font-family: Arial, Helvetica, sans-serif; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h1>Venda Selecionada</h1>');
            printWindow.document.write('<table>');
            printWindow.document.write('<thead><tr>');
            //printWindow.document.write('<th>id</th>');
            //printWindow.document.write('<th>user_id</th>');
            //printWindow.document.write('<th>usuario_id</th>');
            printWindow.document.write('<th>servico_id</th>');
            //printWindow.document.write('<th>espaco_mesa</th>');
            //printWindow.document.write('<th>servico</th>');
            //printWindow.document.write('<th>forma_pagamento</th>');
            printWindow.document.write('<th>valor</th>');
            printWindow.document.write('<th>estoque</th>');
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
                //printWindow.document.write('<td>' + data.espaco_mesa + '</td>');
                printWindow.document.write('<td>' + data.servico + '</td>');
                //printWindow.document.write('<td>' + data.forma_pagamento + '</td>');
                printWindow.document.write('<td>' + data.valor + '</td>');
                printWindow.document.write('<td>' + data.estoque + '</td>');
                //printWindow.document.write('<td>' + data.data_insercao + '</td>');
                printWindow.document.write('</tr>');
            });

            printWindow.document.write('</tbody></table>');
            printWindow.document.write('<h2>Total: ' + somaValores.toFixed(2) + '</h2>');  // Exibe a soma dos valores
            printWindow.document.write('<h2>: ' +  + '</h2>');  // Exibe a soma dos valores
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }

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

        function filtrarPorData() {
            const input = document.getElementById('filtroData').value;
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[2]; // coluna "Data de Serviço"
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

        console.log('Filtro Nome:', filter);
        console.log('Texto da Coluna:', txtValue);

    </script>
</body>
</html>