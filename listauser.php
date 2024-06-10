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
$sql = "SELECT * FROM clientes WHERE user_id = ? ORDER BY id DESC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();







//print_r($_SESSION);
if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
//$logado = $_SESSION['nome'];

//$sql = "SELECT * FROM usuarios ORDER BY id DESC";

//$result = $conexao->query($sql);

//print_r($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Listar Serviços</title>

    
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
    </style>
</head>
<body>
    <nav>

        <button><a href="formulario.php">Voltar</a></button>
    
        <button><a href="sair.php">Sair</a></button>

    </nav>
    <br>
    <br>
    <div id="carrinho" class="m-5">
        <h2>Carrinho de Serviços</h2>
        <ul id="listaCarrinho"></ul>
        <button onclick="finalizarCompra()">Finalizar Compra</button>
    </div>
    <br>
    <br>

    <div class="m-5">
        
        <label for="filtroNome">Filtrar por nome:</label>
        <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">

        <label for="filtroData"><b>Data de Serviço</b></label>
        <input type="date" id="filtroData" onchange="filtrarPorData()">
        <br>
        <br>

        <table id="clientesTabela" class="box">
            <thead>
                <tr class="table">
                    <th scope="col">id</th>
                    <!--<th scope="col">user_id</th>>!-->
                    <th scope="col">nome</th>
                    <th scope="col">cnpj</th>
                    <th scope="col">telefone</th>
                    <th scope="col">serviço</th>
                    <th scope="col">data_serv</th>
                    <th scope="col">cidade</th>
                    <th scope="col">estado</th>
                    <th scope="col">endereco</th>
                    <th scope="col">valor</th>
                    <th scope="col">Adicionar ao Carrinho</th>
                </tr>
            </thead>
            <tbody class="box">
                <?php
                while ($user_data = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $user_data['id'] . "</td>";
                    //echo "<td>".$user_data['user_id']."</td>";
                    echo "<td>" . $user_data['nome'] . "</td>";
                    echo "<td>" . $user_data['cnpj'] . "</td>";
                    echo "<td>" . $user_data['telefone'] . "</td>";
                    echo "<td>" . $user_data['serviço'] . "</td>";
                    echo "<td>" . $user_data['data_serv'] . "</td>";
                    echo "<td>" . $user_data['cidade'] . "</td>";
                    echo "<td>" . $user_data['estado'] . "</td>";
                    echo "<td>" . $user_data['endereco'] . "</td>";
                    echo "<td>" . $user_data['valor'] . "</td>";
                    echo "<td><button onclick='adicionarAoCarrinho(" . json_encode($user_data) . ")'>Adicionar</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    
    <script>

        let carrinho = [];

        function adicionarAoCarrinho(servico) {
            carrinho.push(servico);
            console.log(carrinho);
            alert("Serviço adicionado ao carrinho!");
        }


        function adicionarAoCarrinho(servico) {
            carrinho.push(servico);
            console.log(carrinho);
            alert("Serviço adicionado ao carrinho!");
            atualizarCarrinho();
        }

        function atualizarCarrinho() {
            const listaCarrinho = document.getElementById('listaCarrinho');
            listaCarrinho.innerHTML = '';
            carrinho.forEach(servico => {
                const li = document.createElement('li');
                li.textContent = `Nome: ${servico.nome}, Serviço: ${servico.serviço}, Valor: ${servico.valor}`;
                listaCarrinho.appendChild(li);
            });
            
        }

        function finalizarCompra() {
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
                carrinho = []; // Limpar o carrinho
                atualizarCarrinho();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }






        function filtrarPorNome() {
            const input = document.getElementById('filtroNome');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[4]; // coluna "Nome"
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
                const td = tr[i].getElementsByTagName('td')[5]; // coluna "Data de Serviço"
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