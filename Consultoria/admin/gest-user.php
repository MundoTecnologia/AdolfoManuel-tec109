<?php

session_start();

include_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM usuarios";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Usuários</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="../css/styles.css"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
        margin: 0;
        top: 0;
        box-sizing: border-box;
    }

    h2 {
        color: var(--cor1);
    }

    :root {
        --cor1: #434343;
        --cor2: #FAD900;
        --cor3: #FC4850;
        --cor4: #C5CAE9;
    }

    body {
        height: 100vh;
        font-family: 'Syne', sans-serif;
        /* background-image: url('../fundo-consult.png'); */
        background-position: fixed;
        background-size: cover;
        background-repeat: no-repeat;
    }

    li {
        list-style: none;
    }

    table {
        margin: auto;
        padding: 10px;
        margin-top: 20px;
        width: 80%;
        margin-bottom: 20px;
        text-align: center;
        /* margin: auto; */
    }

    th {
        padding: 5px;
        margin: 0;
        color: white;
        font-weight: bold;
        background-color: var(--cor1);
        text-align: center;
    }

    td {
        padding: 5px;
        /* background-color: gainsboro; */
        /* color: white; */
        gap: 10px;
        border-bottom: 1px solid #000;
    }

    a {
        text-decoration: none;
        font-weight: bold;
    }
</style>

<body>
    <header class="d-flex p-4 align-items-center justify-content-around">
        <h2>Gestão de Usuários</h2>
        <nav class="d-flex justify-content-between">
            <ul>
                <li class="list-none"><a class="text-decoration-none" href="admin.php">Voltar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1 class="d-flex justify-content-center m-auto align-items-center fs-3">
            Lista de Pagamentos
        </h1>
        <table>
            <thead>
                <tr>
                    <th>Consultor</th>
                    <th>Comprovativo</th>
                    <th>Status</th>
                    <th>Data de Pagamento</th>
                    <th>Acção</th>
                </tr>
            </thead>
            <tbody>
                <?php include '../db.php';
                $sql = "SELECT * FROM pagamentos";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['usuario_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['comprovativo']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['data_pagamento']); ?></td>
                        <td>
                            <a title="Alterar Status" class="btn btn-primary text-white" href="status.php?id=<?php echo $row['id']; ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- <a href="delete.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Desejas realmente eliminar?');">Delete</a> -->
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
    <main>
        <div class="d-flex m-auto justify-content-center align-items-center">
            <h1 class="gap-5 d-flex mx-5 fs-3">
                Lista de Postos
            </h1>
            <button type="submit" onclick="handlePosto()" class="btn btn-primary mb-3">Adicionar Posto</button>
            <!-- Modal -->
            <div class="modal fade" id="addPostoModal" tabindex="-1" aria-labelledby="addPostoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPostoModalLabel">Adicionar Posto</h5>
                            <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="add_posto.php" method="post">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome do Posto</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Adicionar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function handlePosto() {
                    var myModal = new bootstrap.Modal(document.getElementById('addPostoModal'));
                    myModal.show();
                }
            </script>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Acção</th>
                </tr>
            </thead>
            <tbody>
                <?php include '../db.php';
                $sql = "SELECT * FROM postos";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td>
                            <a title="Alterar" class="btn btn-primary text-white" href="edit.php?id=<?php echo $row['id']; ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a title="Eliminar" class="btn btn-danger bg-danger" href="delete.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Desejas realmente eliminar?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <main>
        <div class="d-flex m-auto justify-content-center align-items-center">
            <h1 class="gap-5 mx-5 d-flex fs-3">
                Lista de Províncias
            </h1>
            <button onclick="handleProvincias()" class="btn btn-primary mb-3">Adicionar Província</button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addProvinciaModal" tabindex="-1" aria-labelledby="addProvinciaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProvinciaModalLabel">Adicionar Província</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="add_provincia.php" method="post">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome da Província</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function handleProvincias() {
                var myModal = new bootstrap.Modal(document.getElementById('addProvinciaModal'));
                myModal.show();
            }
        </script>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Acção</th>
                </tr>
            </thead>
            <tbody>
                <?php include '../db.php';
                $sql = "SELECT * FROM provincias";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td>
                            <a title="Editar" class="btn btn-primary text-white" href="edit.php?id=<?php echo $row['id']; ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a title="Eliminar" class="btn btn-danger text-white" href="delete.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Desejas realmente eliminar?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>


    <main>
        <div class="d-flex m-auto justify-content-center align-items-center">
            <h1 class="gap-5 mx-5 d-flex fs-3">
                Lista dos Tipos de Consultorias
            </h1>
            <button onclick="handleConsultoria()" class="btn btn-primary mb-3">Adicionar Consultoria</button>
            <!-- Modal -->
            <div class="modal fade" id="addConsultoriaModal" tabindex="-1" aria-labelledby="addConsultoriaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addConsultoriaModalLabel">Adicionar Consultoria</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="add_consultoria.php" method="post">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome da Consultoria</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Adicionar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function handleConsultoria() {
                    var myModal = new bootstrap.Modal(document.getElementById('addConsultoriaModal'));
                    myModal.show();
                }
            </script>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Acção</th>
                </tr>
            </thead>
            <tbody>
                <?php include '../db.php';
                $sql = "SELECT * FROM tipoconsultoria";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td>
                            <a title="Editar" class="btn btn-primary text-white" href="edit.php?id=<?php echo $row['id']; ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a title="Eliminar" class="btn btn-danger text-white" href="delete.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Desejas realmente eliminar?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>


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
<!-- <script src="../js/main.js"></script> -->

</html>
</tr>
</tbody>
</ul>