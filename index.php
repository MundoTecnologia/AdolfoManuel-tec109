<?php
include 'db.php';
session_start();

$erro = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $email = $conn->real_escape_string($email);

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_funcao'] = $user['funcao'];
            
            if ($user['funcao'] === 'Cliente') {
                $_SESSION['cliente_id'] = $user['id'];
            }

            if ($user['funcao'] === 'Consultor') {
                header("Location: mensagens.php");
            }
            else if($user['funcao'] === 'Cliente'){
                header("Location:home.php");
            } else {
                header("Location: login.php");
                $erro = "Verifique as suas credenciais!";
            }
            exit();
        } else {
            $erro = "Verifique as suas credenciais!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="bootstrap-5.0.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;800&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
            font-family: 'Syne', sans-serif;
            /* background: linear-gradient(135deg, #434343, #FAD900); */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        h2 {
            font-size: 16px;
        }

        .container {
            display: flex;
            border-radius: 15px;
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
            padding: 10px;
            width: 100%;
        }

        .container-left,
        .container-right {
            width: 100%;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .container-left {
            text-align: center;
            margin-left: -20px;
            display: block;
        }

        .container-left img {
            width: 300px;
            margin: 20px auto;
            border-radius: 50%;
        }

        .container-left h3 {
            font-size: 20px;
            font-weight: 600;
            animation: fadeUp 2s ease-in-out;
            position: relative;
            top: -40px;
        }

        .container-right {
            padding: 60px 30px;
            display: flex;
            width: 50%;
            border-radius: 10px;
            justify-content: center;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.2);
            background: white;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        form input,
        form select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: 0.3s;
        }

        form input:focus,
        form select:focus {
            border-color: #434343;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        form input[type="submit"] {
            background: #434343;
            color: #fff;
            cursor: pointer;
            font-weight: 600;
            border: none;
        }

        form input[type="submit"]:hover {
            background: #FAD900;
            color: #434343;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-message {
            color: red;
            text-align: center;
        }

        .success-message {
            color: green;
            text-align: center;
        }

        @media (max-width: 768px) {
            .container {
                width: 100%;
                display: flex;
                gap: 80px;
                max-width: 800px;
            }

            .container-left {
                display: none;
            }

            .container-right {
                width: 50%;
                text-align: center;
                margin: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container-left">
            <img src="logo2.png" alt="Logo">
            <h3>Ter uma ideia é <span style="color: #FAD900;">certo</span>, consultar é <span
                    style="color: #FAD900;">correto</span></h3>
        </div>
        <div class="container-right">
            <form method="post">
                <h2>Bem-vindo! Faça login para continuar</h2>
                <?php if ($erro): ?>
                    <p class="error-message" ><?php echo $erro; ?></p>
                <?php endif; ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <a href="sign-up.php" style="text-align: left; color: #434343; text-decoration: none;">Criar conta!</a>
                <input type="submit" value="Entrar">
            </form>
        </div>
    </div>
</body>

</html>