<?php
include "../db.php";
$id = $_GET['id'];
echo $id;
$sql = "DELETE FROM pagamentos WHERE usuario_id=$id";
$conn->query($sql);
$sql = "DELETE FROM usuarios WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: admin.php");
} else {
    echo "Erro ao Apagar: {$conn->error}";
}
$conn->close();
