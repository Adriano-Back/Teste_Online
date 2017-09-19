<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once'user.php';
if(isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])){
    //destroi os coockies
    setcookie('user_id','', time()-17600);
    setcookie('user_name','', time()-17600);
    //esvazia a sessao
    $_SESSION = array();
    //destroi a sessao
    session_destroy();
    header('location:index.php');
}
