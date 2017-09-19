<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Loja - Cadastro de Produto Compra ou Venda</title>
        <link rel="stylesheet" type="text/css" href="_css/estilo.css"/>
    </head>
    <body>
        <?php
        require_once 'define.php';
        require_once 'user.php';
        
        $error_cadp = 0;
        $info = 0;
        
        if(isset($_SESSION['user_id'])){
            
            require_once 'header.php';
            echo'<h1>Loja - Edição de Anuncio Compra ou Venda</h1>';
            
            
            $conn = mysqli_connect(HOST,USER,PASS,DATA) or die($error_cadp = 'Não foi possivel conectar a database!');
            //trabalhando com a imagem do produto
            $id = $_GET['id'];
            
            if(isset($_POST['atualizar'])){
            $foto_name = mysqli_real_escape_string($conn, trim($_FILES['foto']['name']));
            $foto_size = mysqli_real_escape_string($conn, trim($_FILES['foto']['size']));
            $foto_type = mysqli_real_escape_string($conn, trim($_FILES['foto']['type']));
            
            //as informações do produto
            $tipo =      mysqli_real_escape_string($conn, trim($_POST['tipo']));
            $nome =      mysqli_real_escape_string($conn, trim($_POST['nome']));
            $quant =     mysqli_real_escape_string($conn, trim($_POST['quant']));
            $custo =     mysqli_real_escape_string($conn, trim($_POST['custo']));
            $acao =      mysqli_real_escape_string($conn, trim($_POST['acao']));
            
            if(empty($foto_name)){
                $foto_name = 'sem_img.jpg';
            }
            //verificando erros na imagem
            if($foto_size <= MAX_FILE_SIZE_LOJA){
                if($foto_type == ('image/png') || $foto_type == ('image/jpeg') 
                        || $foto_type == ('image/pjpeg') || $foto_type == ('image/gif')){
                        $target = UP_DIR . $foto_name;
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $target)){
                            if(!empty($tipo)){
                                if(!empty($nome)){
                                    if(!empty($quant)){
                                        if(!empty($custo)){
                                            $usuario = $_SESSION['user_id'];
                                            $query = "UPDATE produtos SET entrou=NOW(),cli_comp='$usuario',foto='$foto_name',tipo='$tipo',nome='$nome',quant='$quant',custo='$custo',compra_venda='$acao'".
                                                    "WHERE item='$id'";
                                            $result = mysqli_query($conn, $query) or die ($error_cadp = 'Não foi possivel conectar a database!');
                                            $info = 'Cadastro efetuado com sucesso!';
                                            mysqli_close($conn);
                                        }else{
                                            $error_cadp = 'Desculpe, você deve dar um valor ao seu produto!';
                                            mysqli_close($conn);
                                        }
                                    }else{
                                        $error_cadp = 'Desculpe, você deve informar a quantidade de seu produto!'; 
                                        mysqli_close($conn);
                                    }
                                }else{
                                    $error_cadp = 'Desculpe, você deve dar um nome ao seu produto!'; 
                                    mysqli_close($conn);
                                }
                            }else{
                                $error_cadp = 'Desculpe, você deve dar uma classe ao seu produto!';
                                mysqli_close($conn);
                            }
                        }else{
                            $error_cadp = 'Desculpe, ocorreu algum erro ao fazer upload da imagem!';
                            mysqli_close($conn);
                        }
                    }else{
                         $error_cadp = 'Desculpe, o formato da imagem deve ser entre jpeg, pjpeg, png ou gif!';
                         mysqli_close($conn);
                    } 
                }else{
                    $error_cadp = 'Desculpe, imagem muito grande para ser carregada max 32kb!';
                    mysqli_close($conn);
                }
            }
            $conn = mysqli_connect(HOST,USER,PASS,DATA) or die($error_cadp = 'Não foi possivel conectar a database!');
            $b_query = "SELECT * FROM produtos WHERE item='$id' AND cli_comp='{$_SESSION['user_id']}'";
            
            $result_f = mysqli_query($conn, $b_query) or die($error_cadp = 'Não foi possivel consultar a database!') ;
            
            while($row_res = mysqli_fetch_array($result_f)){
            $img =       $row_res['foto'];
            $tipo =      $row_res['tipo'];
            $nome =      $row_res['nome'];
            $quant =     $row_res['quant'];
            $custo =     $row_res['custo'];
            mysqli_close($conn);
            }
        ?>
        <form enctype="multipart/form-data" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <img src="<?php echo UP_DIR.$img; ?>"/>
            <label for="foto">Adicione uma foto ao seu produto</label><br>
            <input type="file" name="foto" id="foto"/><br>
                <input type="text" name="tipo" id="tipo" placeholder="Tipo de produto" value="<?php echo $tipo;?>"/><br>
                <input type="text" name="nome" id="nome" placeholder="Marca / Modelo" value="<?php echo $nome;?>"/><br>
                <input type="number" name="quant" id="quant" placeholder="Quantidade" value="<?php echo $quant;?>"/><br>
                <input type="number" name="custo" id="custo" placeholder="R$ Valor" value="<?php echo $custo;?>"/><br>
            <select name="acao" id="acao">
                <option value="compra">Comprando</option>
                <option value="venda">Vendendo</option>
            </select><br>
                <input type="submit" name="atualizar" id="atualizar" value="Atualizar"/>
        </form>
                    <?php
                if(!empty($error_cadp)){
                    echo '<p style="color:rgb(218, 104, 68);border:1px solid rgb(218, 104, 68);font-size:10pt;">' . $error_cadp . '</p>';
                }
                if(!empty($info)){
                    echo '<p style="color:rgb(149, 250, 0);border:1px solid rgb(149, 250, 0);font-size:10pt;">' . $info . '</p>';
                }           
        require_once 'footer.php';
        }else{
            header('location:login.php');
        }
        ?>
    </body>
</html>
