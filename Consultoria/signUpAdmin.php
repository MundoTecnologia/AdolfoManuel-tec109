<?php
    include 'db.php';

    $erro = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $senha = password_hash($_POST['senha'],PASSWORD_DEFAULT);

        $sql = "INSERT INTO loginadmin (nome, telefone , senha) VALUES ('$nome','$telefone','$senha')";
        if($conn->query($sql)=== TRUE){
            header("Location:loginAdmin.php");
        }
        else{
            echo "<p style='color:red;'>Administrador já Registrado!</p>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <title>Cadastrar - Administrador</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body{
        height:100vh;
        margin:0;
        box-sizing:border-box;
        font-family:'Poppins',sans-serif;
        background:gainsboro;

        display:flex;
        align-items:center;
        justify-content:center;
    }
    :root{
        --cor1:#434343;
        --cor2:#FAD900;
        --cor3:#FC4850;
        --cor4:#C5CAE9;
    }
    p{
        text-align:center;
    }
    .container-all{
        display:flex;
        padding:10;
        justify-content:space-between;
        gap:85px;
        border-radius:20px;
    }
    .container-left{
        padding:10px;
        height:80vh;
        width:58vh;
        border-radius:18px;
        border-top-right-radius:0px;
        border-bottom-right-radius:0px;

    }
    .container-right{
        padding:10px;
        height:80vh;
        width:66vh;
        align-items:center;
    }
    img{
        width:340px;
        height:285px;
        border-radius:100px;
        margin:auto;
        display:block;
        margin-top:60px;
    }
    h2{
        font-size:20px;
        align-items:center;
        margin-top:55px;
        font-weight:500;
    }
    h3{
        align-items:center;
        margin-top:55px;
        font-weight:500;
        text-align:center;
        transition:10s;
        margin-top:100px;
        font-size:25px;
    }
   span{
    color:var(--cor3);
   }
   form{
    padding:30px;
    top:-10px;
    left:-80px;
    position:relative;
   }
   input{
    margin:auto;
    display:grid;
    justify-self:center;
    width:280px;
    padding:8px;
    border-radius:5px;
    border:none;
    font-size:13px;
    outline:none;
    font-family:'Poppins',sans-serif;
   }
   select{
    margin:auto;
    display:block;
    padding:8px;
    border-radius:5px;
    width:295px;
    border:none; 
    font-size:13px;
    color:gray;
    font-family:'Poppins',sans-serif;
   }
   a{
    text-align:left;
    margin-bottom:10px;
    margin-left:30px;
    margin-top:10px;
    text-decoration:none;
    font-size:13px;
    display:block;
    color:var(--cor1);
   }
   input[type="submit"]{
    background:var(--cor1);
    width:290px;
    color:#fff;
    font-weight:550;
    cursor:pointer;
    font-family:'Poppins',sans-serif;
   }
   h3{
    margin-top:-30px;
    margin-left:5px;
   }
</style>
<body>
<div id="progress-bar"></div>
<style>
  #progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 6px;
            background-color: #C5CAE9;
            z-index: 9999;
            transition: width 1s ease-out;
        }

        /* Animação para o loader */
        @keyframes progress {
            0% { width: 0; }
            50% { width: 10%; }
            100% { width: 50%; }
        }
  </style>
    <div class="container">
        <div class="container-all">
    <div class="container-right">
    <h2>Seja Bem-Vindo a nossa página, <br>
    onde poderás fazer o devido cadastro!</h2>
    <?php if($erro): ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php  endif;?>  
        <form method="post" action="">
        <input required type="text" name="nome" id="nome" placeholder="Nome completo"><br>
        <input required type="number" name="telefone" id="telefone" placeholder="Telefone"><br>
        <input required type="password" name="senha" id="senha" placeholder="Senha"> 
        <a href="loginAdmin.php">Já tenho uma conta!</a>
        <input type="submit" value="Cadastrar">  
    </form>
    </div>
    <div class="container-left">
    <br><br><br>
    <h3>Ter uma ideia é <span>certo</span><br>
    consultar é <span>correcto</span><h3>
        <img src="sign.png" alt="logotipo" class="logo">
    <br><br>
    </div>
    </div>
    </div>
</body>
</html>