<?php
include 'db.php';
session_start();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber e validar os dados
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $funcao = trim($_POST['funcao']);
    $provincia = isset($_POST['provincia_id']) ? (int)$_POST['provincia_id'] : null;

    if (empty($nome) || empty($email) || empty($senha) || empty($funcao) || empty($provincia)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Email inválido.";
    } elseif (strlen($senha) < 8) {
        $erro = "A senha deve ter pelo menos 8 caracteres.";
    } else {
        // Verificar se a conexão foi estabelecida
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Verificar se o nome já está registrado
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nome = ?");
        if (!$stmt) {
            die("Erro na consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $erro = "Nome já registrado! Mude-o.";
        } else {
            // Verificar se o email já está registrado
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            if (!$stmt) {
                die("Erro ao preparar a consulta: " . $conn->error);
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $erro = "Email já registrado.";
            } else {
                // Inserir o novo usuário
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, funcao, provincia_id) VALUES (?, ?, ?, ?, ?)");

                if (!$stmt) {
                    die("Erro ao preparar a consulta: " . $conn->error);
                }

                $stmt->bind_param("ssssi", $nome, $email, $senhaHash, $funcao, $provincia);

                if ($stmt->execute()) {
                    if ($funcao === "Consultor") {
                        header("Location: payment.php");
                        exit;
                    } else {
                        $sucesso = "Conta criada com sucesso!";
                    }
                } else {
                    $erro = "Erro ao criar a conta. Tente novamente.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne&display=swap" rel="stylesheet">
    <title>Sign Up</title>
    <style>
        body {
            font-family: 'Syne', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            /* background-color: #f4f4f4; */
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
            border: 1px solid #ddd;
            border-radius: 5px;
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
            color: white;
            font-weight: 600;
            border: none;
            cursor: pointer;
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
            <img src="sign-up.png" alt="Logotipo">
            <h3>Ter uma ideia é <span style="color: #FAD900;">certo</span>, consultar é <span style="color: #FAD900;">correto</span></h3>
        </div>
        <div class="container-right">
            <form method="post">
                <h2>Bem-Vindo! Cadastre-se</h2>
                <?php if ($erro): ?>
                    <p class="error-message"><?php echo $erro; ?></p>
                <?php endif; ?>
                <?php if ($sucesso): ?>
                    <p class="success-message"><?php echo $sucesso; ?></p>
                <?php endif; ?>
                <input required type="text" name="nome" placeholder="Nome completo">
                <input required type="email" name="email" placeholder="Email">
                <select name="funcao" required>
                    <option value="Cliente">Cliente</option>
                    <option value="Consultor">Consultor</option>
                </select>
                <select name="provincia_id" id="provincia_id" required>
                    <option value="">Selecione uma Província</option>
                    <?php
                    include "db.php";
                    $sql = "SELECT * FROM provincias";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                        }
                    } else {
                        echo "<option class='text-danger' value=''>Nenhuma Província Disponível</option>";
                    }
                    $conn->close();
                    ?>
                </select>
                <input required type="password" name="senha" placeholder="Senha">
                <a href="login.php" style="text-align: left; color: #434343; text-decoration: none;">Já tenho uma conta!</a>
                <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
</body>

</html>