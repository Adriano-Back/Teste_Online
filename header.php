<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <html lang="pt-br">
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="_css/estilo.css"/>
    </head>
    <body>
        <header>
            <div>
        <?php
            echo '<p>Olá, ' . $_COOKIE['user_name'].'</p>';
        ?>
            
        <nav>
            <ol>
                <li><a href="index.php">Vende-se</a></li>
                <li><a href="compra_se.php">Compra-se</a></li>
                <li><a href="cadastro_produto.php">Cadastrar Produto</a></li>
                <li><a href="meus_produtos.php">Meus Produtos</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ol>
        </nav>
                </div>
        </header>
    </body>
</html>
