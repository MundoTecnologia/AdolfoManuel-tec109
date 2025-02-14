<?php
session_start();
include 'db.php';


$dia = date('d');
$mes = date('m');
$ano = date('Y');
$meses = [
    "01" => "Janeiro",
    "02" => "Fevereiro",
    "03" => "Março",
    "04" => "Abril",
    "05" => "Maio",
    "06" => "Junho",
    "07" => "Julho",
    "08" => "Agosto",
    "09" => "Setembro",
    "10" => "Outubro",
    "11" => "Novembro",
    "12" => "Dezembro",
];

$data = ' ' . $dia . ' ' . $meses[$mes] . ' ' . $ano;

// echo $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['cliente_nome']) && !empty($_POST['cliente_nome'])) {
        $cliente_id = $_POST['cliente_nome'];

        $sql = "SELECT nome FROM usuarios WHERE id = '$cliente_id' AND funcao = 'Cliente'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cliente_nome = $row['nome'];

            $_SESSION['cliente_id'] = $cliente_id;
            $_SESSION['cliente_nome'] = $cliente_nome;
        } else {
            echo "Cliente não encontrado!";
        }
    } else {
        echo "Por favor, selecione um cliente";
    }

    if (isset($_POST['consultor_nome']) && !empty($_POST['consultor_nome'])) {
        $consultor_id = $_POST['consultor_nome'];

        $sql = "SELECT nome FROM usuarios WHERE id = '$consultor_id' AND funcao = 'Consultor'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $consultor_nome = $row['nome'];

            $_SESSION['consultor_id']  = $consultor_id;
            $_SESSION['consultor_nome'] = $consultor_nome;
        } else {
            echo "Consultor não encontrado";
        }
    } else {
        echo "Por favor, selecione um consultor";
    }

    if (isset($_POST['consultoria_nome']) && !empty($_POST['consultoria_nome'])) {
        $consultoria_id = $_POST['consultoria_nome'];

        $sql = "SELECT nome FROM tipoConsultoria WHERE id = '$consultoria_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['consultoria_id'] = $consultoria_id;
            $_SESSION['consultoria_nome'] = $row['nome'];
        } else {
            echo "Consultoria não encontrada!";
        }
    } else {
        echo "Por favor, selecione um tipo de consultoria";
    }
    $consultor_nome = $_POST['consultor_nome'];
    $consultoria_nome = $_POST['consultoria_nome'];


    $consultor_nome = $conn->real_escape_string($consultor_nome);

    $sql = "SELECT nome FROM consultores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $consultor_nome);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $consultor = $result->fetch_assoc();
        // $_SESSION['consultor_nome'] = $consultor['consultor_nome'];
    }
    $sql = "SELECT nome FROM tipoConsultoria WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $consultoria_nome);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $consultor = $result->fetch_assoc();
        $consultoria_nome = $consultor['consultoria_nome'];
        $consultoria_nome = $consultor['consultor_nome'];
    }
    // $_SESSION['consultoria_nome'] = $consultor['consultoria_nome'];

    header("Location:agendar_next.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="bootstrap-5.0.2/css/bootstrap.min.css">
    <title>Agendar Consultoria</title>
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
    </script>
    <script>
        //  async function fetchConsultor(tipoConsultoriaId) {
        //     const response = await fetch(`get_consultores.php?consultoria_nome=${tipoConsultoriaId}`);
        //     const consultoresSelect = document.getElementById("consultor_nome");
        //     consultoresSelect.innerHTML = '<option value="">Selecionar Consultores</option>';

        //     if (response.ok) {
        //         const consultores = await response.json();
        //         consultores.forEach(consultor => {
        //             const option = document.createElement('option');
        //             option.value = consultor.id;
        //             option.textContent = consultor.nome;
        //             consultoresSelect.appendChild(option);
        //         })
        //     }
        //     else {
        //         consultoresSelect.innerHTML = '<option value="">Nenhum consultor disponível</option>';
        //     }
        // }
    </script>
</head>

<body>
    <div id="progress-bar"></div>
    <style>
        #progress-bar {
            position: fixed;
            top: -10px;
            left: 0;
            width: 0;
            height: 6px;
            background-color: #C5CAE9;
            z-index: 1;
            transition: width 1s ease-out;
        }

        /* Animação para o loader */
        @keyframes progress {
            0% {
                width: 0;
            }

            50% {
                width: 60%;
            }

            100% {
                width: 100%;
            }
        }
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            top: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Syne', sans-serif;
            background-image: url("fundo-consult.png");
            background-size: cover;
        }

        :root {
            --cor1: #434343;
            --cor2: #FAD900;
            --cor3: #FC4850;
            --cor4: #C5CAE9;
        }

        header {
            display: flex;
            justify-content: space-around;
            padding: 10px;
        }

        .logo {
            margin-top: 10px;
        }

        nav {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        form {
            margin: auto;
            display: block;
        }

        main {
            display: block;
        }

        a {
            text-decoration: none;
        }

        button {
            width: 100%;
            background: var(--cor1);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 25px;
            transition: all 0.3s;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            margin: auto;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }

        textarea {
            padding: 8px;
            width: 450px;
            border-radius: 5px;
            border: 1px solid var(--cor4);
            height: 150px;
            color: var(--cor1);
            font-size: 14px;
            font-family: 'Syne', sans-serif;
            margin: auto;
            display: block;
        }

        select {
            width: 300px;
            padding: 5px;
            height: 30px;
            border: 1px solid var(--cor4);
            border-radius: 5px;
            font-family: 'Syne', sans-serif;
            margin: auto;
            display: block;
        }

        .data {
            width: 300px;
            padding: 5px;
            height: 30px;
            border: 1px solid var(--cor4);
            border-radius: 5px;
            font-family: 'Syne', sans-serif;
            margin: auto;
            display: block;
        }

        .btn {
            display: flex;
            justify-content: space-between;
        }

        #agendar {
            margin-left: 650px;
            margin-top: -35px;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        p {
            text-align: center;
        }

        .client-name {
            color: dodgerblue;
        }

        section {
            justify-content: center;
            margin: auto;
            margin-top: 30px;
        }

        div {
            margin-bottom: 10px;
            display: block;
        }

        h6 {
            text-align: left;
            margin: auto;
            justify-content: center;
            display: flex;
            font-weight: 200;
            margin-top: -18px;
        }

        .download {
            color: dodgerblue;
            font-size: 14px;
            text-align: center;
            margin: auto;
            display: block;
        }

        button.btn-input {
            padding: 6px;
            border: none;
            border-radius: 5px;
            font-family: "Syne", sans-serif;
            cursor: pointer;
            text-align: center;
            align-items: center;
            justify-content: center;
            width: 20%;
            margin: auto;
            color: white;
        }

        .btn-input:hover {
            transition: all;
            color: white;
        }

        .custom-select-height {
            height: 38px;
        }
    </style>

    <div class="container">
        <header class="text-center mb-4">
            <h1 class="text-info fw-bold fs-2">Agendamentos</h1>
        </header>
        <article class="py-4 rounded">
            <p class="text-center text-secondary">Estimado utente, os agendamentos podem ser feitos a qualquer dia, mas,
                a consultoria é apenas de Segunda à Sexta-Feira das<b class="fw-bold text-primary"> &nbsp; 08h:00 até
                    15h:30</b>.</p>
            <h6 class="text-secondary">Se está com dificuldades em fazer o agendamento, a AngoConsult disponibiliza
                nesta página um formulário bastante intuitivo para agendamento da sua <br> consultoria no posto de
                atendimento ao público, por favor tire o máximo proveito deste serviço.</h6>
            <div class="text-center">
                <a href="#" data-bs-toggle="modal" data-bs-target="#confirm"
                    class="download btn text-decoration-underline  text-primary">
                    DOWNLOAD | ANGOCONSULT - Manual de Agendamento Online
                </a>
            </div>
        </article>
        <main class="my-4 text-center">
            <p class="text-center text-secondary">Clique neste botão para agendar</p>
            <button data-bs-toggle="modal" type="button" data-bs-target="#modalAgendamento"
                class="btn btn-info btn-input">Agendar</button>
        </main>
</body>



<div class="modal fade" tabindex="-1" id="confirm" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manual de Agendamento - AngoConsult</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-center mt-3">Desejas realmente baixar o manual?</h6>
            </div>
            <div class="modal-footer">
                <div class="d-flex gap-4">
                    <button class="btn btn-lg btn-primary" data-bs-dismiss="modal" onClick="DonwloadPDF()">Sim</button>
                    <button class="btn btn-danger btn-lg text-center justify-content-center w-50"
                        data-bs-dismiss="modal">Não</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modalAgendamento" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Agendar Consultoria - AngoConsult</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="agendar.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="provincia_id" class="form-label">Província</label>
                        <select name="provincia_id" id="provincia_id" name="provincia_id"
                            class="form-select custom-select-height" required onchange="fetchPostos(this.value)">
                            <option value="">Selecionar Província</option>
                            <?php
                            include 'db.php';
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
                    </div>
                    <div class="mb-3">
                        <label for="consultoria_nome" class="form-label">Tipo de Consultoria</label>
                        <select name="consultoria_nome" id="consultoria_nome"
                            class="form-select custom-select-height" required>
                            <option value="">Selecione um tipo de consultoria</option>
                            <?php
                            include 'db.php';
                            $sql = "SELECT * FROM tipoConsultoria";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                                }
                            } else {
                                echo "<option class='text-danger fw-bold'>Sem Consultoria disponível</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="postos_id" class="form-label">Posto de Atendimento </label>
                        <select name="postos_id" id="postos_id" class="form-select custom-select-height" required>
                            <option value="">Selecionar Posto</option>
                        </select>
                        <div>
                            <label for="consultor_nome" class="form-label">Selecionar Consultor </label>
                            <select name="consultor_nome" id="consultor_nome" class="form-select custom-select-height"
                                required>
                                <option value="">Selecionar Consultor</option>
                                <?php
                                include 'db.php';

                                $sql = 'SELECT * FROM usuarios WHERE funcao = "Consultor"';
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                                    }
                                } else {
                                    echo "<option class='text-danger' value=''>Nenhum Consultor Disponível</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="data_inicio" class="form-label">Disponível apartir do dia </label>
                            <?php
                            include 'db.php';
                            $sql = "SELECT id, nome FROM usuarios WHERE funcao = 'Consultor'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                echo "<input  type='text' id='data_inicio' class='form-control' contextEditable=' " . false . " ' disabled value=' " . $data . " ' />";
                            } else {
                                echo "<option value=''>Nenhum Consultor disponível</option>";
                            }
                            $conn->close();
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer row">
                        <button type="button" class="btn btn-secondary justify-content-center"
                            data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary justify-content-center">Seguinte</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script>
    function DonwloadPDF() {
        const blob = new Blob(['Manual de Agendamento'], {
            type: "application/pdf"
        })

        const fileUrl = './Manual de Agendamento - AngoConsult.pdf'
        const link = document.createElement("a")
        link.href = fileUrl
        link.download = 'Manual de Agendamento - AngoConsult.pdf'

        document.body.appendChild(link)
        link.click()

        URL.revokeObjectURL(fileUrl)
    }

    var progressBar = document.getElementById('progress-bar');
    progressBar.style.width = '50%';

    window.addEventListener('load', function() {
        setTimeout(function() {
            progressBar.style.display = 'none';
        }, 500);
    });
</script>
<script src="bootstrap-5.0.2/js/bootstrap.min.js"></script>
<script src="bootstrap-5.0.2/js/bootstrap.js"></script>

</html>