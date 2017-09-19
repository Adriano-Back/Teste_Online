<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Author Adriano Back
-->
<html>
    <html lang="pt-br">
        <meta charset="UTF-8">
        <title>Loja - Cadastro de Cliente - Vendedor</title>
        <link rel="stylesheet" type="text/css" href="_css/estilo.css"/>
    </head>
    <body>
        <h1>Loja Cadastro de Cliente - Vendedor</h1>
        <?php
        require_once 'define.php';
        $error = 0;
        $info = 0;
        //conectando a database usando arquivo _config/define.php
        if(isset($_POST['cadastrar'])){
        $conn = mysqli_connect(HOST, USER, PASS, DATA)or die($error = 'Não foi possivel conectar a database!');
            //pegando informções do formulario
            $nome       = mysqli_real_escape_string($conn, trim($_POST['nome']));
            $snome      = mysqli_real_escape_string($conn, trim($_POST['snome']));
            $estado     = mysqli_real_escape_string($conn, trim($_POST['estado']));
            $cidade     = mysqli_real_escape_string($conn, trim($_POST['cidade']));
            $bairro     = mysqli_real_escape_string($conn, trim($_POST['bairro']));
            $rua        = mysqli_real_escape_string($conn, trim($_POST['rua']));
            $num_casa   = mysqli_real_escape_string($conn, trim($_POST['numcasa']));
            $tel        = mysqli_real_escape_string($conn, trim($_POST['tel']));
            $email      = mysqli_real_escape_string($conn, trim($_POST['email']));
            $senha1     = mysqli_real_escape_string($conn, trim($_POST['pass_1']));
            $senha2     = mysqli_real_escape_string($conn, trim($_POST['pass_2']));
            
            //para tratamento de caracteres especiais
            $string     = $nome.$snome.$estado.$cidade.$bairro.$rua.$num_casa.$tel.$senha1;
            
            //vewrificando variaveis vazias
                if(!empty($nome)){
                    if(!empty($snome)){
                            $completo = $nome . ' ' . $snome;
                        if(!empty($cidade)){
                            if(!empty($bairro)){
                                if(!empty($rua)){
                                    if(!empty($num_casa)){
                                        if(!empty($tel)){
                                            if(!empty($email)){
                                                $query_e = "SELECT * FROM cliente WHERE email='$email'";
                                                $result_e = mysqli_query($conn,$query_e);
                                                if(mysqli_num_rows($result_e) == 0){
                                                    if(!empty($senha1) && !empty($senha2) && ($senha1 == $senha2)){
                                                        if(preg_match("/^[a-zA-Z0-9\s]+?$/i", $string)){
                                                        $query = "INSERT INTO cliente (senha,entrou,nome,estado,cidade,bairro,rua,num_casa,tel,email)" .
                                                            "VALUES (SHA('$senha1'),NOW(),'$completo','$estado','$cidade','$bairro','$rua','$num_casa','$tel','$email')"; 
                                                        $result = mysqli_query($conn,$query) or die($error = 'Não foi possivel executar a consulta');    
                                                        $info = 'Cadastro efetuado com sucesso! deseja fazer <a href="login.php">Login</a>?';    
                                                        mysqli_close($conn);
                                                        }else{
                                                            $error = 'Desculpe, você não pode utilizar caracteres especiais !#$%¨&* etc.. .'; 
                                                        }
                                                    }else{
                                                    $error = 'Desculpe, você não digitou uma das senhas ou elas não são iguais.'; 
                                                    }
                                                }else{
                                                    $error = 'Desculpe, endereço de email já cadastrado.';
                                                    mysqli_close($conn);
                                                }
                                            }else{
                                                $error = 'Desculpe, você não informou o seu Email para contato.';
                                                mysqli_close($conn);
                                            }
                                        }else{
                                            $error = 'Desculpe, você não informou o numero de seu Telefone.';
                                            mysqli_close($conn);
                                        }
                                    }else{
                                        $error = 'Desculpe, você não informou o numero de sua Residencia.';
                                        mysqli_close($conn);
                                    }
                                }else{
                                    $error = 'Desculpe, você não informou sua Rua.';
                                    mysqli_close($conn);
                                }
                            }else{
                                $error = 'Desculpe, você não informou seu Bairro.';
                                mysqli_close($conn);
                            }
                        }else{
                            $error = 'Desculpe, você não informou sua Cidade.';
                            mysqli_close($conn);
                        }
                    }else{
                        $error = 'Desculpe, você não informou seu Segundo nome.';
                        mysqli_close($conn);
                    }
                }else{
                    $error = 'Desculpe, você não informou seu Primeiro nome.';
                    mysqli_close($conn);
                }
            }
        ?>
        <form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">
            <input type="text" id="nome" name="nome" placeholder="Primeiro Nome" value="<?php if(!empty($nome)){echo $nome;}?>"/><br>
            <input type="text" id="snome" name="snome" placeholder="Segundo Nome" value="<?php if(!empty($snome)){echo $snome;}?>"/><br>
            <label>Estado </label>
            <select name="estado" id="estado">
                            <option value="AC">AC</option> 	 
                            <option value="AL">AL</option>  	 
                            <option value="AP">AP</option>  	 
                            <option value="AM">AM</option>  	 
                            <option value="BA">BA</option>  	 
                            <option value="CE">CE</option>  	 
                            <option value="DF">DF</option> 	 
                            <option value="ES">ES</option>  	 
                            <option value="GO">GO</option>  	 
                            <option value="MA">MA</option>  	 
                            <option value="MT">MT</option>  	 
                            <option value="MS">MS</option>  	 
                            <option value="MG">MG</option> 	 
                            <option value="PA">PA</option>  	 
                            <option value="PB">PB</option>  	 
                            <option value="PR">PR</option>  	 
                            <option value="PE">PE</option>  	 
                            <option value="PI">PI</option>  	 
                            <option value="RJ">RJ</option>  	 
                            <option value="RN">RN</option>  	 
                            <option value="RS">RS</option>  	 
                            <option value="RO">RO</option> 	 
                            <option value="RR">RR</option>  	 
                            <option value="SC">SC</option>  	 
                   <option  value="SP" selected>SP</option>  	 
                            <option value="SE">SE</option>  	 
                            <option value="TO">TO</option> 
            </select><br>
            <input type="text" id="cidade" name="cidade" placeholder="Cidade" value="<?php if(!empty($cidade)){echo $cidade;}?>"/><br>
            <input type="text" id="bairro" name="bairro" placeholder="Bairro" value="<?php if(!empty($bairro)){echo $bairro;}?>"/><br>
            <input type="text" id="rua" name="rua" placeholder="Rua" value="<?php if(!empty($rua)){echo $rua;}?>"/><br>
            <input type="number" id="numcasa" name="numcasa" placeholder="Numero da Residencia" value="<?php if(!empty($num_casa)){echo $num_casa;}?>"/><br>
            <input type="tel" id="tel" name="tel" placeholder="Telefone" value="<?php if(!empty($tel)){echo $tel;}?>"/><br>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php if(!empty($email)){echo $email;}?>"/><br>
            <input type="password" id="pass_1" name="pass_1" placeholder="Digite uma senha" /><br>
            <input type="password" id="pass_2" name="pass_2" placeholder="Confirme a senha"/><br>
            <?php 
            if(!empty($error)){
                echo '<p style="color:rgb(218, 104, 68);border:1px solid rgb(218, 104, 68);font-size:10pt;">' . $error . '</p>';   
            }
            if(!empty($info)){
                    echo '<p style="color:rgb(149, 250, 0);border:1px solid rgb(149, 250, 0);font-size:10pt;">' . $info . '</p>';
                }
            ?>
            <input type="submit" name="cadastrar" id="cadastrar" /><br>
        </form>
        <a href="index.php">Voltar</a><br>
        <?php
        require_once 'footer.php';
        ?>
    </body>
</html>
