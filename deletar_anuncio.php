<?php
require_once 'user.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="_css/estilo.css"/>
        <title>Deletar</title>
    </head>
    <body>
        <?php
        require_once 'define.php';
        
        $exec= 0;
        $error = 0;
        $id = $_GET['id'];
        
        
        if(isset($_POST['confirma'])){
        $conf = $_POST['confirm'];
        $conn = mysqli_connect(HOST, USER, PASS, DATA) or die ($error = 'Não foi possivel conectar a database');
        if(isset($_SESSION['user_id']) && ($conf == 'yes')){
            $query_a = "SELECT foto FROM produtos WHERE item='$id' AND cli_comp=";
            $result_a = mysqli_query($conn, $query_a) or die($error = 'Não foi possivel consultar a database');
            $row = mysqli_fetch_array($result_a);
            $img = $row['foto'];
            @unlink(UP_DIR.$img);
            $query = "DELETE FROM produtos WHERE item='$id' AND cli_comp='{$_SESSION['user_id']}'";
            $result = mysqli_query($conn, $query) or die ($error = 'Não foi possivel consultar a database');
            echo '<p>Anuncio removido com sucesso <a href="meus_produtos.php">Voltar</a></p>';
            
            if($error == 0){
                $exec = 1;
            }else{
                echo $error;
                $exec = 0;
            }
            
        }else{
            echo'<p>Para acessar esta pagina você precisa se <a href="cadastro_usuario.php">cadastrar<a/> ou fazer <a href="login.php">login</a></p>';
        }
        }
        if($exec == 0){
        ?>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <p>Você tem certeza que deseja excluir seu anuncio?</p>
            <label>Sim</label>
            <input type="radio" name="confirm" id="confirm" value="yes"/>
            <label>Não</label>
             <input type="radio" name="confirm" id="confirm" value="no"/>
             <input type="submit" name="confirma" id="confirma" value="Confirma"/>
        </form>
        <?php
        }
        ?>
    </body>
</html>
