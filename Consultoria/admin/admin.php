<?php

session_start();
include "../db.php";

$admin_id = $_SESSION['user_id'];
$admin_nome = $_SESSION['user_nome'];

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location:loginAdmin.php');
    exit();
}
$sqlCheckUser = "SELECT * FROM loginadmin WHERE nome = '$admin_nome'";
$resultCheckUser = $conn->query($sqlCheckUser);

if ($resultCheckUser->num_rows == 0) {
    header('Location:loginAdmin.php');
    exit();
}
if (!$admin_id || !$admin_nome) {
    session_start();
    session_destroy();
    header("Location:loginAdmin.php");
} else {
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
<link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

<link href="../bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Consultoria</title>
</head>
<style>
    body {
        font-family: 'Syne', sans-serif;
        margin: 0;
        top: 0;
        /* background: white; */
        background-position: fixed;
        background-size: cover;
        overflow-x: hidden;
        /* overflow: hidden; */
        /* background-color: white; */
        height: 100vh;
        /* background-image:url('../fundo-consult.png'); */
    }

    html {
        overflow-x: hidden;
    }

    :root {
        --cor1: #434343;
        --cor2: #FAD900;
        --cor3: #FC4850;
        --cor4: #C5CAE9;
    }

    h2 {
        text-align: left;
        align-items: center;
        margin-left: 22vh;
        color: var(--cor1);
    }

    p {
        text-align: center;
        margin-top: 20px;
        color: var(--cor1);
    }

    header {
        /* background: #fff; */
        /* padding: 3px; */
        /* height: 10vh; */
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: auto;

    }

    .header {
        display: flex;
        justify-content: space-between;
        margin: auto;
        align-items: center;
    }

    img {
        align-items: center;
        justify-content: space-between;
        width: 70px;
        height: 80px;
        display: flex;
        padding: 5px;
        margin-top: 10px;
        margin-right: 520px;
    }

    nav {
        display: flex;
        justify-content: space-between;
        margin: auto;
        align-items: center;
    }

    table {
        margin: auto;
        /* padding: 10px; */
        width: 80%;
        text-align: center;
        /* cursor: pointer; */
        /* border-radius: 8px; */
    }

    th {
        padding: 5px;
        margin: 0;
        top: 0;
        /* color: white; */
        font-weight: bold;
        /* border-radius: 3px; */
        /* background-color: var(--cor1); */
        color: var(--cor1);
    }

    td {
        padding: 5px;
        border-radius: 3px;
        /* background-color: white; */
    }

    a {
        text-decoration: none;
        color: var(--cor3);
        font-weight: bold;
    }

    div.header {
        display: flex;
        justify-content: space-between;
        margin: auto;
    }

    div.nav-item {
        display: flex;
        justify-content: space-between;
        margin: auto;
    }

    button {
        padding: 8px;
        border-radius: 25px;
        border: none;
        align-items: center;
        margin-top: 20px;
        font-family: 'Syne', sans-serif;
        background: var(--cor1);
        color: #fff;
        font-weight: 550;
        cursor: pointer;
    }

    main {
        /* display: flex; */
        /* margin: auto; */
        /* justify-content: space-between; */
        /* background-color: green; */
        overflow: hidden;
    }

    .logo {
        width: 115px;
        height: 80px;
    }

    .container {
        padding: 10px;
        /* height: 100%; */
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        /* margin: auto; */
        /* background-color: red; */
        /* flex: 1; */
    }

    .container-card {
        padding: 28px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        margin: auto;

    }

    .card {
        padding: 20px;
        width: 260px;
        height: 120px;
        box-shadow: 0px 0px 1px gainsboro;
    }

    /* canvas {
        /* margin: auto; */
    /* display: flex; */


    div.graphic {
        display: flex;
        /* flex-wrap: wrap; */
        /* justify-content: space-between; */
        margin: auto;
        border-radius: 5px;
        /* background-color: gainsboro; */
        height: 300px;
        padding-bottom: 60px;
        width: 100%;
        /* background-color: red; */
        gap: 20px;
        margin-bottom: 30px;
    }

    .barChart {
        /* background-color: white; */
        width: 100%;
        /* height: 300px; */
        border-radius: 5px;
        padding: 10px;
        /* margin: auto; */
        /* display: flex; */
        position: relative;
        margin-left: 25px;
    }

    .pieChart {
        width: 30%;
        /* background-color: white; */
        border-radius: 5px;
        height: 100%;
        padding: 50px;
        margin: auto;
    }

    .table {
        top: 10px;
        position: relative;
    }

    .container-card section.card:first-child {
        background-color: var(--cor1);
        color: white;
        border-radius: 10px;
    }

    .container-card section.card:nth-child(2) {
        background-color: var(--cor1);
        color: white;
        border-radius: 10px;
    }

    .container-card section.card:nth-child(3) {
        background-color: var(--cor1);
        color: white;
        border-radius: 10px;
    }

    .container-card section.card:nth-child(4) {
        background-color: var(--cor1);
        color: white;
        border-radius: 10px;
    }
</style>

<body>
    <div id="progress-bar"></div>
    <style>
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

        img {
            width: 30px;
            height: 30px;
        }
    </style>
    <header>
        <div class="header">
            <div class="nav-item dropdown">
                <nav class="header-list">
                    <br>
                    <img src="../logo.png" class="logo" alt="logo">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <!-- <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"> -->
                        <p class="d-none d-lg-inline-flex">
                            <?php echo "<span style='color:var(--cor1);font-weight:bold;'>" . $admin_nome . "</span>"; ?>
                        </p>
                    </a>
                    <div class="dropdown-menu bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="gest-user.php" class="dropdown-item">
                            <i class="fas fa-user-cog"></i>
                            Gestão de Usuários
                        </a>
                        <a href="loginAdmin.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>
                            Terminar Sessão
                        </a>
                    </div>


                    <!-- <p>Chefe <?php echo "<span style='color:var(--cor1);font-weight:bold;'>" . $admin_nome . "</span>"; ?>
                    acessou ao sistema!</p> -->

                    <!-- <div class="session">
                        <a href="loginAdmin.php">
                            <button>Terminar Sessão</button>
                        </a>
                    </div> -->
                </nav>

            </div>
        </div>
    </header>
    <main>
        <!-- <h2>Dados do Sistema</h2> -->

        <div class="container">
            <div class="container-card">
                <section class="card">
                    <?php
                    $sqlClientes = "SELECT COUNT(*) as totalClientes FROM usuarios WHERE funcao = 'Cliente'";
                    $resultClientes = $conn->query($sqlClientes);
                    $rowClientes = $resultClientes->fetch_assoc();
                    $totalClientes = $rowClientes['totalClientes'];
                    ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 style="font-size:14px;">Total de Clientes</h5>
                            <p style="border:1px solid var(--cor2); width:30px; height:30px; border-radius:20px;">
                                <?php echo "<span style='color:white; font-weight:bold;'>$totalClientes</span>"; ?>
                            </p>
                        </div>
                        <div>
                            <i class="fas fa-users fa-2x" style="color: var(--cor4);"></i>
                        </div>
                    </div>
                </section>
                <section class="card">
                    <?php
                    $sqlConsultores = "SELECT COUNT(*) as totalConsultores FROM usuarios WHERE funcao = 'Consultor'";
                    $resultConsultores = $conn->query($sqlConsultores);
                    $rowConsultores = $resultConsultores->fetch_assoc();
                    $totalConsultores = $rowConsultores['totalConsultores'];
                    ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 style="font-size:14px;">Total de Consultores</h5>
                            <p style="border:1px solid var(--cor2); width:30px; height:30px; border-radius:20px;">
                                <?php echo "<span style='color:white; font-weight:bold;'>$totalConsultores</span>"; ?>
                            </p>
                        </div>
                        <div>
                            <i class="fas fa-user-tie fa-2x" style="color: var(--cor4);"></i>
                        </div>
                    </div>
                </section>

                <section class="card">
                    <?php
                    $sqlPostos = "SELECT COUNT(*) as totalPostos FROM postos";
                    $resultPostos = $conn->query($sqlPostos);
                    $rowPostos = $resultPostos->fetch_assoc();
                    $totalPostos = $rowPostos['totalPostos'];
                    ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 style="font-size:14px;">Total de Postos</h5>
                            <p style="border:1px solid var(--cor2); width:30px; height:30px; border-radius:20px;">
                                <?php echo "<span style='color:white; font-weight:bold;'>$totalPostos</span>"; ?>
                            </p>
                        </div>
                        <div>
                            <i class="fas fa-building fa-2x" style="color: var(--cor4);"></i>
                        </div>
                    </div>
                </section>

                <section class="card">
                    <?php
                    $sqlUsuarios = "SELECT COUNT(*) as totalUsuarios FROM usuarios";
                    $resultUsuarios = $conn->query($sqlUsuarios);
                    $rowUsuarios = $resultUsuarios->fetch_assoc();
                    $totalUsuarios = $rowUsuarios['totalUsuarios'];
                    ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 style="font-size:14px;">Total de Usuários</h5>
                            <p style="border:1px solid var(--cor2); width:30px; height:30px; border-radius:20px;">
                                <?php echo "<span style='color:white; font-weight:bold;'>$totalUsuarios</span>"; ?>
                            </p>
                        </div>
                        <div>
                            <i class="fas fa-user fa-2x" style="color: var(--cor4);"></i>
                        </div>
                    </div>
                </section>

            </div>
            <div class="graphic">
                <div class="barChart">
                    <canvas id="barChart" width="700" height="200"></canvas>
                </div>
                <div class="pieChart">
                    <canvas id="pieChart" width="100" height="200"></canvas>
                </div>
                <!-- <canvas id="barChart2" width="700" height="200"></canvas> -->
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById("pieChart").getContext("2d");
                    var pieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ["Clientes", "Consultores", "Usuários"],
                            datasets: [{
                                label: 'Distribuição de Usuários',
                                data: [<?php echo $totalClientes; ?>, <?php echo $totalConsultores; ?>, <?php echo $totalUsuarios; ?>],
                                backgroundColor: [
                                    "#FAD900",
                                    "#FC4850",
                                    "#C5CAE9"
                                ],
                                borderColor: "#fff",
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById("barChart").getContext("2d");
                    var barChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Clientes', 'Consultores'],
                            datasets: [{
                                label: 'Total de usuários por funções',
                                data: [
                                    <?php
                                    $sqlContagem = "SELECT funcao, COUNT(*) as count FROM usuarios GROUP BY funcao";
                                    $resultContagem = $conn->query($sqlContagem);
                                    $contagens = [];
                                    while ($rowContagem = $resultContagem->fetch_assoc()) {
                                        $contagens[] = $rowContagem['count'];
                                    }
                                    echo implode(", ", $contagens);
                                    ?>
                                ],
                                backgroundColor: [
                                    <?php
                                    $sqlFuncoes = "SELECT funcao FROM usuarios";
                                    $resultFuncoes = $conn->query($sqlFuncoes);
                                    $cores = [];
                                    while ($rowFuncoes = $resultFuncoes->fetch_assoc()) {
                                        if ($rowFuncoes['funcao'] == 'Cliente') {
                                            $cores[] = '"#FC4850"'; // Amarelo para Clientes
                                        } else if ($rowFuncoes['funcao'] == 'Consultor') {
                                            $cores[] = '"#FAD900"'; // Vermelho para outros
                                        } else {
                                            $cores[] = '"#000"';
                                        }
                                    }
                                    echo implode(", ", $cores);
                                    ?>
                                ],
                                borderColor: "#fff",
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                    var progressBar = document.getElementById('progress-bar');
                    progressBar.style.width = '80%';

                    window.addEventListener('load', function() {
                        setTimeout(function() {
                            progressBar.style.display = 'none';
                        }, 500);
                    });
                });
            </script>
        </div>
    </main>
    <div class="table">
        <?php
        if ($conn->connect_error) {
            die("Conexao Falhou: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table>
            <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Funçao</th>
            <th>Acções</th>
            </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . htmlspecialchars($row['nome']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['funcao']) . "</td>
                <td>
                <a title='Eliminar' class='btn btn-danger text-white' href='delete.php?id=" . $row['id'] . "'>
                <i class='fas fa-trash-alt'></i>
                </a>
                </td>
                ";
            }
            echo "</table>";
        }
        ?>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../lib/chart/chart.min.js"></script>
<script src="../lib/easing/easing.min.js"></script>
<script src="../lib/waypoints/waypoints.min.js"></script>
<script src="../lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../lib/tempusdominus/js/moment.min.js"></script>
<script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../js/main.js"></script>

</html>