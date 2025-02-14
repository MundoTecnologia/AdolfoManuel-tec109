<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
// echo "ID_USER : ". $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $status = 'pendente';
    $comprovativo = '';

    try {
        if (isset($_FILES['comprovativo']) && $_FILES['comprovativo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'comprovativos/';
            if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
                die("<script>alert('Erro ao criar a pasta de upload!');</script>");
            }

            $file_name = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES['comprovativo']['name']));
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['comprovativo']['tmp_name'], $file_path)) {
                $comprovativo = $file_path;

                $sql = "INSERT INTO pagamentos (usuario_id, comprovativo, status, data_pagamento) VALUES ('$user_id', '$comprovativo', '$status', NOW())";
                // $result = $conn->query($sql);
                // Inserção segura no banco de dados
                // $stmt = $conn->prepare(");
                // $stmt->bind_param("iss", $user_id, $comprovativo, $status);
                // $inserir = $stmt->execute();

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Pagamento efectuado com sucesso! Aguarde a Aprovação.');</script>";
                } else {
                    echo "<script>
                    console.log('Erro', '" . $conn->error . "');
                    alert('Erro ao salvar no banco de dados! Tente novamente.');
                    </script>";
                }
            } else {
                echo "<script>alert('Erro ao mover o arquivo!');</script>";
            }
        } else {
            echo "<script>alert('Erro ao efectuar o pagamento!');</script>";
        }
    } catch (\Throwable $th) {
        echo "<script>alert('Erro ao efectuar o pagamento! " . addslashes($th->getMessage()) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Pagamento do Consultor</title>
    <style>
        body {
            height: 100vh;
            font-family: 'Syne', sans-serif;
            overflow-x: hidden;
            animation: fadeIn 1s ease-in-out;
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

        .container-left img {
            width: 300px;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        input[type="file"] {
            border: none;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
            width: 100%;
        }

        form input:focus {
            border-color: #434343;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        form input[type="submit"],
        button {
            background: #434343;
            color: #fff;
            cursor: pointer;
            font-weight: 600;
            border: none;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container-left">
            <img src="payment.png" alt="Pagamentos">
        </div>
        <div class="container-right">
            <h2>Efectuar Pagamento</h2>
            <p class="text-warning">
                O Valor a ser pago é de 2500 KZ!
            </p>
            <p><strong>IBAN:</strong> AO06004400006729503010144</p>
            <form action="" method="POST" enctype="multipart/form-data">
                <label>Carregue o Comprovativo de Pagamento:</label>
                <input type="file" name="comprovativo" accept="image/*,application/pdf" required>
                <button type="submit">Enviar Comprovativo</button>
            </form>
        </div>
    </div>
</body>

</html>