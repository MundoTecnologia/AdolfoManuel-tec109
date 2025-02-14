<?php
include 'db.php';

$tipoConsultoriaId = isset($_GET['tipo_consultoria_id']) ? intval($_GET['tipo_consultoria_id']) : 0;

// header('Content-Type:application/json');

if($tipoConsultoriaId > 0){
    $sql = "SELECT * FROM consultores WHERE tipo_consultoria_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$tipoConsultoriaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $consultores = [];
    while($row = $result->fetch_assoc()){
        $consultores[] = $row;
    }

    echo json_encode($consultores);
}
else{
    echo json_encode([]);
}

$conn->close();

?>