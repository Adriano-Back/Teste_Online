<?php
require_once 'user.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Author Adriano Back
-->
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Loja Inicio</title>
        <link rel="stylesheet" type="text/css" href="_css/estilo.css"/>
    </head>
    <body>
        <?php
        require_once 'define.php';
 
        if(isset($_SESSION['user_id'])){
        require_once 'header.php';
        echo'<h1>Loja - Ultimos Produtos a compra adicionados</h1>';

        $erro_index = 0;
        $conn = mysqli_connect(HOST,USER,PASS,DATA) or die ($erro_index = 'Não foi possivel conectar a database!');
        
        //puxando os produtos cadastrados da database
        $query = "SELECT * FROM produtos ORDER BY entrou ASC";
        $result = mysqli_query($conn,$query);
        
        //o index somente irá mostrar os 20 primeiros produtos
            for($i=0;$i<=20;$i++){
                $row = mysqli_fetch_array($result);
                if($row['compra_venda'] == 'compra'){
                echo '<article>';
                    echo '<div>';
                        echo '<img src="' . UP_DIR . $row['foto']. '"/>';
                        echo '<p id="nomep">Descrição: ' . $row['nome'] . '</p>';
                        echo '<p id="valor">Valor: R$' . number_format($row['custo'],2,",",".") . '</p>';
                        echo '<p id="acao">Situação: ' . $row['compra_venda'] . '</p>';
                        echo '<a href="produto.php?id=' . $row['item'] .'">Ver mais</a>';
                    echo '</div>';
                echo '</article>';
                }
            }
        require_once 'footer.php';
        }else{
           echo'<p>Para acessar esta pagina você precisa se <a href="cadastro_usuario.php">cadastrar<a/> ou fazer <a href="login.php">login</a></p>';
        }
        ?>
    </body>
</html>
