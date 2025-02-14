<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cliente_id = isset($_POST['cliente_id']);
    $consultor_id = isset($_POST['consultor_id']);
    $mensagem = isset($_POST['mensagem']) ? mysqli_real_escape_string($conn, $_POST['mensagem']) : null;
    $data_envio = date('Y:h:m');

    if ($data_envio) {
        $query = "INSERT INTO mensagens (cliente_id, consultor_id,mensagem,data_envio)
            VALUES ('$cliente_id','$consultor_id','$mensagem', '$data_envio')";

        if ($conn->query($query) === TRUE) {
            header("Location: update_agendamento.php?message=Agendamento realizado com sucesso!");
            exit();
        } else {
            die("Erro ao executar a consulta: " . $conn->error);
        }
    } else {
        die("Erro: Dados de agendamento não fornecidos.");
    }
} else {
    die("Erro: Método de requisição inválido.");
}
?>
