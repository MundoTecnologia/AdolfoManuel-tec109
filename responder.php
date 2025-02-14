<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$consultor_id = $_SESSION['user_id'];
$cliente_id = isset($_SESSION['cliente_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['responder'])) {
    $mensagem_id = $_POST['mensagem_id'];
    $resposta = trim($_POST['resposta']);

    if (!empty($resposta)) {
        $stmt = $conn->prepare("INSERT INTO respostas (mensagem_id, consultor_id, resposta, data_envio) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $mensagem_id, $consultor_id, $resposta);
        if ($stmt->execute()) {
            $updateStmt = $conn->prepare("UPDATE mensagens SET respondida = 1 WHERE id = ?");
            $updateStmt->bind_param("i", $mensagem_id);
            $updateStmt->execute();

            echo "<script>alert('Resposta enviada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao enviar a resposta.');</script>";
        }
    }
}

$stmt = $conn->prepare("SELECT id, cliente_id, mensagem FROM mensagens");
$stmt->execute();
$result = $stmt->get_result();

if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Mensagens</title>
    <style>
        /* Estilos para a barra de progresso */
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
            0% {
                width: 0;
            }

            50% {
                width: 10%;
            }

            100% {
                width: 50%;
            }
        }

    @import url('https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


        * {
            margin: 0;
            top: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --cor1: #434343;
            --cor2: #FAD900;
            --cor3: #FC4850;
            --cor4: #C5CAE9;
        }

        header {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            font-family: 'Syne', sans-serif;
        }

        .logo {
            margin-top: 10px;
        }

        nav {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }

        ul {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        li {
            list-style: none;
        }

        .link-active {
            color: var(--cor1);
            font-weight: 600;
        }

        a {
            text-decoration: none;
            color: var(--cor4);
        }

        a:hover {
            transition: 0.3s linear;
            color: var(--cor1);
            font-weight: 600;
        }

        button {
            width: 140px;
            height: 35px;
            margin-top: 10px;
            background: var(--cor1);
            color: white;
            border-radius: 30px;
            border: none;
            padding: 5px;
            cursor: pointer;
            font-family:'Syne', sans-serif;
        }

        button:hover {
            box-shadow: 0px 0px 8px var(--cor1);
            transition: 0.1s linear;
        }

        input[type="submit"] {
            width: 140px;
            height: 35px;
            margin-top: 10px;
            background: var(--cor1);
            color: white;
            border-radius: 30px;
            border: none;
            padding: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            box-shadow: 0px 0px 8px var(--cor1);
            transition: 0.1s linear;
        }

        .btn-agendar {
            color: var(--cor1);
            background: white;
        }

        .btn-agendar:hover {
            box-shadow: 0px 0px 8px #fff;
            transition: 0.1s linear;
        }

        .landing {
            display: flex;
            justify-content: space-between;
            background: var(--cor1);
            height: 380px;
            width: 100%;
        }

        .landing-text {
            justify-content: center;
        }

        .landing-h1 {
            align-items: center;
            margin: 60px 50px 0px -10px;
            color: #fff;
            justify-content: center;
        }

        .landing-p {
            align-items: center;
            margin: 10px 400px 0px -25px;
            color: #fff;
        }

        .landing-img {
            width: 100px;
            height: 100px;
            margin-left: -10px;
        }

        .consultora-img {
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        .btn-agendar {
            margin: -30px;
            margin-top: 20px;
            font-size: 16px;
            color: var(--cor1);
        }

        .consultoria {
            padding: 3px;
            width: 100%;
            height: auto;
        }

        .consultora-img {
            flex: 1;
        }

        .consultoria-h1 {
            color: var(--cor1);
            margin: 25px;
        }

        .consultoria-p {
            color: var(--cor1);
            margin: 0px 25px -190px;
        }

        .consultoria h2 {
            margin: 25px;
            max-width: max-content;
            color: var(--cor2);
        }

        .consultoria {
            justify-content: space-around;
            display: flex;
        }

        .img-consultores {
            border-radius: 35px;
        }

        .ver-mais {
            border: 1px solid var(--cor4);
            background: var(--cor4);
            color: #fff;
            font-size: 16px;
            position: relative;
            top: 180px;
            margin: 25px;
        }

        .ver-mais:hover {
            box-shadow: 0px 0px 8px var(--cor4);
            color: #fff;
            transition: .2s linear;
        }

        .lista {
            display: flex;
            justify-content: space-around;
            background: var(--cor1);
            max-width: 50%;
            margin: auto;
            font-size: 12px;
            padding: 8px;
            color: var(--cor4);
            border-radius: 30px;
        }

        .sobre {
            display: flex;
            justify-content: space-between;
            margin: 25px;
        }

        .sobre-text h2 {
            color: var(--cor2);
        }

        .sobre-texto {
            display: flex;
            justify-content: space-around;
            margin: 0px 25px;
        }

        .sobre-p {
            color: var(--cor1);
            margin: 0px 25px;
        }

        .sobre-img img {
            border-radius: 30px;
            max-width: 100%;
            height: auto;
        }

        .sobre-img {
            width: 400px;
        }

        .nossatime {
            display: flex;
            justify-content: space-around;
            align-items: center;
            text-align: center;
        }

        .consultor-img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            margin: 10px;
        }

        .text {
            color: var(--cor1);
            font-weight: 600;
        }

        .cards-consultores {
            display: flex;
            justify-content: center;
            margin: auto;
        }

        .card-time {
            border-radius: 30px;
            border: 1px solid var(--cor1);
            max-width: 150px;
            margin: 25px;
            padding: 5px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin: 25px;
        }

        .text {
            color: var(--cor1);
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- Barra de progresso -->
    <div id="progress-bar"></div>

    <header>
        <h1> Mensagens de Clientes</h1>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="mensagem">
                <p> <strong>Cliente ID:</strong>
            <?=htmlspecialchars($row['cliente_id'])?>
            </p>
                <p> <strong>Mensagem:</strong><?=nl2br(htmlspecialchars($row['mensagem']))?></p>
                <?php if ($row['mensagem'] == 0): ?>
                <form method="POST">
                    <textarea name="resposta" placeholder="Digite sua resposta" required></textarea>
                    <input type="hidden" name="mensagem_id" value="<?= $row['id'] ?>">
                    <button type="submit" name="responder">Responder</button>
                </form>
            <?php else: ?>

                <?php
                // Buscar a resposta correspondente
                $respStmt = $conn->prepare("SELECT resposta, data_envio FROM respostas WHERE mensagem_id = ?");
                $respStmt->bind_param("iis", $row['id']);
                $respStmt->execute();
                $respResult = $respStmt->get_result();
                $resposta = $respResult->fetch_assoc();
                ?>
                <div class="resposta">
                    <p><strong>Resposta:</strong> <?= nl2br(htmlspecialchars($resposta['resposta'])) ?></p>
                    <p><small>Enviada em: <?= $resposta['data_envio'] ?></small></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
    <!-- JavaScript para a barra de progresso -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var progressBar = document.getElementById('progress-bar');
            progressBar.style.width = '50%';

            window.addEventListener('load', function() {
                setTimeout(function() {
                    progressBar.style.display = 'none';
                }, 500);
            });
        });
    </script>
</body>

</html>