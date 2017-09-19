<?php
require_once 'user.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Loja - Login</title>
        <link rel="stylesheet" type="text/css" href="_css/estilo.css"/>
    </head>
    <body>
        <h1>Loja - Login</h1>
        <?php
        require_once 'define.php';//define senhas de database
        
        $error_login = 0;
            
            if(isset($_POST['entrar'])){
                
                $conn = mysqli_connect(HOST, USER, PASS, DATA) or die($error_login = 'Não foi possivel conectar a database!');
                $email = mysqli_real_escape_string($conn, trim($_POST['email']));
                $senha = mysqli_real_escape_string($conn, trim($_POST['pass']));
                
                if(!empty($email)){
                    if(!empty($senha)){
                        $query = "SELECT * FROM cliente WHERE email='$email' AND senha=SHA('$senha')";
                        $result = mysqli_query($conn, $query) or die ($error_login = 'Não foi possivel executar a consulta');
                        if(mysqli_num_rows($result) == 1){
                            $row = mysqli_fetch_array($result);
                            //definindo sessoes
                            $_SESSION['user_id'] = $row['id'];
                            $_SESSION['user_name'] = $row['nome'];
                            //definindo cookies 
                            setcookie('user_id',$row['id'], time() + (60*60*2));
                            setcookie('user_name',$row['nome'], time() + (60*60*2));
                            
                            
                        }else{
                            $error_login = 'Desculpe, não foi encontrado nenhum<br>usuario cadastrado ou a senha esta incorreta.';
                            //eliminando a sujeira e resetando o sistema de login
                            $_SESSION['user_id'] = array();
                            $_SESSION['user_name'] = array();
                            session_destroy(); 
                            setcookie('user_id','', time() - (60*60*3));
                            setcookie('user_name','', time() - (60*60*3));
                        }  
                    }else{
                        $error_login = 'Desculpe, você precisa informar uma senha';
                    }
                }else{
                    $error_login = 'Desculpe, você precisa informar um email';
                }  
            }
            if(!isset($_SESSION['user_id'])){
        ?>
    
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <input type="email" name="email" id="email" value="<?php if(!empty($email)){echo $email;}?>" placeholder="Email"/><br>
            <input type="password" name="pass" id="pass" placeholder="Senha"/><br>
            <p><?php
            if(!empty($error_login)){
                echo $error_login;
            }
            ?></p>
            <input type="submit" name="entrar" id="entrar" value="Entrar"/>
        <p>Ainda não é cadastrado? <a href="cadastro_usuario.php">Cadastre-se</a></p>
        </form>
    
        <?php
            }else{
                echo '<p class="aviso">Olá, ' . $_COOKIE['user_name'].'</p>';
                echo'<p class="aviso">Você está logado deseja ir a <a href="index.php">pagina principal</a>?</p>';
            }
        require_once 'footer.php';
        ?>
    </body>
</html>
