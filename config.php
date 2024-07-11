<?php
   /*$dbhost = 'localhost';
    $dbUsername = 'u151972251_vendaspdv';
    $dbpassword ='Danipaiva1991@';
    $dbName = 'u151972251_pdvvendas';*/

    $dbhost = 'localhost';
    $dbUsername = 'root';
    $dbpassword ='';
    $dbName = 'servicos_oficina';

    $conexao = new mysqli($dbhost,$dbUsername,$dbpassword,$dbName);

   // if($conexao->connect_errno)
   //{
   //    echo "Erro";
   //}
   //else
  // {
   //    echo "conexao efetuada com sucesso";
   //}