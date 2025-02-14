<?php
include 'db.php';

$provinciaId = isset($_GET['provincia_id']) ? intval($_GET['provincia_id']) : 0;

header('Content-Type:application/json');

if($provinciaId > 0){
    $sql = "SELECT * FROM postos WHERE provincia_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $provinciaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $postos = [];
    while($row = $result->fetch_assoc()){
        $postos[] = $row;
    }

    echo json_encode($postos);
}
else{
    echo json_encode([]);
}

$conn->close();

?>