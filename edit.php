<?php
    session_start();
    include_once('config.php');

    // Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        header('Location: edit.php'); // Redireciona para a página de login se não estiver logado
        exit;
    }

    //print_r($_SESSION);
    if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['nome']);
        unset($_SESSION['senha']);
        header('Location: index.php');
    }
    $logado = $_SESSION['nome'];
    $user_id = $_SESSION['user_id'];


    //$sql = "SELECT * FROM usuarios ORDER BY id DESC";

    //$result = $conexao->query($sql);

    //print_r($result);
        //$nome = $cnpj = $telefone = $serviço = $data_serv = $cidade = $estado = $endereco = $valor = "";


    if (!empty($_GET['id'])) 
    {

        include_once('config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM clientes WHERE id=$id";

        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0 )
        {
            while($user_data = mysqli_fetch_assoc($result))
            {
                $nome = $user_data['nome'];
                $cnpj = $user_data['cnpj'];
                $telefone = $user_data['telefone'];
                $servico = $user_data['servico'];
                $data_serv = $user_data['data_serv'];
                $cidade = $user_data['cidade'];
                $estado = $user_data['estado'];
                $endereco = $user_data['endereco'];
                $forma_pagamento = $user_data['forma_pagamento'];
                $valor = $user_data['valor'];
                $user_id =$user_data['user_id']; // Obtém o ID do usuário da sessão
                $estoque =$user_data['estoque'];

                //print_r("USER : " .$nome);
                
            }
        } 
        
             
    }
    
    else {
        // Tratar caso onde o id não é fornecido na URL
            echo "ID do cliente não fornecido.";
            exit;
    }

    // header('Location: listauser.php');
    //exit;
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulario | SERVIÇO</title>
    <script src="adicionar.js"></script>
    <style>
        
        /* Seu CSS aqui */
        body{
        font-family: Arial, Helvetica, sans-serif;
        /*background-image: linear-gradient(to right,rgb(20,147,220), rgb(17,54,71));*/
        background-color:#000066;
        }
        .box{
            columns: 1;
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 15px;
            width: 30%;
            right: 30%;
            color: white;
        }
        fieldset{
            border: 3px solid dodgerblue; 
        }
        legend{
            border: 1px solid dodgerblue; 
            padding: 10px;
            text-align: center;
            background-color: dodgerblue;
            border-radius: 5px;
            
        }
        .inputbox{
            position: relative;

        }
        .inputUser{
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 100%;
            letter-spacing: 3px;
        }
        .labelInput{
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5px;
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput{
            top: -20px;
            font-size: 12px;
            color: dodgerblue;
        }
        #data_nacimento{
            border: none;
            padding: 8px;
            border-radius: 10px;
            color: dodgerblue;
            outline: none;
            font-size: 15px;
        }
        #submit{
            background-image: linear-gradient(to right,rgb(130, 20, 220), rgb(44, 31, 220));
            width: 100%;
            border: none;
            padding: 10px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
        }
        #submit:hover{
            background-image: linear-gradient(to right,rgb(27, 20, 220), rgb(102, 14, 184));
        }
        .btn{
            color:white ;
            padding: 5px;
            text-decoration: none;
        }
        button{
            border-radius: 5px;
            text-decoration: none;
            border: none;
            padding: 15px;
            background-image: linear-gradient(to right,rgb(130, 20, 220), rgb(44, 31, 220));

        }
        nav{
            border: 5px solid dodgerblue;
            position: absolute;
            letter-spacing: 3px;
        }
        @media screen and (max-width: 400px){
            body{
                background-color:#000066;
            }
        }
        @media screen and (max-width: 400px){
            .box{
                width: 100%;
                top:75%;
            }
        }
        @media screen and (max-width: 400px){
            nav{
                top:0%;
                
            }
        }
        h2{
            color:white;
        }
        #data_serv{
            color:black;
            border:black;
        }
    </style>
</head>
<body>
    <nav> 
        <button><a href="sair.php" class="btn btn-danger me-5">Sair</a></button>
        
        <button><a href="listauser.php" class="btn btn-danger me-5">Fazer uma Venda</a></button>
    </nav> 
    <div class="box">
        <form action="saveEdit.php" method="POST">
            <fieldset>
                <legend><b>Formulario de Serviços</b></legend>
                <br><br>


                <div class="inputbox">
                    <input type="text" name="user_id" id="user_id" class="inputUser" value="<?php echo $user_id ?>" required>
                    <label for="user_id" class="labelInput">user_id</label>
                </div>
                <br><br>

                <div class="inputbox">
                    <input type="text" name="nome" id="nome" class="inputUser" >
                    <label for="nome" class="labelInput">Cliente</label>
                </div>
                <br><br>
                <div class="inputbox">
                    <input type="text" name="cnpj" id="cnpj" class="inputUser"  >
                    <label for="cnpj" class="labelInput">CNPJ</label>
                </div>
                <br><br>
                <div class="inputbox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser"  >
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <br><br>
                <!--<p>Serviço de Limpeza</p>-->
                <div class="inputbox">
                    <input type="tel" name="servico" id="servico" class="inputUser" value="<?php echo $servico ?>" required>
                    <label for="servico" class="labelInput">serviço</label>
                </div>
                
            <!--
                <input type="radio" id="fachada" name="serviço" value="limpeza de fachada" <?php echo ($serviço == "limpeza de fachada") ? 'checked' : ''; ?> required>
                <label for="fachada">Fachada</label>

                <input type="radio" id="vidros" name="serviço" value="limpeza de vidros" <?php echo ($serviço == "limpeza de vidros") ? 'checked' : ''; ?> required>
                <label for="vidros">Vidros</label>
                
                <input type="radio" id="outro" name="serviço" value="outro" <?php echo ($serviço == "outro") ? 'checked' : ''; ?> required>
                <label for="outro">Outro</label>
            -->
                <br><br>
                <label for="data_serv"><b>Data do Serviço</b></label>
                <input type="date" name="data_serv" id="data_serv" value="<?php echo $data_serv ?>" required>  
                <br><br><br>
                <div class="inputbox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" >
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>

                <div class="inputbox">
                    <input type="text" name="estado" id="estado" class="inputUser"  >
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br><br>

                <div class="inputbox">
                    <input type="text" name="endereco" id="endereco" class="inputUser"  >
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>
                
            <!--
                <div class="inputbox">
                    <input type="text" name="forma_pagamento" id="forma_pagamento" class="inputUser" value="<?php echo $forma_pagamento ?>" required>
                    <label for="forma_pagamento" class="labelInput">Forma de pagamento</label>
                </div>
                <br><br>
            -->

                <p>pagamento</p>
                <input type="radio" id="dinheiro" name="forma_pagamento" value="dinheiro" <?php echo ($servico == "dinheiro") ? 'checked' : ''; ?> required>
                <label for="dinheiro">dinheiro</label>

                <input type="radio" id="debito" name="forma_pagamento" value="debito" <?php echo ($servico == "debito") ? 'checked' : ''; ?> required>
                <label for="debito">debito</label>
                
                <input type="radio" id="credito" name="forma_pagamento" value="credito" <?php echo ($servico == "credito") ? 'checked' : ''; ?> required>
                <label for="credito">credito</label>

                <input type="radio" id="pix" name="forma_pagamento" value="pix" <?php echo ($servico == "pix") ? 'checked' : ''; ?> required>
                <label for="pix">Pix</label>
                <br><br>

                <div class="inputbox">
                    <input type="text" name="valor" id="valor" class="inputUser" value="<?php echo $valor ?>" required>
                    <label for="valor" class="labelInput">Valor</label>
                </div><br><br>
                <div class="inputbox">
                    <input type="text" name="estoque" id="estoque" class="inputUser" value="<?php echo $estoque ?>" required>
                    <label for="estoque" class="labelInput">estoque</label>
                </div>
                <br><br>

                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="submit" name="update" id="update">
                
            </fieldset>
            
        </form>
    </div>
</body>
</html>