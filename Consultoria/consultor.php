<?php
include 'db.php';

$erro = '';

$postos = [];
$provincias = [];

$resultPostos = $conn->query("SELECT * FROM postos");
if ($resultPostos->num_rows > 0) {
    while ($row = $resultPostos->fetch_assoc()) {
        $postos[] = $row;
    }
}

$resultProvincias = $conn->query("SELECT * FROM provincias");
if ($resultProvincias->num_rows > 0) {
    while ($row = $resultProvincias->fetch_assoc()) {
        $provincias[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $telefone = htmlspecialchars(trim($_POST['telefone']));
    $senha = $_POST['senha'];
    $posto_id = isset($_POST['posto_id']) ? intval($_POST['posto_id']) : 0;
    $provincia_id = isset($_POST['provincia_id']) ? intval($_POST['provincia_id']) : 0;

    if (strlen($nome) < 4) {
        $erro = "O nome deve ter pelo menos 4 caracteres.";
    } else if (!preg_match('/^\d{9}$/', $telefone)) {
        $erro = "O telefone deve conter exatamente 9 dígitos.";
    } else if (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } else if ($posto_id <= 0) {
        $erro = "Selecione um Posto válido.";
    } else if ($provincia_id <= 0) {
        $erro = "Selecione uma Província válida.";
    }

    if (empty($erro)) {
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO consultores (nome, telefone, senha, funcao, posto_id, provincia_id) VALUES (?,?,?,?,?,?)");
        if ($stmt) {
            $stmt->bind_param("ssssii", $nome, $telefone, $senha_hashed, $posto_id, $provincia_id);

            if ($stmt->execute()) {
                header("Location:login.php");
                exit;
            } else {
                $erro = "Erro ao cadastrar. Tente novamente.";
            }
            $stmt->close();
        } else {
            $erro = "Erro na preparação da consulta.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script>
        async function fetchPostos(provinciaId) {
            const response = await fetch(`get_postos.php?provincia_id=${provinciaId}`);
            const postosSelect = document.getElementById("postos_id");
            postosSelect.innerHTML = '<option value="">Selecionar Posto</option>';

            if (response.ok) {
                const postos = await response.json();
                postos.forEach(posto => {
                    const option = document.createElement('option');
                    option.value = posto.id;
                    option.textContent = posto.nome;
                    postosSelect.appendChild(option);
                });
            } else {
                postosSelect.innerHTML = '<option value="">Nenhum postos disponível</option>';
            }
        }

        async function fetchConsultor(provinciaId) {
            const response = await fetch(`get_consultores.php?provincia_id=${provinciaId}`);
            const consultoresSelect = document.getElementById("consultores_id");
            consultoresSelect.innerHTML = '<option value="">Selecionar Consultores</option>';

            if (response.ok) {
                const consultores = await response.json();
                consultores.forEach(consultor => {
                    const option = document.createElement('option');
                    option.value = consultor.id;
                    option.textContent = consultor.nome;
                    consultoresSelect.appendChild(option);
                })
            } else {
                consultoresSelect.innerHTML = '<option value="">Nenhum consultor disponível</option>';
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;500;700&display=swap');

        body {
            height: 100vh;
            margin: 0;
            font-family: 'Syne', sans-serif;
            background: gainsboro;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        :root {
            --cor1: #434343;
            --cor2: #FAD900;
            --cor3: #FC4850;
            --cor4: #C5CAE9;
        }

        .container-all {
            display: flex;
            gap: 85px;
            border-radius: 20px;
        }

        .container-left,
        .container-right {
            padding: 20px;
            height: 80vh;
            border-radius: 18px;
        }

        .container-left {
            width: 58vh;
        }

        .container-right {
            width: 66vh;
        }

        img {
            width: 340px;
            height: 285px;
            border-radius: 110px;
            margin: auto;
            display: block;
        }

        h2,
        h3 {
            text-align: center;
        }

        form {
            padding: 8px;
        }

        input {
            margin: 10px 0;
            width: 290px;
            padding: 8px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            font-family: 'Syne', sans-serif;
        }

        select {
            margin: 10px 0;
            width: 305px;
            padding: 8px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            font-family: 'Syne', sans-serif;
        }

        input[type="submit"] {
            background: var(--cor1);
            color: #fff;
            font-weight: 550;
            cursor: pointer;
            width: 300px;
        }

        a {
            text-decoration: none;
            color: var(--cor1);
            font-size: 13px;
        }

        p {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container-all">
        <div class="container-left">
            <h3>Ter uma ideia é <span style="color: var(--cor3);">certo</span><br>consultar é <span
                    style="color: var(--cor3);">correcto</span></h3>
            <img src="model.png" alt="logotipo" class="logo">
        </div>
        <div class="container-left">
            <h3 class="margin">Seja Bem-Vindo à nossa página!<br>Faça seu cadastro aqui!</h3>
            <?php if ($erro): ?>
                <p><?php echo $erro; ?></p>
            <?php endif; ?>
            <form method="post" action="" class="container-right">
                <input required type="text" name="nome" placeholder="Nome completo">
                <input required type="number" name="telefone" placeholder="Telefone (9 dígitos)">
                <select name="provincia_id" id="provincia_id" required onchange="fetchPostos(this.value)">
                    <option value="">Selecione uma Província</option>
                    <?php
                    include 'db.php';
                    $sql = "SELECT * FROM provincias";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                        }
                    } else {
                        echo "<option class='text-danger' valeu=''>Nenhuma Província Disponível</option>";
                    }
                    $conn->close();
                    ?>
                </select>
                <select name="postos_id" id="postos_id" required>
                    <option value="">Selecione um Posto</option>
                </select>
                <input required type="password" name="senha" placeholder="Senha">
                <br>
                <a href="login.php">Já tenho uma conta!</a>
                <br>
                <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var progressBar = document.getElementById('progress-bar');
            progressBar.style.width = '80%';

            window.addEventListener('load', function() {
                setTimeout(function() {
                    progressBar.style.width = '100%';
                    setTimeout(function() {
                        progressBar.style.display = 'none';
                    }, 500);
                }, 500);
            });
        });
    </script>
</body>

</html>