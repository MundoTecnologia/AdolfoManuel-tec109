<?php
session_start();
include 'db.php';

$consultor_nome = isset($_SESSION['consultor_nome']) ? $_SESSION['consultor_nome'] : 'Não selecionado';
$consultoria_nome = isset($_SESSION['consultoria_nome']) ? $_SESSION['consultoria_nome'] : 'Não selecionado';

$cliente_id = isset($_SESSION['cliente_id']) ? $_SESSION['cliente_id'] : null;
$consultor_id = isset($_SESSION['consultor_id']) ? $_SESSION['consultor_id'] : null;
$consultoria_id = isset($_SESSION['consultoria_id']) ? $_SESSION['consultoria_id'] : null;


// echo "Cliente ID: ". $_SESSION['cliente_id'];
// echo "Consultor ID: " . $_SESSION['consultor_id'];

// echo "Cliente Nome: ".$_SESSION['user_nome'];
// echo "Consultor Nome: " . $_SESSION['consultor_nome'];
// echo "Consultoria ID: " . $_SESSION['consultoria_id'];
// echo "Consultoria Nome: ".$consultoria_nome;

// $_SESSION['consultoria_nome'] = 'Nome da Consultoria';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $consultor_id = $_POST['consultor_id'];
    $consultoria_nome = $_POST['consultoria_nome'];
    $data_envio = $_POST['data_envio'];

    $sql_check = "SELECT id FROM  mensagens WHERE cliente_id = ? AND consultor_id = ? AND mensagem = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("iis", $cliente_id, $consultor_id, $consultoria_nome);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Você já tem um agendamento com este consultor.')</script>";
    } else {
        $sql = "INSERT INTO mensagens (cliente_id, consultor_id, mensagem, data_envio) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $cliente_id, $consultor_id, $consultoria_nome, $data_envio);


        if ($stmt->execute()) {
            echo "Agendamento Feito com sucesso!";
            // header("Location:agendar_next.php");
        } else {
            echo "Erro ao enviar ao Agendar: " . $conn->error;
        }
        $stmt->close();
    }
    $stmt_check->close();
}

$meses = [
    1 => "Jan",
    2 => "Fev",
    3 => "Mar",
    4 => "Abr",
    5 => "Mai",
    6 => "Jun",
    7 => "Jul",
    8 => "Ago",
    9 => "Set",
    10 => "Out",
    11 => "Nov",
    12 => "Dez",
];
$semanas = [
    1 => "Seg",
    2 => "Ter",
    3 => "Qua",
    4 => "Qui",
    5 => "Sex"
];

$horarios = ["8:00", "8:30", "9:00", "9:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00"];
$nextDays = [];
$diaAtual = strtotime("tomorrow");
while (count($nextDays) < 5) {
    if (date('N', $diaAtual) <= 5) {
        $nextDays[] = $diaAtual;
    }
    $diaAtual = strtotime("+1 day", $diaAtual);
}

$agendamentos = [];
$stmt = $conn->query("SELECT data_agendamento, data_agendada FROM agendamentos");
// while ($row = $stmt->fetch_assoc()) {
//     $agendamentos[$row['data']][$row['horario']] = $row['quantidade'];
// }


function rasurarHorarios(&$horarios)
{
    $numRasurar = rand(1, count($horarios) - 1);
    $indicesRasurados = array_rand($horarios, $numRasurar);
    if (!is_array($indicesRasurados)) {
        $indicesRasurados = [$indicesRasurados];
    }
    foreach ($indicesRasurados as $indice) {
        $horarios[$indice] = null;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="bootstrap-5.0.2/css/bootstrap.min.css">
    <title>Agendar Consultoria</title>
    <style>
        body {
            font-family: 'Syne', sans-serif;
            background-color: #f8f9fa;
        }

        .day-column {
            flex: 1;
            margin: 10px;
        }

        .day-header {
            background-color: black;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }

        .time-slot {
            display: flex;
            align-items: center;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .time-slot.disabled {
            color: gray;
            cursor: not-allowed;
        }

        .badge {
            margin-left: auto;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        .bottom-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            border-top: 1px solid #ccc;
            background-color: #fff;
        }

        .arrow-buttons {
            display: flex;
            gap: 10px;
        }

        .arrow-buttons .btn {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            font-size: 20px;
        }

        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: bold;
        }
    </style>
    <script>
        function incrementBadge(button) {
            const badge = button.querySelector('.badge');
            let count = parseInt(badge.textContent.replace('[', '').replace(']', ''));
            count = count === 1 ? 0 : count + 1;
            badge.textContent = `[${count}]`;
        }
    </script>
</head>

<body>
    <div class="container">
        <header class="text-center my-4">
            <h1 class="text-primary">Agendamento</h1>
            <p class="text-muted">Selecione um horário disponível para continuar.</p>
        </header>
        <div class="d-flex justify-content-center">
            <?php foreach ($nextDays as $day):
                $data = date('Y-m-d', $day);
                $diaSemana = date('N', $day);
                $horariosDia = $horarios;
                rasurarHorarios($horariosDia); ?>
                <div class="day-column">
                    <div id="day-header" class="day-header">
                        <?= $semanas[$diaSemana] ?>, <?= date('d', $day) ?> <?= $meses[date('n', $day)] ?>
                    </div>
                    <?php foreach ($horariosDia as $horario):
                        if ($horario === null)
                            continue;
                        $quantidade = isset($agendamentos[$data][$horario]) ? $agendamentos[$data][$horario] : 0;
                        $buttonId = $data . '-' . str_replace(':', '', $horario); ?>
                        <div style="margin: 0; padding: 0;">
                            <input type="hidden" id="data-<?= $buttonId ?>" name="data" value="<?= $data ?>">
                            <input type="hidden" id="horario-<?= $buttonId ?>" name="horario" value="<?= $horario ?>">
                            <form method="POST" action="mensagens.php">
                                <input type="hidden" name="cliente_id" value="<?= $cliente_id; ?>">
                                <input type="hidden" name="consultor_id" value="<?= $consultor_id; ?>">
                                <input type="hidden" name="consultoria_nome" value="<?= $consultoria_nome; ?>">
                                <input type="hidden" name="data_envio" value="<?= date('Y-m-d H:i:s'); ?>">
                                <button type="submit" id="<?= $buttonId ?>" class="time-slot" data-horario="<?= $horario ?>"
                                    onclick="incrementBadge(this)">
                                    <?= $horario ?>
                                    <span class="badge bg-secondary">[<?= $quantidade ?>]</span>
                                </button>
                                <!-- <?php
                                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
                                            $sql = "INSERT INTO mensagens(cliente_id, consultor_id, mensagem , data_envio) VALUES('$cliente_id', '$consultor_id', '$consultoria_nome', NOW())";
                                            $result = $conn->query($sql);

                                            if ($result === TRUE) {
                                                header('Location:agendar_next.php');
                                                echo "Agendamento Feito com sucesso!";
                                            } else {
                                                echo "Erro" . $conn->connect_error;
                                            }
                                        }
                                        ?> -->
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bottom-navigation">
        <a href="agendar.php">
            <button class="btn btn-dark">VOLTAR</button>
        </a>
        <!-- <div class="arrow-buttons">
            <button class="btn btn-dark">&lt;</button>
            <button class="btn btn-dark">&gt;</button>
        </div> -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script>
    document.querySelectorAll('.time-slot').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            let badge = button.querySelector('.badge');
            let quantidade = parseInt(badge.textContent.replace('[', '').replace(']',''), 10);
            quantidade += 0;

            badge.textContent = `[${quantidade}]`;

        console.log(quantidade)
            if (quantidade === 1) {
                const {jsPDF} = window.jspdf;
                const doc = new jsPDF();
                const randomNumber = Math.floor(100000 + Math.random() * 9000);

                const logo = new Image();
                logo.src = './logo.png';
                logo.onload = function() {
                    doc.addImage(logo, 'PNG', 80, 10, 50, 30);

                    const consultor = "<?= "$consultor_nome"; ?> ";
                    const tipoConsultoria = "<?= "$consultoria_nome"; ?>";
                    const data = document.getElementById('data-' + button.id).value;
                    const horario = button.getAttribute('data-horario');

                    console.log("Consultor: " + consultor)

                    doc.setFontSize(16);
                    doc.setFont('helvetica', 'bold');
                    doc.text("AGENDAMENTO", 105, 60, null, null, 'center');
                    doc.setFontSize(12);
                    doc.text(`Data do Agendamento: ${new Date().toLocaleDateString()}`, 115, 70);
                    doc.text(`Comprovativo de Agendamento Nº  ${randomNumber}`, 105, 75);
                    doc.setFont('helvetica', 'normal');
                    doc.autoTable({
                        startY: 80,
                        head: [
                            ['Consultor', 'Tipo de Consultoria', 'Data Agendada', 'Hora']
                        ],
                        body: [
                            [consultor, tipoConsultoria, data, horario]
                        ]
                    });
                    doc.setFontSize(11);
                    doc.setFont('helvetica', 'normal');
                    doc.text(`Obs.: Pedimos aos utentes o escrupuloso cumprimento do horário, comparecendo 15 minutos antes
da hora agendada para acautelar eventuais constrangimentos à entrada. Deve levar consigo toda
documentação, bem como o formulário digital devidamente preenchido.
O agendamento não isenta o pagamento de multa em caso de permanencia ilegal nos termos da lei.`, 10, 115);
                    doc.save("comprovativo_agendamento.pdf");

                    const formData = new FormData();
                    formData.append('cliente_id', '<?= $cliente_id ?>');
                    formData.append('consultor_id', '<?= $consultor_id ?>');
                    formData.append('consultoria_nome', tipoConsultoria);
                    formData.append('data_envio', new Date().toLocaleString());
                    formData.forEach((value, key) => {
                        console.log(key + ": " + value);
                    });


                    fetch('mensagens.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            // alert(data);
                            const xhr = new XMLHttpRequest();
                            xhr.open("POST", "agendar_next.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    console.log("Mensagem enviada com sucesso!");
                                } else if (xhr.readyState === 4) {
                                    console.error("Erro ao enviar mensagem: ", xhr.responseText);
                                }
                            };
                            xhr.send(`cliente_id=<?= $cliente_id ?>&consultor_id=<?= $consultor_id ?>&consultoria_nome=${tipoConsultoria}&data_envio=${new Date().toLocaleString()}`);
                        })
                        .catch(error => {
                            console.error('Erro ao enviar mensagem: ', error);
                        });

                    // Adiciona o formData na tabela mensagens
                    // Código PHP removido do bloco JavaScript
                }
            } else {
                alert("Não pode Agendar mais de uma vez!")
            }


        });
    });
</script>