<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Loja - Produto</title>
        <link rel="stylesheet" type="text/css" href="_css/estilo.css"/>
    </head>
    <body>
<?php

require_once 'user.php';
require_once 'define.php';

if(isset($_SESSION['user_id'])){
    require_once 'header.php';
    echo '<h1>Loja - Produto</h1>';
    $id = $_GET['id'];
    $conn = mysqli_connect(HOST, USER, PASS, DATA) or die ($error = 'Não foi possivel conectar a database!');
    
    $query = "SELECT * FROM produtos WHERE item='$id'";
    $result = mysqli_query($conn, $query) or die ($error = 'Não foi possivel consultar ou produto não existe!');
    $row = mysqli_fetch_array($result);
    
    $query_r = "SELECT * FROM cliente WHERE id='{$row['cli_comp']}'";
    $result_r = mysqli_query($conn, $query_r) or die ($error = 'Não foi possivel consultar o vendedor ou comprador!');
    $row_r = mysqli_fetch_array($result_r);
    
    echo '<Article class="mais">';
    echo '<div>';
    echo '<img src="' . UP_DIR . $row['foto']. '"/>';
    echo '<p id="resp"> Responsável: ' . $row_r['nome'] . '</p>';
    echo '<p id="resp"> Contato: ' . $row_r['tel'] . '</p>';
    echo '<p id="resp"> email: ' . $row_r['email'] . '</p>';
    echo '<p id="nomep">Descrição: ' . $row['nome'] . '</p>';
    echo '<p id="valor">Valor: R$' . number_format($row['custo'],2,",",".") . '</p>';
    echo '<p id="acao">Situação: ' . $row['compra_venda'] . '</p>';
    echo '<p>Enviar mensagem de interesse ao <a href="Mensagem.php?id=' . $row['cli_comp'] . '">Responsavel</a></p>';
    echo '</div>';
    echo '</article>';
    
    
    
}else{
    header('location:login.php');
}
require_once 'footer.php';
?> 
    </body>
</html>
