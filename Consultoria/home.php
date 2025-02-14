<?php
include 'db.php';
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION['user_funcao'] != 'Cliente') {
    $erro = "";
    header("Location:index.php");
    exit();
}

$cliente_id = $_SESSION['user_id'];
$cliente_nome = $_SESSION['user_nome'];

$sql = "SELECT u.usuario, u.nome AS funcao FROM usuarios u JOIN clientes c ON u.cliente_id = c.id WHERE u.cliente_id = '$cliente_id' ORDER BY u.funcao DESC";
$result = $conn->query($sql);
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
    <title>AngoConsult - A sua plataforma de Agendamento de Consultoria</title>
</head>

<body>
    <div id="progress-bar"></div>
    <style>
        #progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 6px;
            background-color: var(--cor2);
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
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            top: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            font-family: 'Syne', sans-serif;
            overflow-x: hidden;
            /* Evita rolagem horizontal */

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

        :root {
            --cor1: #434343;
            --cor2: #FAD900;
            --cor3: #FC4850;
            --cor4: #C5CAE9;
        }

        header {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            font-family: 'Syne', sans-serif;
            margin: auto;
            align-items: center;

        }

        .logo {
            margin-top: 10px;
        }

        nav {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }

        ul {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        li {
            list-style: none;
        }

        .link-active {
            color: var(--cor1);
            font-weight: 600;
        }

        a {
            text-decoration: none;
            color: var(--cor4);
            transition: color 0.3s;

        }

        a:hover {
            color: var(--cor1);
        }

        button {
            width: 140px;
            height: 35px;
            margin-top: 10px;
            background: var(--cor1);
            color: white;
            border-radius: 30px;
            border: none;
            padding: 5px;
            cursor: pointer;
            font-family: "syne", sans-serif;
        }

        button:hover {
            box-shadow: 0px 0px 8px var(--cor1);
            transition: 0.1s linear;
        }

        input[type="submit"] {
            width: 140px;
            height: 35px;
            margin-top: 10px;
            background: var(--cor1);
            color: white;
            border-radius: 30px;
            border: none;
            padding: 5px;
            cursor: pointer;
            font-family: "syne", sans-serif;
        }

        input[type="submit"]:hover {
            box-shadow: 0px 0px 8px var(--cor1);
            transition: 0.1s linear;
        }

        button,
        input[type="submit"] {
            width: 140px;
            height: 35px;
            margin-top: 10px;
            background: var(--cor1);
            color: white;
            border-radius: 30px;
            border: none;
            padding: 5px;
            cursor: pointer;
            transition: box-shadow 0.1s linear;
        }

        button:hover,
        input[type="submit"]:hover {
            box-shadow: 0px 0px 8px var(--cor1);
        }

        .btn-agendar:hover {
            box-shadow: 0px 0px 8px #fff;
            transition: 0.1s linear;
        }

        .landing {
            display: flex;
            justify-content: space-between;
            background: var(--cor1);
            height: 380px;
            width: 100%;
        }

        .landing-text {
            justify-content: center;
        }

        .landing-h1,
        .landing-p {
            color: #fff;
        }

        .landing-h1 {
            align-items: center;
            margin: 60px 50px 0px -10px;
            color: white;
            justify-content: center;
        }

        .landing-p {
            align-items: center;
            margin: 10px 350px 0px -10px;
            font-weight: thin;
            text-align: left;
            margin-bottom: 10px;

        }

        .landing-img {
            width: 100px;
            height: 100px;
            margin-left: -10px;

        }

        .consultora-img {
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        .btn-agendar {
            margin: -30px;
            margin-top: 20px;
            font-size: 16px;
            color: var(--cor1);
        }

        .consultoria {
            padding: 5px;
            width: 100%;
            height: auto;
        }

        .consultoria-container {
            display: block;
            align-items: center;
            margin: 45px;
        }

        .consultora-img {
            flex: 1;
        }

        .consultoria-h1 {
            color: var(--cor1);
            margin: 25px;
        }

        .consultoria-p {
            color: var(--cor1);
            margin: 0px 25px -190px;
            text-align: left;

        }

        .consultoria h2 {
            margin: 25px;
            max-width: max-content;
            color: var(--cor2);
        }

        .consultoria {
            justify-content: space-around;
            display: flex;
        }

        .img-consultores {
            border-radius: 35px;
            margin: auto;
            display: flex;
        }

        .ver-mais {
            border: 1px solid var(--cor4);
            background: var(--cor4);
            color: #fff;
            font-size: 16px;
            position: relative;
            top: 180px;
            margin: 25px;
        }

        .ver-mais:hover {
            box-shadow: 0px 0px 8px var(--cor4);
            color: #fff;
            transition: .2s linear;
        }

        .lista {
            display: flex;
            justify-content: space-around;
            background: var(--cor1);
            max-width: 50%;
            margin: auto;
            font-size: 12px;
            padding: 8px;
            color: var(--cor4);
            border-radius: 30px;
        }

        .sobre {
            display: block;
            justify-content: space-between;
        }

        .sobre-text h2 {
            color: var(--cor2);
            left: 130px;
            position: relative;
        }

        .sobre-texto {
            display: flex;
            justify-content: space-around;
            gap: 30px;
            margin: 40px;
        }

        .sobre-p {
            font-size: 13px;
            text-align: left;
        }

        .sobre-p1 {
            font-size: 13px;
            display: flex;
            text-align: left;
        }

        .servicos {
            justify-content: space-between;
            margin-top: 15px;
        }

        .servicos h2 {
            margin: 50px;
            color: var(--cor2);
            display: block;
        }

        .servicos-i {
            display: flex;
            margin: auto;
            justify-content: space-between;
            margin-left: 400px;
            margin-top: -295px;
            align-items: center;

        }

        .img-servicos {
            border-radius: 30px;
            margin-left: 500px;
            position: absolute;
            top: 10px;
        }

        .svg {
            cursor: pointer;
            justify-content: justify;
            left: 90px;
            top: 60px;
            position: relative;
        }

        h3 {
            color: var(--cor1);
            font-weight: 500;
            font-size: 15px;
            left: 190px;
            top: 20px;
            position: relative;
            height: 5px;
            align-items: center;
        }

        .contacto h2 {
            margin: 35px;
            color: var(--cor2);
        }

        .contacto {
            display: block;
            width: 100%;
        }

        .nome {
            margin: 25px;
        }

        label {
            font-weight: 600;
            color: var(--cor1);
        }

        input {
            padding: 8px;
            width: 450px;
            border-radius: 5px;
            border: 1px solid var(--cor4);
            font-family: 'Syne', sans-serif;
        }

        textarea {
            padding: 8px;
            width: 450px;
            border-radius: 5px;
            border: 1px solid var(--cor4);
            height: 150px;
            color: var(--cor4);
            font-size: 14px;
            font-family: 'Syne', sans-serif;
        }

        .form-input {
            width: 450px;
        }

        .nome1 {
            margin-top: 5px;
        }

        .numero {
            margin-top: 5px;
        }

        .nome3 {
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .prim {
            display: flex;
            justify-content: space-between;
            margin: 10px;
        }

        .img-contacto {
            border-top-left-radius: 35px;
            border-bottom-left-radius: 35px;
            margin-right: -15px;

        }

        footer {
            background: var(--cor1);
            padding: 30px;
            height: 25%;
            align-items: center;
            border-top-left-radius: 35px;
            border-top-right-radius: 35px;
            margin: auto;
            display: flex;
            flex-direction: column;
        }

        .footer1 {
            display: flex;
            justify-content: space-between;
        }

        .footer2 {
            display: block;
            color: #fff;
        }

        .footer1 img {
            top: 30px;
            position: relative;
        }

        .footer2 img {
            top: 70px;
            position: relative;
        }

        .btn-agendar {
            background: #fff;
            color: var(--cor1);
        }

        .servicos-content {
            display: none;
            margin-top: 30px;
            margin-left: 100px;
        }

        .servicos-header {
            display: block;
            align-items: center;
            cursor: pointer;
            margin-left: -60px;
        }

        .servicos-header svg {
            transition: transform 0.3s;
            display: block;
        }

        .servicos-header.active svg {
            transform: rotate(90deg);
        }

        .servicos-header h3 {
            margin-left: -75px;
            display: block;
            padding: 20px;
        }

        p {
            text-align: center;
        }

        .servicos-content p {
            margin: auto;
            text-align: left;
            margin-left: -35px;
            font-size: 13px;
        }

        .servicos-item svg {
            display: block;
        }

        .servicos-container {
            display: block;
            justify-content: space-around;
            position: relative;
            top: -80px;
            height: 50vh;
        }

        svg {
            width: 55px;
        }

        header svg {
            display: none;
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 10px 15px;
            color: #434343;
        }

        header .items nav ul {
            display: flex;
            font-size: 14px;
        }

        header .items nav li ul {
            position: absolute;
            background-color: #434343;
            border-radius: 0 0 8px 8px;
            z-index: 999;
            cursor: pointer;
            display: none;
        }

        header .items nav li ul li {
            display: block;
            text-align: left;
        }

        header .items nav ul li a {
            display: block;
            padding: 15px;
            color: #434343;
            border: 1px solid;
            border-radius: 10px;
            border: none;
            transition: 0.4s;
        }

        header .items nav ul li:last-child {
            margin-right: 0;
        }

        header .items nav li ul li ul {
            padding: 0 20px;
            position: relative;
            background-color: #434343;
            margin-bottom: 10px;
            border-radius: 0 0 8px 8px;
            z-index: 999;
            cursor: pointer;
        }

        header .items nav li ul li ul li {
            display: block;
            margin-bottom: 10px;
            text-align: left;
            display: none;
        }

        header .items nav ul li ul li a {
            display: block;
            color: white;
            border-radius: 10px;
            border: none;
            /* transition:0.4s; */
        }

        /* header .items nav ul li ul li:hover ul li{
            display:block;
        }
        header .items nav ul li a:hover{
            background-color:white;
            color:#434343;
        } */
        .mobile_menu {

            display: none;
            flex-direction: column;
            width: 360px;
            background-color: #434343;
            position: absolute;
            top: 0.01;
            right: 0;
            z-index: 1;
            padding: 5px;
            border-radius: 0px 0px 8px 8px;
        }

        .mobile_menu ul {
            flex-direction: column;
            color: white;
            justify-content: center;
            text-align: left;
            margin-left: 10px;
            padding: 5px 0 5px 30px;
        }

        .mobile_menu ul li {
            position: relative;
            margin: 10px auto;
        }

        .mobile_menu ul li a {
            border-radius: 10px;
            display: block;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
        }

        .mobile_menu ul li ul li {
            width: 100%;
            margin-bottom: 10px;
            cursor: pointer;
            display: none;
        }

        .mobile_menu ul li a:hover {
            background-color: white;
            color: #434343;
        }

        #terminar {
            margin-top: -20px;
        }

        .btn-create-account {
            margin-top: -45px;
            border: 1px solid #434343;
            background-color: white;
            color: #434343;
        }

        @media(max-width:320px) {
            li a {
                font-size: 10px;
                display: none;
            }

            .landing-text {
                display: none;
            }

            button #terminar {
                margin-left: -90px;
                width: 90px;
                height: 28px;
                margin-top: 10px;
                display: none;
            }

            header svg {
                display: flex;
            }
        }

        @media(max-width:768px) {
            header {
                flex-direction: row;
            }

            html {
                display: flex;
                width: 100%;
                height: 100%;
                background-color: red;
                overflow-x: hidden;
            }

            .sobre {
                margin-top: 180px;
                padding: 20px;
            }

            .sobre-text h2 {
                position: relative;
                left: 40px;
            }

            .sobre-img img {
                width: 400px;
            }

            .landing-text {
                display: block;
            }

            .landing-text h1 {
                color: #fff;
                text-shadow: 1px 2px 0px #434343;
                position: relative;
                left: -50px;
            }

            .landing-text p {
                width: 300px;
                text-align: center;
                position: relative;
                left: -65px;
                display: flex;
                flex-wrap: wrap;
            }

            .consultoria-img img {
                display: none;
            }

            .contacto {
                position: relative;
                top: 100px;
            }

            .servicos-i img {
                display: none;
            }

            .lista {
                display: none;
            }

            .lista-e {
                display: none;
            }

            .sobre-texto {
                display: block;
            }

            .img-contacto {
                display: none;
            }

            .servicos-content p {
                position: relative;
                top: -50px;
                left: -50px;
            }

            .servicos-header {
                top: -60px;
                left: -70px;
                position: relative;
            }

            form {
                display: flex;
                flex-direction: column;
                margin-bottom: 160px;
                width: 100%;
                margin-top: -10px;

            }

            .nome1 {
                margin: auto;
                display: flex;
                flex-direction: column;
            }

            .nome1 br {
                display: none;
            }

            .numero {
                margin: auto;
                display: flex;
                flex-direction: column;
            }

            .numero br {
                display: none;
            }

            .numero input {
                width: 300px;
            }

            .nome3 {
                margin: auto;
                display: flex;
                flex-direction: column;
            }

            .nome3 br {
                display: none;
            }

            .nome3 textarea {
                width: 300px;
            }

            footer {
                width: 100%;
                height: 160px;
            }

            input {
                width: 300px;
            }

            header img {
                margin-bottom: 15px;
            }

            header .items nav ul li {
                display: none;
            }

            header span {
                display: grid;
            }

            .open {
                display: block;
            }
        }
    </style>
    <header>
        <img src="logo.png" alt="logotipo" class="logo" width="189" height="60">
        <div class="items">
            <nav>
                <ul>
                    <li>
                        <a href="#" class="link-active">Página Inicial</a>
                    </li>
                    <li>
                        <a href="#about">Sobre Nós</a>
                    </li>
                    <li>
                        <a href="#services">Serviços</a>
                    </li>
                    <li>
                        <a href="#contact">Fale Connosco</a>
                    </li>
                    <li>
                        <a href="agendar.php">
                            <button id="terminar">Agendar</button>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">Terminar Sessão</a>
                    </li>
                </ul>
        </div>
        </nav>

        <span id="btn1" onclick="ShowMenubar()">
            <svg class="svg-inline--fa fa-bars" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars"
                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                <path fill="currentColor"
                    d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z">
                </path>
            </svg>
        </span>

    </header>

    <nav class="mobile_menu">
        <ul>
            <li>
                <a href="#" class="link-active">Página Inicial</a>
            </li>
            <li>
                <a href="#about">Sobre Nós</a>
            </li>
            <li>
                <a href="#services">Serviços</a>
            </li>
            <li>
                <a href="#contact">Fale Connosco</a>
            </li>
            <li>
                <a href="agendar.php">
                    <button id="terminar">Agendar</button>
                </a>
            </li>
        </ul>
    </nav>


    <main>
        <div class="landing">
            <div class="landing-img">
                <img width="380" height="380" src="home.png" alt="consultora" class="consultora-img">
            </div>
            <div class="landing-text">
                <h1 class="landing-h1">Ter uma idéia é certo <br> consultar é correcto</h1>
                <br><br>
                <p class="landing-p">
                    Transforme ideias em ações com facilidade. Nosso sistema de <br>
                    agendamento conecta você aos melhores consultores de maneira <br>
                    rápida, organizada e eficiente.
                </p>
                <br>
            </div>
        </div>
    </main>
    <div class="consultoria">
        <div class="consultoria-container">
            <h2>Consultorias</h2>
            <div class="consultoria-text">
                <h1 class="consultoria-h1">Ter uma idéia é certo <br>
                    consultar é correcto</h1>
                <p class="consultoria-p">
                    Agende sessões, gerencie compromissos e alcance <br>
                    seus objetivos com praticidade e confiança.
                </p>
            </div>
            <!-- <button class="ver-mais">Ver mais</button> -->
        </div>
        <div class="consultoria-img">
            <img src="home1.png" alt="Consultores" class="img-consultores" width="380" height="380">
        </div>
    </div>
    <div class="lista">
        <div class="lista-g">
            <li>* Gestão de Pessoas</li>
            <li>* Gestão de RH</li>
            <li>* Gestão Empresarial</li>
            <li>* Gestão de Projectos</li>
            <li>* E-Commerce</li>
        </div>
        <div class="lista-e">
            <li>* Engenharia Informática</li>
            <li>* Engenharia Eléctrica</li>
            <li>* Engenharia Mecânica</li>
            <li>* Engenharia Literária</li>
            <li>* Marketing Digital</li>
        </div>
    </div>
    <div class="sobre" id="about">
        <div class="sobre-text">
            <h2>Sobre Nós</h2>
        </div>
        <div class="sobre-img">
            <img src="pc.png" alt="Consultores" class="img-consultores" width="580" height="300">
            <div class="sobre-texto">
                <div class="sobre-text">
                    <h4>Consultoria de Responsabilidade Social</h4> <br>
                    <p class="sobre-p">
                        Planejamento e implementação de ações sociais em comunidades. <br>
                        Planejamento, desenvolvimento e otimização de lojas virtuais.
                    </p>
                </div>
                <div class="sobre-text1">
                    <h4>Consultoria de Responsabilidade Social</h4> <br>
                    <p class="sobre-p1">
                        Otimização de recursos e processos em instituições de saúde. <br>
                        Programas de saúde ocupacional e mental para empresas.
                    </p>
                </div>

                <div class="sobre-text1">
                    <h4>Consultoria de Responsabilidade Social</h4> <br>
                    <p class="sobre-p1">
                        Otimização de recursos e processos em instituições de saúde. <br>
                        Programas de saúde ocupacional e mental para empresas.
                    </p>
                </div>

            </div>
        </div>
    </div>
    <div class="servicos" id="services">
        <h2>Serviços</h2>

        <div class="servicos-container">
            <div class="servicos-item">
                <div class="servicos-header">
                    <svg class="svg" width="20px" height="20px" viewBox="0 0 17 17" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path
                            d="M9.644 8.5l-6.854 6.854-0.707-0.707 6.146-6.147-6.146-6.146 0.707-0.708 6.854 6.854zM7.634 1.646l-0.707 0.708 6.146 6.146-6.146 6.146 0.707 0.707 6.853-6.853-6.853-6.854z"
                            fill="#000000" />
                    </svg>
                    <h3>Agendamento de Consultorias</h3>
                </div>
                <div class="servicos-content">
                    <p>
                        Esse serviço permite que clientes e consultores marquem reuniões de forma prática e organizada.<br>
                        Os consultores podem oferecer horários disponíveis, enquanto os clientes escolhem o melhor

                        momento para a sessão.<br>
                        O sistema pode incluir lembretes automáticos, pagamentos online e
                        personalização conforme a área de atuação do consultor.

                    </p>
                </div>
            </div>
            <div class="servicos-item">
                <div class="servicos-header">
                    <svg class="svg" width="20px" height="20px" viewBox="0 0 17 17" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path
                            d="M9.644 8.5l-6.854 6.854-0.707-0.707 6.146-6.147-6.146-6.146 0.707-0.708 6.854 6.854zM7.634 1.646l-0.707 0.708 6.146 6.146-6.146 6.146 0.707 0.707 6.853-6.853-6.853-6.854z"
                            fill="#000000" />
                    </svg>
                    <h3>Implementação Geral</h3>
                </div>
                <div class="servicos-content">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
                        optio illum dolores modi at ad minima raesentium.

                        Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
                        optio illum dolores modi at ad minima raesentium.
                    </p>
                </div>
            </div>
            <div class="servicos-item">
                <div class="servicos-header">
                    <svg class="svg" width="20px" height="20px" viewBox="0 0 17 17" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path
                            d="M9.644 8.5l-6.854 6.854-0.707-0.707 6.146-6.147-6.146-6.146 0.707-0.708 6.854 6.854zM7.634 1.646l-0.707 0.708 6.146 6.146-6.146 6.146 0.707 0.707 6.853-6.853-6.853-6.854z"
                            fill="#000000" />
                    </svg>
                    <h3>Estratégica de Marketing</h3>
                </div>
                <div class="servicos-content">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
                        optio illum dolores modi at ad minima raesentium.

                        Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
                        optio illum dolores modi at ad minima raesentium.
                    </p>
                </div>
            </div>
            <div class="servicos-item">
                <div class="servicos-header">
                    <svg class="svg" width="20px" height="20px" viewBox="0 0 17 17" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path
                            d="M9.644 8.5l-6.854 6.854-0.707-0.707 6.146-6.147-6.146-6.146 0.707-0.708 6.854 6.854zM7.634 1.646l-0.707 0.708 6.146 6.146-6.146 6.146 0.707 0.707 6.853-6.853-6.853-6.854z"
                            fill="#000000" />
                    </svg>
                    <h3>Estratégica de Negócio</h3>
                </div>
                <div class="servicos-content">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
                        optio illum dolores modi at ad minima raesentium.

                        Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
                        optio illum dolores modi at ad minima raesentium.
                    </p>
                </div>
            </div>
            <div class="servicos-i">
                <img src="home4.png" alt="image" class="img-servicos">
            </div>
        </div>
    </div>

    <div class="contacto" id="contact">
        <div class="contacto-h1">
            <h2>Fale Connosco</h2>
        </div>

        <div class="prim">
            <form method="post">
                <div class="nome1">
                    <label>Nome Completo</label>
                    <br>
                    <input type="text" placeholder="Nome Completo" required>
                </div>
                <div class="numero">
                    <label for="">Número de Telefone</label><br>
                    <input type="number" class="form-input" placeholder="Telefone" required>
                </div>

                <div class="nome3">
                    <label for="">Sua Mensagem</label><br>
                    <textarea placeholder="Escreva aqui a sua mensagem!" required></textarea>
                </div>
                <input type="submit" value="Enviar">
            </form>
            <img src="contact.png" class="img-contacto" alt="contato">
        </div>
    </div>
    <footer class="text-center py-4">
        <p class="mb-0 text-info">ANGOCONSULT &copy; <?php echo date('Y'); ?> - Todos Direitos Reservados</p>
        <small class="text-muted">Endereço: Av. Deolinda Rodrigues, Luanda - ANGOLA, Município de Viana, Distrito da
            Estalagem</small>
    </footer>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        const btnAgendar = document.getElementById("btn-agendar")
        btnAgendar.addEventListener("click", () => {
            location.href = "agendar.php"
        })
        const agendar = document.getElementById("agendar")
        agendar.addEventListener("click", () => {
            location.href = "agendar.php"
        })
    </script>

    <script>
        document.querySelectorAll('.servicos-header').forEach(header => {
            header.addEventListener('click', function() {

                this.classList.toggle('active');

                const content = this.nextElementSibling;
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var progressBar = document.getElementById('progress-bar');
            progressBar.style.width = '50%';

            window.addEventListener('load', function() {
                setTimeout(function() {
                    progressBar.style.display = 'none';
                }, 500);
            });
        });
    </script>

    <script>
        function ShowMenubar() {
            let div = document.querySelector(".mobile_menu")
            let btn_bar = document.getElementById("btn1")
            if (div.classList.contains('open')) {
                div.classList.remove('open')
                btn_bar.innerHTML = ' <svg class="svg-inline--fa fa-bars" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"></path></svg>'
            } else {
                div.classList.add('open')
                btn_bar.innerHTML = '<svg class="svg-inline--fa fa-x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="x" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"></path></svg>'
            }
        }

        if (Number(document.body.style.maxWidth) > 768) {
            let div = document.querySelector('.mobile_menu')
            if (div.classList.contains('open')) {
                div.classList.remove('open')
            }
        }
    </script>
</body>

</html>