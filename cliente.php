<?php
include 'db.php';

// Iniciar consulta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_nome = $_POST['cliente_nome'];
    $id = uniqid();
    $senha = $_POST['senha'];

    $sql = "INSERT INTO clientes (id, nome, senha) VALUES ('$id', '$cliente_nome', '$senha')";
    if ($conn->query($sql) === TRUE) {
        header("Location: cliente.php?id=$id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obter o ID da consulta
$consultoria = $_GET['id'] ?? '';
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
        font-family: 'Syne', sans-serif;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultoria Online - Cliente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php if ($id): ?>
        <h1>Consultoria Online - Cliente</h1>
        <p>Seu ID de consulta: <?php echo $id; ?></p>
        <iframe src="consultoria_room.php?id=<?php echo $id; ?>" frameborder="0" width="100%" height="600px"></iframe>
        <form action="end_consultoria.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit">Encerrar Consulta</button>
        </form>
    <?php else: ?>
        <h1>Iniciar Consultoria</h1>
        <form action="cliente.php" method="POST">
            <input type="text" name="cliente_nome" placeholder="Seu Nome" required>
            <button type="submit">Iniciar Consulta</button>
        </form>
    <?php endif; ?>
</body>

</html>