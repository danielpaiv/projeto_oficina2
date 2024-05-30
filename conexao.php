<?php
    $dbhost = 'localhost';
    $dbUsername = 'root';
    $dbpassword ='';
    $dbName = 'banco_dados';

    $conexao = new mysqli($dbhost,$dbUsername,$dbpassword,$dbName);

    if($conexao->connect_errno)
   {
     echo "Erro";
   }
   else
   {
       echo "Formulário enviado com sucesso";
   }