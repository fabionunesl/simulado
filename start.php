<?php
session_start();

// Limpa qualquer sessão anterior para iniciar um novo simulado
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início do Simulado</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #ff6600;
        }
        p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .button {
            padding: 15px 30px;
            font-size: 18px;
            color: #fff;
            background-color: #ff6600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #e65c00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Simulado</h1>
        <p>Teste seus conhecimentos respondendo a perguntas cronometradas.</p>
        <form action="index.php" method="post">
            <input type="submit" class="button" value="Iniciar Simulado">
        </form>
    </div>
</body>
</html>
